<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    /**
     * Store a new project and its related models atomically.
     */
    public function createProject(array $validatedData, Request $request): Project
    {
        return DB::transaction(function () use ($validatedData, $request) {
            $quotationFile = $this->handleQuotationUpload($request);

            $handoverChecklist = [
                'chk_1' => $request->has('chk_1'),
                'chk_2' => $request->has('chk_2'),
                'chk_3' => $request->has('chk_3'),
                'chk_4' => $request->has('chk_4'),
            ];

            $project = Project::create([
                'project_name' => $validatedData['project_name'],
                'project_type' => $validatedData['project_type'] ?? 'Laravel Web App',
                'client_name' => $validatedData['client_name'],
                'client_phone' => $validatedData['client_phone'] ?? null,
                'client_email' => $validatedData['client_email'] ?? null,
                'project_manager' => $validatedData['project_manager'] ?? '',
                'start_date' => $validatedData['start_date'],
                'target_delivery_date' => $validatedData['target_delivery_date'],
                'status' => $validatedData['status'] ?? 'In Progress',
                'priority' => $validatedData['priority'] ?? 'Normal',
                'quotation_file' => $quotationFile,
                'total_cost' => $validatedData['total_cost'] ?? null,
                'stack_frontend' => $validatedData['stack_frontend'] ?? null,
                'stack_backend' => $validatedData['stack_backend'] ?? null,
                'stack_database' => $validatedData['stack_database'] ?? null,
                'support_period' => $validatedData['support_period'] ?? null,
                'support_expiry' => $validatedData['support_expiry'] ?? null,
                'handover_checklist' => $handoverChecklist,
            ]);

            $this->saveProjectRelations($project, $request);

            return $project;
        });
    }

    /**
     * Update an existing project and sync its related models atomically.
     */
    public function updateProject(Project $project, array $validatedData, Request $request): Project
    {
        return DB::transaction(function () use ($project, $validatedData, $request) {
            $quotationFile = $this->handleQuotationUpload($request, $project->quotation_file);

            $handoverChecklist = [
                'chk_1' => $request->has('chk_1'),
                'chk_2' => $request->has('chk_2'),
                'chk_3' => $request->has('chk_3'),
                'chk_4' => $request->has('chk_4'),
            ];

            $project->update([
                'project_name' => $validatedData['project_name'],
                'project_type' => $validatedData['project_type'] ?? 'Laravel Web App',
                'client_name' => $validatedData['client_name'],
                'client_phone' => $validatedData['client_phone'] ?? null,
                'client_email' => $validatedData['client_email'] ?? null,
                'project_manager' => $validatedData['project_manager'] ?? $project->project_manager ?? '',
                'start_date' => $validatedData['start_date'],
                'target_delivery_date' => $validatedData['target_delivery_date'],
                'status' => $validatedData['status'] ?? 'In Progress',
                'priority' => $validatedData['priority'] ?? 'Normal',
                'quotation_file' => $quotationFile,
                'total_cost' => $validatedData['total_cost'] ?? null,
                'stack_frontend' => $validatedData['stack_frontend'] ?? null,
                'stack_backend' => $validatedData['stack_backend'] ?? null,
                'stack_database' => $validatedData['stack_database'] ?? null,
                'support_period' => $validatedData['support_period'] ?? null,
                'support_expiry' => $validatedData['support_expiry'] ?? null,
                'handover_checklist' => $handoverChecklist,
            ]);

            // Refresh relations
            $project->teams()->delete();
            $project->finances()->delete();
            $project->revisions()->delete();
            $project->changeRequests()->delete();
            if ($project->infrastructure) {
                $project->infrastructure()->delete();
            }

            $this->saveProjectRelations($project, $request);

            return $project;
        });
    }

    /**
     * Handle PDF quotation upload safely using Storage public disk with backward compatibility.
     */
    private function handleQuotationUpload(Request $request, ?string $existingFile = null): ?string
    {
        $quotationFile = $request->input('quotation_file', $existingFile);

        if ($request->hasFile('quotation_file_pdf')) {
            $pdf = $request->file('quotation_file_pdf');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $pdf->getClientOriginalName());

            // Save to storage/app/public/quotations
            $path = $pdf->storeAs('quotations', $filename, 'public');
            $quotationFile = 'storage/' . $path;

            // Also copy to public/uploads/quotations for legacy fallback if public dir isn't symlinked yet
            $destinationDir = public_path('uploads/quotations');
            if (!file_exists($destinationDir)) {
                @mkdir($destinationDir, 0755, true);
            }
            @copy($pdf->getRealPath(), $destinationDir . '/' . $filename);
        }

        return $quotationFile;
    }

    /**
     * Save/Sync all related child entities (teams, finances, revisions, change requests, infrastructure).
     */
    public function saveProjectRelations(Project $project, Request $request): void
    {
        // 1. Team Allocation
        $pmFound = null;
        if ($request->has('team_roles') && is_array($request->team_roles)) {
            foreach ($request->team_roles as $i => $role) {
                $member = $request->team_members[$i] ?? null;
                $responsibility = $request->team_responsibilities[$i] ?? null;
                if (!empty($member)) {
                    $project->teams()->create([
                        'role' => $role ?? 'Developer',
                        'team_member' => $member,
                        'responsibility' => $responsibility,
                    ]);

                    if (strtolower(trim($role)) === 'project manager') {
                        $pmFound = $member;
                    }
                }
            }
        } else {
            // Legacy fallbacks
            if ($request->filled('lead_dev') || $request->filled('lead_developer')) {
                $project->teams()->create([
                    'role' => 'Assigned Developer',
                    'team_member' => $request->lead_dev ?? $request->lead_developer,
                    'responsibility' => 'System Architecture & Full Stack Development'
                ]);
            }
            if ($request->filled('frontend_dev')) {
                $project->teams()->create([
                    'role' => 'Developer 2',
                    'team_member' => $request->frontend_dev,
                    'responsibility' => 'Tailwind & Blade Views'
                ]);
            }
            if ($request->filled('db_dev')) {
                $project->teams()->create([
                    'role' => 'Developer 3',
                    'team_member' => $request->db_dev,
                    'responsibility' => 'Eloquent & Database API'
                ]);
            }
        }

        if ($pmFound) {
            $project->update(['project_manager' => $pmFound]);
        }

        // 2. Financial Records / Milestones
        $numericTotalCost = (float) preg_replace('/[^0-9.]/', '', $request->total_cost ?? 0);
        if ($request->has('milestone_names') && is_array($request->milestone_names)) {
            foreach ($request->milestone_names as $i => $name) {
                $amount = $request->milestone_amounts[$i] ?? null;
                $datePaid = $request->milestone_dates[$i] ?? null;
                $status = $request->milestone_statuses[$i] ?? 'Due';

                if (!empty($name) || !empty($amount)) {
                    $project->finances()->create([
                        'quotation_file_name' => $project->quotation_file,
                        'total_cost' => $numericTotalCost,
                        'milestone_name' => $name ?? 'Payment Milestone',
                        'amount' => $amount,
                        'date_paid' => $datePaid,
                        'status' => $status,
                    ]);
                }
            }
        } else {
            // Fallback for legacy inputs
            if ($request->filled('adv_amount') || $request->filled('adv_date') || $request->has('adv_status')) {
                $project->finances()->create([
                    'quotation_file_name' => $project->quotation_file,
                    'total_cost' => $numericTotalCost,
                    'milestone_name' => 'Advance / Initial Payment',
                    'amount' => $request->adv_amount,
                    'date_paid' => $request->adv_date,
                    'status' => $request->has('adv_status') ? 'Paid' : 'Due',
                ]);
            }

            if ($request->filled('final_amount') || $request->filled('final_date') || $request->has('final_status')) {
                $project->finances()->create([
                    'quotation_file_name' => $project->quotation_file,
                    'total_cost' => $numericTotalCost,
                    'milestone_name' => 'Final Delivery Payment',
                    'amount' => $request->final_amount,
                    'date_paid' => $request->final_date,
                    'status' => $request->has('final_status') ? 'Paid' : 'Due',
                ]);
            }
        }

        // 3. Revision Logs
        for ($i = 1; $i <= 30; $i++) {
            if ($request->filled("rev_desc_$i") || $request->filled("rev_date_$i")) {
                $project->revisions()->create([
                    'request_date' => $request->input("rev_date_$i"),
                    'description' => $request->input("rev_desc_$i", 'Revision requested'),
                    'status' => $request->has("rev_status_$i") || $request->input("rev_status_$i") === 'Done' ? 'Done' : 'Open',
                ]);
            }
        }

        // 4. Change Requests
        for ($i = 1; $i <= 30; $i++) {
            if ($request->filled("extra_desc_$i") || $request->filled("extra_date_$i")) {
                $project->changeRequests()->create([
                    'request_date' => $request->input("extra_date_$i"),
                    'feature_description' => $request->input("extra_desc_$i", 'Scope change'),
                    'extra_cost' => $request->input("extra_cost_$i", '0'),
                    'is_approved' => $request->has("extra_app_$i") || $request->input("extra_app_$i") === 'Yes' ? 'Yes' : 'No',
                    'status' => 'Pending',
                ]);
            }
        }

        // 5. Infrastructure & Credentials
        $extraCredentials = [];
        if ($request->has('cred_titles') && is_array($request->cred_titles)) {
            foreach ($request->cred_titles as $i => $title) {
                $user = $request->cred_usernames[$i] ?? null;
                $pass = $request->cred_passwords[$i] ?? null;
                $notes = $request->cred_notes[$i] ?? null;

                if (!empty($title) || !empty($user) || !empty($pass) || !empty($notes)) {
                    $extraCredentials[] = [
                        'title' => $title ?? 'Additional Credential',
                        'username' => $user,
                        'password' => $pass,
                        'notes' => $notes,
                    ];
                }
            }
        }

        if ($request->filled('domain_url') || $request->filled('domain_provider') || $request->filled('domain_user') || $request->filled('hosting_provider') || $request->filled('hosting_user') || $request->filled('server_ip') || $request->filled('panel_url') || !empty($extraCredentials)) {
            $project->infrastructure()->create([
                'domain_url' => $request->domain_url,
                'domain_provider' => $request->domain_provider,
                'domain_user' => $request->domain_user,
                'domain_pass' => $request->domain_pass,
                'hosting_provider' => $request->hosting_provider,
                'hosting_user' => $request->hosting_user,
                'hosting_pass' => $request->hosting_pass,
                'server_ip' => $request->server_ip,
                'panel_url' => $request->panel_url,
                'extra_credentials' => $extraCredentials,
            ]);
        }
    }
}
