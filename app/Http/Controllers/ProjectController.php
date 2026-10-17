<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $query = Project::with(['teams', 'finances', 'revisions', 'changeRequests', 'infrastructure']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('project_manager', 'like', "%{$search}%")
                  ->orWhere('project_type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate(5)->withQueryString();

        // Optimized single-query status counts map
        $groupedCounts = DB::table('projects')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalProjects = array_sum($groupedCounts);
        $activeProjects = $groupedCounts['In Progress'] ?? 0;
        $completedProjects = $groupedCounts['Completed'] ?? 0;
        $pendingProjects = ($groupedCounts['Not Started'] ?? 0) + ($groupedCounts['On Hold'] ?? 0) + ($groupedCounts['Hold'] ?? 0);

        $statusCounts = [
            'Not Started' => $groupedCounts['Not Started'] ?? 0,
            'In Progress' => $groupedCounts['In Progress'] ?? 0,
            'Client Review' => $groupedCounts['Testing'] ?? 0,
            'Revision' => $groupedCounts['Revision'] ?? 0,
            'Completed' => $groupedCounts['Completed'] ?? 0,
            'On Hold' => ($groupedCounts['On Hold'] ?? 0) + ($groupedCounts['Hold'] ?? 0),
        ];

        // Total Cost Calculation from Project records
        $allProjectsCost = Project::select('id', 'total_cost')->get();
        $totalCostSum = 0;
        foreach ($allProjectsCost as $p) {
            if ($p->total_cost) {
                $val = (float) preg_replace('/[^0-9.]/', '', $p->total_cost);
                $totalCostSum += $val;
            }
        }

        // Outstanding Dues for Active Projects
        $runningProjects = Project::with('finances:id,project_id,amount,status')
            ->select('id', 'total_cost', 'status')
            ->whereIn('status', ['In Progress', 'Testing', 'Revision', 'Not Started', 'On Hold', 'Hold'])
            ->get();

        $runningDueSum = 0;
        foreach ($runningProjects as $p) {
            $dueMilestones = $p->finances->where('status', 'Due');
            if ($dueMilestones->count() > 0) {
                foreach ($dueMilestones as $fm) {
                    $runningDueSum += (float) preg_replace('/[^0-9.]/', '', $fm->amount);
                }
            } else {
                $paidSum = 0;
                foreach ($p->finances->where('status', 'Paid') as $fm) {
                    $paidSum += (float) preg_replace('/[^0-9.]/', '', $fm->amount);
                }
                $tot = (float) preg_replace('/[^0-9.]/', '', $p->total_cost);
                $runningDueSum += max(0, $tot - $paidSum);
            }
        }

        // Upcoming Deadlines (nearest target delivery dates)
        $upcomingDeadlines = Project::select('id', 'project_name', 'client_name', 'target_delivery_date', 'status', 'priority')
            ->whereNotNull('target_delivery_date')
            ->orderBy('target_delivery_date', 'asc')
            ->take(3)
            ->get();

        return view('projects.index', compact(
            'projects',
            'totalProjects',
            'activeProjects',
            'completedProjects',
            'pendingProjects',
            'totalCostSum',
            'runningDueSum',
            'statusCounts',
            'upcomingDeadlines'
        ));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated(), $request);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Arbeit Technology project documentation saved successfully!');
    }

    public function show(Project $project)
    {
        $project->load(['teams', 'finances', 'revisions', 'changeRequests', 'infrastructure']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load(['teams', 'finances', 'revisions', 'changeRequests', 'infrastructure']);
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->projectService->updateProject($project, $request->validated(), $request);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Arbeit Technology project documentation updated successfully!');
    }

    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            $project->delete();
        });

        return redirect()->route('projects.index')
            ->with('success', 'Project documentation deleted successfully!');
    }

    public function list(Request $request)
    {
        $query = Project::with(['teams', 'finances']);

        // Search Filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('project_manager', 'like', "%{$search}%")
                  ->orWhere('project_type', 'like', "%{$search}%")
                  ->orWhere('stack_frontend', 'like', "%{$search}%")
                  ->orWhere('stack_backend', 'like', "%{$search}%");
            });
        }

        // Status Filter
        $selectedStatus = $request->input('status');
        if (!empty($selectedStatus) && $selectedStatus !== 'all') {
            if ($selectedStatus === 'Hold' || $selectedStatus === 'On Hold') {
                $query->whereIn('status', ['On Hold', 'Hold']);
            } else {
                $query->where('status', $selectedStatus);
            }
        }

        $projects = $query->latest()->paginate(12)->withQueryString();

        // Optimized status breakdown
        $groupedCounts = DB::table('projects')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $totalCount = array_sum($groupedCounts);
        $inProgressCount = $groupedCounts['In Progress'] ?? 0;
        $onHoldCount = ($groupedCounts['On Hold'] ?? 0) + ($groupedCounts['Hold'] ?? 0);
        $cancelledCount = $groupedCounts['Cancelled'] ?? 0;
        $completedCount = $groupedCounts['Completed'] ?? 0;
        $testingCount = $groupedCounts['Testing'] ?? 0;

        return view('projects.list', compact(
            'projects',
            'selectedStatus',
            'totalCount',
            'inProgressCount',
            'onHoldCount',
            'cancelledCount',
            'completedCount',
            'testingCount'
        ));
    }
}
