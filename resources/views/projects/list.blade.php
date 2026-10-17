<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Projects - Arbeit Technology</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&family=DM+Sans:wght@600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-surface-variant": "#45474c",
                        "on-surface": "#1b1b1d",
                        "secondary": "#006972",
                        "status-success": "#10B981",
                        "primary": "#091426",
                        "inverse-primary": "#bcc7de",
                        "primary-fixed-dim": "#bcc7de",
                        "surface-tint": "#545f73",
                        "outline-variant": "#c5c6cd",
                        "surface-container-lowest": "#ffffff",
                        "status-neutral": "#94A3B8",
                        "surface-subtle": "#F8FAFC",
                        "secondary-container": "#86effc",
                        "surface": "#fbf8fa",
                        "primary-container": "#1e293b",
                        "on-background": "#1b1b1d",
                        "status-warning": "#F59E0B",
                        "on-primary-fixed": "#111c2d",
                        "border-light": "#E2E8F0",
                        "status-error": "#EF4444",
                        "status-info": "#3B82F6",
                        "on-primary": "#ffffff",
                        "surface-container": "#f0edef"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem"
                    },
                    "fontFamily": {
                        "label-md": ["Hanken Grotesk"],
                        "headline-md": ["DM Sans"],
                        "body-md": ["Hanken Grotesk"],
                        "headline-lg": ["DM Sans"]
                    },
                    "boxShadow": {
                        "soft": "0 2px 8px 0 rgba(30, 41, 59, 0.04)"
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .glass-card {
                @apply bg-surface-container-lowest border border-border-light shadow-soft rounded-lg;
            }
        }
        body {
            font-size: 13px;
        }
    </style>
</head>
<body class="bg-surface-subtle text-on-surface font-body-md h-screen flex flex-col md:flex-row overflow-hidden">

<!-- Mobile Top Bar (Shown on Mobile) -->
<header class="bg-primary text-on-primary flex md:hidden items-center justify-between px-4 h-14 shrink-0 z-30 shadow-md">
    <div class="flex items-center space-x-2.5">
        <button type="button" onclick="toggleMobileSidebar()" class="p-1.5 -ml-1 rounded-md hover:bg-white/10 focus:outline-none cursor-pointer">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>
        <img class="h-8 w-auto rounded-md object-contain bg-white p-1" src="{{ asset('images/logo.png') }}" alt="Logo"/>
        <div>
            <h1 class="font-bold text-xs text-on-primary leading-tight">Lead & Project Management System</h1>
            <p class="text-[10px] text-cyan-400 font-medium">Projects Directory</p>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Backdrop Overlay -->
<div id="mobileBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

<!-- SideNavBar Drawer -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col bg-primary text-on-primary h-full w-60 shadow-xl md:shadow-md py-6 px-3 space-y-1.5 z-50 md:z-20 shrink-0">
    <div class="mb-6 px-1 flex flex-col space-y-2.5">
        <div class="flex items-center justify-between w-full">
            <div class="bg-white rounded-xl p-2.5 flex items-center justify-center flex-1 min-w-0 shadow-sm">
                <img class="h-12 w-auto max-w-full object-contain" src="{{ asset('images/logo.png') }}" alt="Logo"/>
            </div>
            <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-white/70 hover:text-white p-1 ml-1.5 shrink-0">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="min-w-0">
            <h1 class="font-headline-md text-xs font-bold text-cyan-400 leading-snug">Lead & Project Management System</h1>
        </div>
    </div>
    <nav class="flex-1 space-y-1.5 overflow-y-auto pr-1">
        <!-- Dashboard -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-75 hover:opacity-100 transition-all rounded-md hover:bg-white/10" href="{{ route('projects.index') }}">
            <img src="{{ asset('images/icons/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 mr-2.5 object-contain shrink-0"/>
            <span class="font-label-md text-xs">Dashboard</span>
        </a>
        <!-- Add New Project -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-75 hover:opacity-100 transition-all rounded-md hover:bg-white/10" href="{{ route('projects.create') }}">
            <img src="{{ asset('images/icons/add-project.png') }}" alt="Add New Project" class="w-5 h-5 mr-2.5 object-contain shrink-0"/>
            <span class="font-label-md text-xs">Add New Project</span>
        </a>
        <!-- Projects (Active) -->
        <a class="flex items-center px-3 py-2.5 bg-primary-container text-white rounded-md transition-transform duration-200 ease-in-out hover:bg-primary-fixed-dim/10 font-semibold shadow-xs" href="{{ route('projects.list') }}">
            <img src="{{ asset('images/icons/projects.png') }}" alt="Projects" class="w-5 h-5 mr-2.5 object-contain shrink-0"/>
            <span class="font-label-md text-xs text-cyan-300">Projects</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-75 hover:opacity-100 transition-all rounded-md hover:bg-white/10" href="{{ route('leads.index') }}">
            <img src="{{ asset('images/icons/leads.png') }}" alt="Lead Tracking" class="w-5 h-5 mr-2.5 object-contain shrink-0"/>
            <span class="font-label-md text-xs">Lead Tracking</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-75 hover:opacity-100 transition-all rounded-md hover:bg-white/10" href="{{ route('invoices.create') }}">
            <img src="{{ asset('images/icons/receipt.png') }}" alt="Money Receipt" class="w-5 h-5 mr-2.5 object-contain shrink-0"/>
            <span class="font-label-md text-xs">Money Receipt</span>
        </a>
    </nav>
</aside>

<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-surface-subtle">

    <!-- TopAppBar -->
    <header class="bg-surface border-b border-border-light flex justify-between sm:justify-end items-center w-full px-4 sm:px-5 h-14 shrink-0 z-10 shadow-sm">
        <div class="flex items-center space-x-2 md:hidden">
            <span class="font-bold text-xs text-primary uppercase tracking-wider">Projects Directory</span>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Search Form -->
            <form action="{{ route('projects.list') }}" method="GET" class="relative">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}"/>
                @endif
                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px]">search</span>
                <input name="search" value="{{ request('search') }}" class="pl-8 pr-3 py-1.5 bg-white border border-border-light rounded-full focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-xs w-48 sm:w-60" placeholder="Search projects or clients..." type="text"/>
            </form>
            <a href="{{ route('projects.create') }}" class="px-3 py-1.5 bg-primary text-on-primary rounded text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined mr-1 text-[16px]">add</span> Add New Project
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" title="Logout" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 rounded text-xs font-semibold transition-colors flex items-center shadow-2xs cursor-pointer">
                    <span class="material-symbols-outlined mr-1 text-[16px]">logout</span> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Scrollable Body Canvas -->
    <div class="flex-1 overflow-y-auto p-4 md:p-6 custom-scrollbar">
        <div class="max-w-[1440px] mx-auto space-y-5">

            <!-- Success Flash Message -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-xs flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- PAGE HEADER WITH UPPER-RIGHT STATUS FILTER DROPDOWN -->
            <div class="glass-card p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">folder_copy</span>
                        <h2 class="text-lg font-bold text-primary font-headline-md tracking-tight">All Projects</h2>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-semibold text-[11px]">
                            {{ $projects->total() }} Projects
                        </span>
                    </div>
                    <p class="text-slate-500 text-xs mt-1">Manage, filter, and track status for all client software projects.</p>
                </div>

                <!-- UPPER RIGHT STATUS FILTER DROPDOWN CONTAINER -->
                <div class="flex items-center gap-2 self-stretch sm:self-auto shrink-0">
                    <form action="{{ route('projects.list') }}" method="GET" id="statusFilterForm" class="flex items-center gap-2">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}"/>
                        @endif
                        <label for="statusFilter" class="text-xs font-medium text-slate-600 flex items-center gap-1 shrink-0">
                            <span class="material-symbols-outlined text-slate-400 text-[16px]">filter_list</span> Filter Status:
                        </label>
                        <div class="relative">
                            <select id="statusFilter" name="status" onchange="this.form.submit()" class="pl-3 pr-8 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-300 rounded-lg text-xs font-semibold text-slate-800 shadow-2xs focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer appearance-none">
                                <option value="all" {{ ($selectedStatus == 'all' || !$selectedStatus) ? 'selected' : '' }}>
                                    All Statuses ({{ $totalCount }})
                                </option>
                                <option value="In Progress" {{ $selectedStatus == 'In Progress' ? 'selected' : '' }}>
                                    In Progress ({{ $inProgressCount }})
                                </option>
                                <option value="Hold" {{ ($selectedStatus == 'Hold' || $selectedStatus == 'On Hold') ? 'selected' : '' }}>
                                    Hold / On Hold ({{ $onHoldCount }})
                                </option>
                                <option value="Cancelled" {{ $selectedStatus == 'Cancelled' ? 'selected' : '' }}>
                                    Cancelled ({{ $cancelledCount }})
                                </option>
                                <option value="Completed" {{ $selectedStatus == 'Completed' ? 'selected' : '' }}>
                                    Completed ({{ $completedCount }})
                                </option>
                                <option value="Testing" {{ $selectedStatus == 'Testing' ? 'selected' : '' }}>
                                    Testing / Review ({{ $testingCount }})
                                </option>
                            </select>
                            <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-500 text-[18px] pointer-events-none">expand_more</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- QUICK FILTER PILL TABS -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 custom-scrollbar">
                <a href="{{ route('projects.list', array_merge(request()->except('status', 'page'))) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ (!$selectedStatus || $selectedStatus == 'all') ? 'bg-primary text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span>All</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ (!$selectedStatus || $selectedStatus == 'all') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $totalCount }}</span>
                </a>

                <a href="{{ route('projects.list', array_merge(request()->except('status', 'page'), ['status' => 'In Progress'])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ $selectedStatus == 'In Progress' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span class="h-2 w-2 rounded-full bg-blue-400"></span>
                    <span>In Progress</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedStatus == 'In Progress' ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-700' }}">{{ $inProgressCount }}</span>
                </a>

                <a href="{{ route('projects.list', array_merge(request()->except('status', 'page'), ['status' => 'Hold'])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ ($selectedStatus == 'Hold' || $selectedStatus == 'On Hold') ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                    <span>Hold</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ ($selectedStatus == 'Hold' || $selectedStatus == 'On Hold') ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-700' }}">{{ $onHoldCount }}</span>
                </a>

                <a href="{{ route('projects.list', array_merge(request()->except('status', 'page'), ['status' => 'Cancelled'])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ $selectedStatus == 'Cancelled' ? 'bg-rose-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                    <span>Cancelled</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedStatus == 'Cancelled' ? 'bg-white/20 text-white' : 'bg-rose-50 text-rose-700' }}">{{ $cancelledCount }}</span>
                </a>

                <a href="{{ route('projects.list', array_merge(request()->except('status', 'page'), ['status' => 'Completed'])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 flex items-center gap-1.5 {{ $selectedStatus == 'Completed' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    <span>Completed</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $selectedStatus == 'Completed' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-700' }}">{{ $completedCount }}</span>
                </a>
            </div>

            <!-- PROJECTS DATA TABLE CARD -->
            <div class="glass-card overflow-hidden">
                @if($projects->count() > 0)
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse text-xs min-w-[850px]">
                            <thead>
                                <tr class="bg-surface-subtle border-b border-border-light text-on-surface-variant font-bold uppercase tracking-wider text-[11px]">
                                    <th class="px-4 py-3 border-r border-border-light">Project</th>
                                    <th class="px-4 py-3 border-r border-border-light">Client</th>
                                    <th class="px-4 py-3 border-r border-border-light">Manager</th>
                                    <th class="px-4 py-3 border-r border-border-light">Status</th>
                                    <th class="px-4 py-3 border-r border-border-light">Priority</th>
                                    <th class="px-4 py-3 border-r border-border-light">Delivery</th>
                                    <th class="px-4 py-3 border-r border-border-light">Total Cost</th>
                                    <th class="px-4 py-3 text-right w-28">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light bg-white">
                                @foreach($projects as $p)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <!-- Project Name & Stack -->
                                        <td class="px-4 py-3 align-middle border-r border-border-light">
                                            <a href="{{ route('projects.show', $p->id) }}" class="font-semibold text-slate-900 hover:text-cyan-700 hover:underline block text-xs">
                                                {{ $p->project_name }}
                                            </a>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @if($p->stack_frontend)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200/80">
                                                        {{ $p->stack_frontend }}
                                                    </span>
                                                @endif
                                                @if($p->stack_backend)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                                        {{ $p->stack_backend }}
                                                    </span>
                                                @endif
                                                @if($p->stack_database)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                        {{ $p->stack_database }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Client -->
                                        <td class="px-4 py-3 align-middle text-on-surface-variant font-medium whitespace-nowrap text-xs border-r border-border-light">
                                            {{ $p->client_name }}
                                        </td>

                                        <!-- Manager -->
                                        <td class="px-4 py-3 align-middle font-medium text-slate-700 whitespace-nowrap text-xs border-r border-border-light">
                                            {{ $p->project_manager ?: 'Unassigned' }}
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="px-4 py-3 align-middle whitespace-nowrap border-r border-border-light">
                                            @if($p->status === 'Completed')
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Completed
                                                </span>
                                            @elseif($p->status === 'In Progress')
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200/80">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                                                    In Progress
                                                </span>
                                            @elseif($p->status === 'Testing')
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                    Testing / Review
                                                </span>
                                            @elseif($p->status === 'On Hold' || $p->status === 'Hold')
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/80">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    On Hold
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    {{ $p->status }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Priority -->
                                        <td class="px-4 py-3 align-middle whitespace-nowrap border-r border-border-light">
                                            @if($p->priority === 'High')
                                                <span class="inline-flex items-center text-[11px] font-semibold text-rose-600"><span class="material-symbols-outlined text-[14px] mr-1 text-rose-500">keyboard_double_arrow_up</span> High</span>
                                            @elseif($p->priority === 'Urgent')
                                                <span class="inline-flex items-center text-[11px] font-semibold text-amber-600"><span class="material-symbols-outlined text-[14px] mr-1 text-amber-500">warning</span> Urgent</span>
                                            @else
                                                <span class="inline-flex items-center text-[11px] font-medium text-slate-500"><span class="material-symbols-outlined text-[14px] mr-1 text-slate-400">remove</span> Normal</span>
                                            @endif
                                        </td>

                                        <!-- Target Delivery -->
                                        <td class="px-4 py-3 align-middle text-on-surface-variant font-medium whitespace-nowrap text-xs border-r border-border-light">
                                            {{ \Carbon\Carbon::parse($p->target_delivery_date)->format('M d, Y') }}
                                        </td>

                                        <!-- Total Cost -->
                                        <td class="px-4 py-3 align-middle font-bold text-slate-900 whitespace-nowrap text-xs border-r border-border-light">
                                            {{ $p->total_cost ?? 'N/A' }}
                                        </td>

                                        <!-- Action Buttons -->
                                        <td class="px-4 py-3 align-middle text-right whitespace-nowrap w-28">
                                            <div class="inline-flex items-center justify-end gap-1.5">
                                                <a href="{{ route('projects.show', $p->id) }}" title="View Project Details" class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-50 hover:bg-primary hover:text-white text-slate-600 transition-all border border-slate-200 shadow-2xs">
                                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                                </a>
                                                <a href="{{ route('projects.edit', $p->id) }}" title="Edit Project" class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50/80 hover:bg-amber-500 hover:text-white text-amber-700 transition-all border border-amber-200/80 shadow-2xs">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </a>
                                                <form action="{{ route('projects.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project documentation?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Delete Project" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50/80 hover:bg-rose-600 hover:text-white text-rose-600 transition-all border border-rose-200/80 shadow-2xs cursor-pointer">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Footer -->
                    @if($projects->hasPages())
                        <div class="p-4 border-t border-border-light bg-slate-50 flex justify-between items-center">
                            {{ $projects->links() }}
                        </div>
                    @endif

                @else
                    <!-- EMPTY STATE -->
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200 shadow-inner">
                            <span class="material-symbols-outlined text-[32px]">folder_off</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 font-headline-md">No Projects Found</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                            @if($selectedStatus && $selectedStatus !== 'all')
                                No projects match the status filter <strong class="text-slate-700">"{{ $selectedStatus }}"</strong>.
                            @elseif(request('search'))
                                No projects match your search query <strong class="text-slate-700">"{{ request('search') }}"</strong>.
                            @else
                                You haven't added any project documentation yet.
                            @endif
                        </p>
                        <div class="mt-5 flex items-center justify-center gap-3">
                            @if($selectedStatus || request('search'))
                                <a href="{{ route('projects.list') }}" class="px-3.5 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-xs font-semibold hover:bg-slate-50 transition shadow-2xs">
                                    Clear Filters
                                </a>
                            @endif
                            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-xs font-semibold hover:bg-primary/90 transition shadow-sm inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">add</span> Add New Project
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</main>

<script>
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('mobileBackdrop');
        if (sidebar) sidebar.classList.toggle('-translate-x-full');
        if (backdrop) backdrop.classList.toggle('hidden');
    }
</script>
</body>
</html>
