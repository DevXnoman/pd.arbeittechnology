<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadNote;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        // Get all distinct campaign months ordered by most recent lead incoming date or created_at
        $campaigns = Lead::select('campaign_month', DB::raw('MAX(lead_incoming_date) as max_date'))
            ->whereNotNull('campaign_month')
            ->where('campaign_month', '!=', '')
            ->groupBy('campaign_month')
            ->orderBy('max_date', 'desc')
            ->pluck('campaign_month')
            ->toArray();

        $currentMonth = date('F Y');
        if (empty($campaigns)) {
            $campaigns = [$currentMonth];
        } elseif (!in_array($currentMonth, $campaigns)) {
            array_unshift($campaigns, $currentMonth);
        }

        // Default to most recent campaign tab if not specified
        $selectedCampaign = $request->input('campaign');
        if (!$selectedCampaign) {
            $selectedCampaign = $campaigns[0] ?? $currentMonth;
        }

        // If user switched to or created a new campaign tab, ensure it appears in the tabs list
        if ($selectedCampaign && $selectedCampaign !== 'all' && !in_array($selectedCampaign, $campaigns)) {
            $campaigns[] = $selectedCampaign;
        }

        $query = Lead::with('notes');

        // Campaign filter (unless user selected 'all')
        if ($selectedCampaign && $selectedCampaign !== 'all') {
            $query->where('campaign_month', $selectedCampaign);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('niche', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
            });
        }

        $leads = $query->orderBy('id', 'asc')->get();

        // Calculate KPI Metrics for selected view
        $metricsQuery = Lead::query();
        if ($selectedCampaign && $selectedCampaign !== 'all') {
            $metricsQuery->where('campaign_month', $selectedCampaign);
        }
        $totalLeads = (clone $metricsQuery)->count();
        $convertedCount = (clone $metricsQuery)->where(function($q) {
            $q->where('status', 'like', '%won%')
              ->orWhere('status', 'like', '%converted%')
              ->orWhere('status', 'like', '%sold%')
              ->orWhereNotNull('project_id');
        })->count();

        // Exact allowed tech stack choices matching Google Sheets dropdown
        $allowedTechStacks = [
            'WordPress' => ['bg' => 'bg-sky-600 text-white', 'pill' => 'bg-sky-100 text-sky-800 border-sky-300'],
            'Laravel' => ['bg' => 'bg-amber-600 text-white', 'pill' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'MERN' => ['bg' => 'bg-rose-600 text-white', 'pill' => 'bg-rose-100 text-rose-800 border-rose-300'],
            'Mobile app' => ['bg' => 'bg-emerald-600 text-white', 'pill' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'Digital Marketing' => ['bg' => 'bg-purple-600 text-white', 'pill' => 'bg-purple-100 text-purple-800 border-purple-300'],
        ];

        return view('leads.index', compact(
            'leads',
            'campaigns',
            'selectedCampaign',
            'totalLeads',
            'convertedCount',
            'allowedTechStacks'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'nullable|string|max:255',
            'niche' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'work_scope' => 'nullable|array',
            'lead_incoming_date' => 'nullable|date',
            'quoted_amount' => 'nullable|string|max:255',
            'sold_amount' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'campaign_month' => 'required|string|max:255',
            'assigned_to' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['client_name'])) {
            $validated['client_name'] = 'New Client';
        }
        if (empty($validated['contact_number'])) {
            $validated['contact_number'] = '-';
        }
        if ($validated['campaign_month'] === 'all') {
            $validated['campaign_month'] = date('F Y');
        }
        if (empty($validated['lead_incoming_date'])) {
            $validated['lead_incoming_date'] = null;
        }
        if (empty($validated['status'])) {
            $validated['status'] = 'New Lead';
        }

        try {
            $lead = Lead::create($validated);
        } catch (\Exception $e) {
            // Fallback if MySQL columns have not yet been changed to nullable
            if (str_contains($e->getMessage(), 'lead_incoming_date')) {
                $validated['lead_incoming_date'] = now()->toDateString();
                $lead = Lead::create($validated);
            } elseif (str_contains($e->getMessage(), 'contact_number')) {
                $validated['contact_number'] = '-';
                $lead = Lead::create($validated);
            } else {
                throw $e;
            }
        }

        if (!empty($validated['note'])) {
            LeadNote::create([
                'lead_id' => $lead->id,
                'note_content' => $validated['note'],
                'logged_by' => Auth::user()->name ?? 'System',
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'lead' => $lead]);
        }

        return redirect()->route('leads.index', ['campaign' => $lead->campaign_month])
            ->with('success', 'New row added successfully!');
    }

    public function show(Lead $lead)
    {
        $lead->load(['notes', 'project']);
        return view('leads.show', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'client_name' => 'nullable|string|max:255',
            'niche' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'work_scope' => 'nullable|array',
            'lead_incoming_date' => 'nullable|date',
            'quoted_amount' => 'nullable|string|max:255',
            'sold_amount' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'campaign_month' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        $lead->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'lead' => $lead]);
        }

        return redirect()->route('leads.index', ['campaign' => $lead->campaign_month])
            ->with('success', 'Lead updated successfully!');
    }

    public function quickUpdate(Request $request, Lead $lead)
    {
        try {
            $validated = $request->validate([
                'client_name' => 'nullable|string|max:255',
                'niche' => 'nullable|string|max:255',
                'contact_number' => 'nullable|string|max:255',
                'work_scope' => 'nullable|array',
                'lead_incoming_date' => 'nullable|date',
                'status' => 'nullable|string|max:255',
                'note' => 'nullable|string',
                'quoted_amount' => 'nullable|string|max:255',
                'sold_amount' => 'nullable|string|max:255',
            ]);

            if ($request->has('work_scope')) {
                $validated['work_scope'] = is_array($request->work_scope) ? array_values(array_filter($request->work_scope)) : [];
            }

            if (array_key_exists('contact_number', $validated) && empty($validated['contact_number'])) {
                $validated['contact_number'] = '-';
            }

            if (array_key_exists('lead_incoming_date', $validated)) {
                if (empty($validated['lead_incoming_date'])) {
                    $validated['lead_incoming_date'] = null;
                }
            }

            try {
                $lead->update($validated);
            } catch (\Exception $e) {
                // In case the column in MySQL is not nullable yet
                if (str_contains($e->getMessage(), 'lead_incoming_date')) {
                    $validated['lead_incoming_date'] = now()->toDateString();
                    $lead->update($validated);
                } elseif (str_contains($e->getMessage(), 'contact_number')) {
                    $validated['contact_number'] = '-';
                    $lead->update($validated);
                } else {
                    throw $e;
                }
            }

            if (array_key_exists('note', $validated) && !empty($validated['note'])) {
                LeadNote::create([
                    'lead_id' => $lead->id,
                    'note_content' => 'Note updated: ' . $validated['note'],
                    'logged_by' => Auth::user()->name ?? 'System',
                ]);
            }

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'lead' => $lead]);
            }

            return redirect()->back()->with('success', 'Row updated successfully!');
        } catch (\Throwable $e) {
            \Log::error('quickUpdate error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function addNote(Request $request, Lead $lead)
    {
        $request->validate([
            'note_content' => 'required|string',
        ]);

        $lead->notes()->create([
            'note_content' => $request->note_content,
            'logged_by' => Auth::user()->name ?? 'System',
        ]);

        $lead->update(['note' => $request->note_content]);

        return redirect()->back()->with('success', 'Follow-up note added!');
    }

    public function convertToProject(Request $request, Lead $lead)
    {
        if ($lead->project_id) {
            return redirect()->back()->with('error', 'This lead is already converted to a project!');
        }

        $cleanCost = preg_replace('/[^0-9.]/', '', $lead->sold_amount ?: $lead->quoted_amount ?: '0');

        $workScopeArray = is_array($lead->work_scope) ? $lead->work_scope : [];
        $backendStack = in_array('Laravel', $workScopeArray) ? 'Laravel' : (in_array('MERN', $workScopeArray) ? 'Node.js/Express' : 'PHP');
        $frontendStack = in_array('React', $workScopeArray) || in_array('MERN', $workScopeArray) ? 'React' : (in_array('WordPress', $workScopeArray) ? 'WordPress Elementor' : 'Blade / HTML');

        $project = Project::create([
            'project_name' => $lead->client_name . ($lead->niche ? ' - ' . $lead->niche : ' Project'),
            'project_type' => !empty($workScopeArray) ? implode(', ', $workScopeArray) : 'Web App',
            'client_name' => $lead->client_name,
            'client_phone' => $lead->contact_number,
            'client_email' => $lead->email,
            'project_manager' => $lead->assigned_to ?: 'Unassigned',
            'start_date' => now()->toDateString(),
            'target_delivery_date' => now()->addDays(30)->toDateString(),
            'status' => 'In Progress',
            'priority' => 'Normal',
            'total_cost' => $cleanCost ?: '0',
            'stack_frontend' => $frontendStack,
            'stack_backend' => $backendStack,
            'stack_database' => 'MySQL',
        ]);

        $lead->update([
            'status' => 'Won (Converted to Project)',
            'project_id' => $project->id,
            'sold_amount' => $lead->sold_amount ?: $lead->quoted_amount,
        ]);

        LeadNote::create([
            'lead_id' => $lead->id,
            'note_content' => '🎉 Converted lead into Project #' . $project->id . ': ' . $project->project_name,
            'logged_by' => Auth::user()->name ?? 'System',
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Lead successfully converted into a Project!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
            'campaign_month' => 'required|string|max:255',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        $importedCount = 0;

        while (($row = fgetcsv($file)) !== FALSE) {
            if (empty($row[0])) continue;

            $name = $row[0] ?? '';
            $niche = $row[1] ?? '';
            $contact = $row[2] ?? '';
            $workScopeRaw = $row[3] ?? '';
            $dateRaw = $row[4] ?? now()->toDateString();
            $quoted = $row[5] ?? '';
            $sold = $row[6] ?? '';
            $note = $row[7] ?? '';
            $status = $row[8] ?? ($note ? 'Follow-up' : 'New Lead');

            $workScopeArray = [];
            if ($workScopeRaw) {
                $tags = explode(',', str_replace(['/', ';'], ',', $workScopeRaw));
                foreach ($tags as $tag) {
                    $trimmed = trim($tag);
                    if ($trimmed) {
                        if (in_array(strtolower($trimmed), ['wordpress', 'wp'])) $workScopeArray[] = 'WordPress';
                        elseif (in_array(strtolower($trimmed), ['laravel'])) $workScopeArray[] = 'Laravel';
                        elseif (in_array(strtolower($trimmed), ['mern'])) $workScopeArray[] = 'MERN';
                        elseif (in_array(strtolower($trimmed), ['mobile app', 'app', 'flutter'])) $workScopeArray[] = 'Mobile app';
                        elseif (in_array(strtolower($trimmed), ['digital marketing', 'marketing'])) $workScopeArray[] = 'Digital Marketing';
                        else $workScopeArray[] = $trimmed;
                    }
                }
            }

            try {
                $incomingDate = date('Y-m-d', strtotime($dateRaw));
            } catch (\Exception $e) {
                $incomingDate = now()->toDateString();
            }

            Lead::create([
                'client_name' => $name,
                'niche' => $niche,
                'contact_number' => $contact,
                'work_scope' => array_values(array_unique($workScopeArray)),
                'lead_incoming_date' => $incomingDate,
                'quoted_amount' => $quoted,
                'sold_amount' => $sold,
                'note' => $note,
                'status' => $status,
                'campaign_month' => $request->campaign_month,
            ]);

            $importedCount++;
        }

        fclose($file);

        return redirect()->route('leads.index', ['campaign' => $request->campaign_month])
            ->with('success', "Successfully imported {$importedCount} leads!");
    }

    public function destroy(Request $request, Lead $lead)
    {
        $campaign = $lead->campaign_month;
        $lead->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('leads.index', ['campaign' => $campaign])
            ->with('success', 'Lead deleted successfully!');
    }
}
