<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard - Arbeit Technology</title>
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
                        "on-tertiary-container": "#a38c6a",
                        "secondary": "#006972",
                        "status-success": "#10B981",
                        "primary": "#091426",
                        "inverse-primary": "#bcc7de",
                        "primary-fixed-dim": "#bcc7de",
                        "surface-tint": "#545f73",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed-variant": "#564427",
                        "outline-variant": "#c5c6cd",
                        "surface-container-lowest": "#ffffff",
                        "surface-dim": "#dcd9db",
                        "status-neutral": "#94A3B8",
                        "surface-subtle": "#F8FAFC",
                        "secondary-container": "#86effc",
                        "surface": "#fbf8fa",
                        "secondary-fixed": "#8af2ff",
                        "secondary-fixed-dim": "#6cd6e2",
                        "primary-container": "#1e293b",
                        "on-background": "#1b1b1d",
                        "tertiary-fixed": "#fadfb8",
                        "status-warning": "#F59E0B",
                        "tertiary-container": "#35260c",
                        "on-primary-fixed": "#111c2d",
                        "on-error-container": "#93000a",
                        "on-secondary-fixed": "#001f23",
                        "on-primary-fixed-variant": "#3c475a",
                        "tertiary-fixed-dim": "#ddc39d",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#d8e3fb",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#271902",
                        "surface-container": "#f0edef",
                        "on-primary-container": "#8590a6",
                        "error": "#ba1a1a",
                        "inverse-on-surface": "#f3f0f2",
                        "surface-bright": "#fbf8fa",
                        "outline": "#75777d",
                        "border-light": "#E2E8F0",
                        "status-error": "#EF4444",
                        "on-tertiary": "#ffffff",
                        "background": "#fbf8fa",
                        "surface-container-low": "#f5f3f4",
                        "surface-container-highest": "#e4e2e3",
                        "inverse-surface": "#303032",
                        "status-info": "#3B82F6",
                        "surface-container-high": "#eae7e9",
                        "surface-variant": "#e4e2e3",
                        "on-secondary-fixed-variant": "#004f56",
                        "on-secondary": "#ffffff",
                        "tertiary": "#1e1200",
                        "on-secondary-container": "#006d77"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-margin": "20px",
                        "card-padding": "16px",
                        "input-padding-y": "8px",
                        "gutter": "16px",
                        "unit": "4px",
                        "input-padding-x": "12px",
                        "section-gap": "20px"
                    },
                    "fontFamily": {
                        "label-md": ["Hanken Grotesk"],
                        "headline-md": ["DM Sans"],
                        "body-md": ["Hanken Grotesk"],
                        "body-lg": ["Hanken Grotesk"],
                        "headline-lg": ["DM Sans"],
                        "label-bold": ["Hanken Grotesk"],
                        "body-sm": ["Hanken Grotesk"],
                        "headline-xl": ["DM Sans"]
                    },
                    "fontSize": {
                        "label-md": ["13px", { "lineHeight": "1", "fontWeight": "500" }],
                        "headline-md": ["16px", { "lineHeight": "1.3", "fontWeight": "600" }],
                        "body-md": ["13px", { "lineHeight": "1.4", "fontWeight": "400" }],
                        "body-lg": ["15px", { "lineHeight": "1.5", "fontWeight": "400" }],
                        "headline-lg": ["22px", { "lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-bold": ["11px", { "lineHeight": "1", "letterSpacing": "0.03em", "fontWeight": "600" }],
                        "body-sm": ["12px", { "lineHeight": "1.4", "fontWeight": "400" }],
                        "headline-xl": ["26px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }]
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
            <p class="text-[10px] text-cyan-400 font-medium">Dashboard</p>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Backdrop Overlay -->
<div id="mobileBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

<!-- SideNavBar Drawer -->
<aside id="sidebar" class="fixed md:relative inset-y-0 left-0 md:inset-auto transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out flex flex-col bg-slate-900 text-white h-full w-52 border-r border-slate-800 shadow-xl md:shadow-none py-6 px-3 space-y-1.5 z-50 md:z-20 shrink-0">
    <!-- Floating Edge Collapse/Expand Toggle Button (Desktop Only) -->
    <button type="button" 
            onclick="toggleDesktopSidebar()" 
            id="desktopCollapseBtn"
            class="hidden md:flex absolute -right-3 top-7 z-30 w-6 h-6 rounded-full bg-slate-900 border border-slate-700/90 text-slate-300 hover:text-white hover:bg-slate-800 shadow-md items-center justify-center transition-all duration-200 hover:scale-110 focus:outline-none cursor-pointer" 
            title="Toggle Sidebar (Collapse / Expand)">
        <span class="material-symbols-outlined text-[16px] transition-transform duration-200" id="sidebarCollapseIcon">chevron_left</span>
    </button>

    <div class="mb-6 px-1 flex flex-col space-y-2.5 sidebar-header-wrapper transition-all">
        <div class="flex items-center justify-between w-full">
            <div class="bg-white rounded-xl p-2 flex items-center justify-center w-full min-w-0 shadow-sm sidebar-logo transition-all">
                <img class="h-11 w-auto max-w-full object-contain" src="{{ asset('images/logo.png') }}" alt="Logo"/>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-white/70 hover:text-white p-1 ml-1.5 shrink-0 cursor-pointer" title="Close Sidebar">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="min-w-0 sidebar-text-group transition-all">
            <h1 class="font-headline-md text-xs font-bold text-cyan-400 leading-snug">Lead & Project Management System</h1>
        </div>
    </div>
    <nav class="flex-1 space-y-1.5 overflow-y-auto pr-1">
        <!-- Active Tab: Dashboard -->
        <a class="flex items-center px-3 py-2.5 bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 rounded-lg transition-all font-semibold shadow-xs group" href="{{ route('projects.index') }}" title="Dashboard">
            <img src="{{ asset('images/icons/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs text-cyan-300 font-semibold sidebar-text whitespace-nowrap">Dashboard</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.create') }}" title="Add New Project">
            <img src="{{ asset('images/icons/add-project.png') }}" alt="Add New Project" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Add New Project</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.list') }}" title="Projects">
            <img src="{{ asset('images/icons/projects.png') }}" alt="Projects" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Projects</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('leads.index') }}" title="Lead Tracking">
            <img src="{{ asset('images/icons/leads.png') }}" alt="Lead Tracking" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Lead Tracking</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('accounts.index') }}" title="Accounts">
            <span class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-cyan-400 mr-2.5 sidebar-icon shrink-0">account_balance_wallet</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Accounts</span>
        </a>
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('invoices.create') }}" title="Money Receipt">
            <img src="{{ asset('images/icons/receipt.png') }}" alt="Money Receipt" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Money Receipt</span>
        </a>
    </nav>
</aside>

<!-- Main Content Area -->
<main class="flex-1 flex flex-col min-h-0 min-w-0 overflow-hidden bg-surface-subtle">

    <!-- TopAppBar -->
    <header class="bg-surface border-b border-border-light flex justify-between sm:justify-end items-center w-full px-4 sm:px-5 h-14 shrink-0 z-10 shadow-sm">
        <div class="flex items-center space-x-2 md:hidden">
            <span class="font-bold text-xs text-primary uppercase tracking-wider">Dashboard</span>
        </div>
        <div class="flex items-center space-x-2 sm:space-x-3">
            <!-- Search -->
            <form action="{{ route('projects.index') }}" method="GET" class="relative hidden sm:block">
                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-outline text-[16px]">search</span>
                <input name="search" value="{{ request('search') }}" class="pl-8 pr-3 py-1.5 bg-surface-container-lowest border border-border-light rounded-full focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all text-xs w-44 sm:w-56" placeholder="Search projects..." type="text"/>
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

    <!-- Scrollable Canvas -->
    <div class="flex-1 overflow-y-auto p-3 sm:p-5 custom-scrollbar">
        <div class="max-w-[1440px] mx-auto space-y-4 sm:space-y-5">

            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-3.5 py-2 rounded-md flex justify-between items-center text-xs">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold text-emerald-900 ml-2">✕</button>
                </div>
            @endif

            <!-- Summary Cards Bento Grid (2 Per Line on Mobile) -->
            <section class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-2.5 sm:gap-4">
                <!-- Total Projects -->
                <div class="glass-card p-3 sm:p-4 flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-[11px] sm:text-xs font-medium text-on-surface-variant leading-tight">Total Projects</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">folder</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-on-surface leading-none mb-1">{{ $totalProjects }}</div>
                        <div class="flex items-center text-status-success text-[10px] sm:text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px] mr-0.5">trending_up</span>
                            <span class="truncate">Recorded Projects</span>
                        </div>
                    </div>
                </div>

                <!-- Active Projects -->
                <div class="glass-card p-3 sm:p-4 flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-[11px] sm:text-xs font-medium text-on-surface-variant leading-tight">Active Projects</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-status-info/10 flex items-center justify-center text-status-info shrink-0">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">play_circle</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-on-surface leading-none mb-1">{{ $activeProjects }}</div>
                        <div class="flex items-center text-status-info text-[10px] sm:text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px] mr-0.5">sync</span>
                            <span class="truncate">In Progress</span>
                        </div>
                    </div>
                </div>

                <!-- Completed Projects -->
                <div class="glass-card p-3 sm:p-4 flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-[11px] sm:text-xs font-medium text-on-surface-variant leading-tight">Completed Projects</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-status-success/10 flex items-center justify-center text-status-success shrink-0">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">check_circle</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-on-surface leading-none mb-1">{{ $completedProjects }}</div>
                        <div class="flex items-center text-status-success text-[10px] sm:text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px] mr-0.5">trending_up</span>
                            <span class="truncate">Handed Over</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Projects -->
                <div class="glass-card p-3 sm:p-4 flex flex-col justify-between">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-[11px] sm:text-xs font-medium text-on-surface-variant leading-tight">Pending Projects</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-status-warning/10 flex items-center justify-center text-status-warning shrink-0">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">pending</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-bold text-on-surface leading-none mb-1">{{ $pendingProjects }}</div>
                        <div class="flex items-center text-status-warning text-[10px] sm:text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px] mr-0.5">error_outline</span>
                            <span class="truncate">Not Started / Hold</span>
                        </div>
                    </div>
                </div>

                <!-- Running Project Due (Spans 2 cols on small mobile if 5th item) -->
                <div class="glass-card p-3 sm:p-4 flex flex-col justify-between col-span-2 md:col-span-1">
                    <div class="flex justify-between items-start mb-1.5">
                        <span class="text-[11px] sm:text-xs font-medium text-on-surface-variant leading-tight">Running Project Due</span>
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">payments</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-xl font-bold text-rose-600 leading-none mb-1 truncate">{{ number_format($runningDueSum) }} BDT</div>
                        <div class="flex items-center text-rose-600 text-[10px] sm:text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px] mr-0.5">pending_actions</span>
                            <span class="truncate">Outstanding Receivable</span>
                        </div>
                </div>
            </section>

            <!-- Middle Section: Chart & Deadlines -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Project Status Overview -->
                <div class="glass-card p-4 lg:col-span-2 flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-sm text-on-surface">Project Status Overview</h3>
                        <a href="{{ route('projects.index') }}" class="text-primary hover:bg-surface-container-low px-2.5 py-1 rounded transition-colors text-xs font-medium flex items-center">
                            Refresh Data <span class="material-symbols-outlined ml-1 text-[16px]">refresh</span>
                        </a>
                    </div>
                    <div class="flex-1 flex flex-col md:flex-row items-center justify-center gap-6 py-2">
                        <!-- Donut Chart Circle -->
                        <div class="relative w-36 h-36 rounded-full border-[12px] border-surface-container-highest flex items-center justify-center shrink-0">
                            <div class="absolute inset-0 rounded-full border-[12px] border-primary" style="clip-path: polygon(50% 50%, 50% 0, 100% 0, 100% 100%, 0 100%, 0 50%); transform: rotate(45deg);"></div>
                            <div class="absolute inset-0 rounded-full border-[12px] border-status-success" style="clip-path: polygon(50% 50%, 0 50%, 0 0, 50% 0); transform: rotate(15deg);"></div>
                            <div class="absolute inset-0 rounded-full border-[12px] border-status-info" style="clip-path: polygon(50% 50%, 50% 0, 100% 0, 100% 50%); transform: rotate(-30deg);"></div>
                            <div class="text-center bg-surface-container-lowest w-24 h-24 rounded-full absolute flex flex-col items-center justify-center shadow-inner">
                                <span class="text-xl font-bold text-on-surface leading-none mb-0.5">{{ $totalProjects }}</span>
                                <span class="text-[11px] text-on-surface-variant font-medium">Total Projects</span>
                            </div>
                        </div>
                        <!-- Legend -->
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2.5 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-surface-container-highest"></div>
                                <span class="text-on-surface-variant font-medium">Not Started ({{ $statusCounts['Not Started'] }})</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                                <span class="text-on-surface-variant font-medium">In Progress ({{ $statusCounts['In Progress'] }})</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-status-info"></div>
                                <span class="text-on-surface-variant font-medium">Client Review ({{ $statusCounts['Client Review'] }})</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-status-warning"></div>
                                <span class="text-on-surface-variant font-medium">Revision ({{ $statusCounts['Revision'] }})</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-status-success"></div>
                                <span class="text-on-surface-variant font-medium">Completed ({{ $statusCounts['Completed'] }})</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-status-error"></div>
                                <span class="text-on-surface-variant font-medium">On Hold ({{ $statusCounts['On Hold'] }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Deadlines -->
                <div class="glass-card p-4 flex flex-col">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-sm text-on-surface">Upcoming Deadlines</h3>
                    </div>
                    <div class="space-y-2.5 flex-1 overflow-y-auto pr-1">
                        @forelse($upcomingDeadlines->take(3) as $deadline)
                            @php
                                $dDate = \Carbon\Carbon::parse($deadline->target_delivery_date);
                            @endphp
                            <a href="{{ route('projects.show', $deadline->id) }}" class="flex items-start space-x-3 p-2 hover:bg-surface-subtle rounded-md transition-colors border border-transparent hover:border-border-light block">
                                <div class="bg-status-info/10 text-status-info rounded-md p-1.5 text-center min-w-[3.2rem]">
                                    <div class="font-bold uppercase text-[9px] leading-tight">{{ $dDate->format('M') }}</div>
                                    <div class="text-base font-bold leading-none mt-0.5">{{ $dDate->format('d') }}</div>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-medium text-xs text-on-surface truncate">{{ $deadline->project_name }}</h4>
                                    <p class="text-[11px] text-on-surface-variant truncate">Client: {{ $deadline->client_name }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-slate-500 italic p-3 text-center">No upcoming delivery deadlines recorded.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Bottom Section: Projects Table -->
            <section class="glass-card flex flex-col">
                <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-border-light bg-surface-container-lowest rounded-t gap-3">
                    <h3 class="font-semibold text-sm text-on-surface">Master Projects Directory</h3>
                    <div class="flex space-x-2 w-full sm:w-auto justify-end">
                        <a href="{{ route('projects.create') }}" class="px-3 py-1.5 bg-primary text-on-primary rounded text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center shadow-sm">
                            <span class="material-symbols-outlined mr-1.5 text-[16px]">add</span> New Project
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse text-xs border-b border-border-light min-w-[850px]">
                        <thead>
                            <tr class="bg-surface-subtle border-b border-border-light text-on-surface-variant font-bold uppercase tracking-wider text-[11px]">
                                <th class="px-4 py-3 border-r border-border-light">Project</th>
                                <th class="px-4 py-3 border-r border-border-light">Client</th>
                                <th class="px-4 py-3 border-r border-border-light">Manager</th>
                                <th class="px-4 py-3 border-r border-border-light">Status</th>
                                <th class="px-4 py-3 border-r border-border-light">Priority</th>
                                <th class="px-4 py-3 border-r border-border-light">Delivery</th>
                                <th class="px-4 py-3 border-r border-border-light">Total Cost</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light">
                            @forelse($projects as $project)
                                <tr class="hover:bg-surface-subtle/50 transition-colors group">
                                    <!-- Project Name & Stack -->
                                    <td class="px-4 py-3 align-middle border-r border-border-light">
                                        <a href="{{ route('projects.show', $project->id) }}" class="font-semibold text-slate-900 hover:text-cyan-700 hover:underline block text-xs">
                                            {{ $project->project_name }}
                                        </a>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @if($project->stack_frontend)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-sky-50 text-sky-700 border border-sky-200/80">
                                                    {{ $project->stack_frontend }}
                                                </span>
                                            @endif
                                            @if($project->stack_backend)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                                    {{ $project->stack_backend }}
                                                </span>
                                            @endif
                                            @if($project->stack_database)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                    {{ $project->stack_database }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Client -->
                                    <td class="px-4 py-3 align-middle text-on-surface-variant font-medium whitespace-nowrap text-xs border-r border-border-light">
                                        {{ $project->client_name }}
                                    </td>

                                    <!-- Manager -->
                                    <td class="px-4 py-3 align-middle font-medium text-slate-700 whitespace-nowrap text-xs border-r border-border-light">
                                        {{ $project->project_manager }}
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-4 py-3 align-middle whitespace-nowrap border-r border-border-light">
                                        @if($project->status === 'Completed')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Completed
                                            </span>
                                        @elseif($project->status === 'In Progress')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                                                In Progress
                                            </span>
                                        @elseif($project->status === 'Testing')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                Testing / Review
                                            </span>
                                        @elseif($project->status === 'On Hold')
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/80">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                On Hold
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                {{ $project->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Priority -->
                                    <td class="px-4 py-3 align-middle whitespace-nowrap border-r border-border-light">
                                        @if($project->priority === 'High')
                                            <span class="inline-flex items-center text-[11px] font-semibold text-rose-600"><span class="material-symbols-outlined text-[14px] mr-1 text-rose-500">keyboard_double_arrow_up</span> High</span>
                                        @elseif($project->priority === 'Urgent')
                                            <span class="inline-flex items-center text-[11px] font-semibold text-amber-600"><span class="material-symbols-outlined text-[14px] mr-1 text-amber-500">warning</span> Urgent</span>
                                        @else
                                            <span class="inline-flex items-center text-[11px] font-medium text-slate-500"><span class="material-symbols-outlined text-[14px] mr-1 text-slate-400">remove</span> Normal</span>
                                        @endif
                                    </td>

                                    <!-- Delivery -->
                                    <td class="px-4 py-3 align-middle text-on-surface-variant font-medium whitespace-nowrap text-xs border-r border-border-light">
                                        {{ \Carbon\Carbon::parse($project->target_delivery_date)->format('M d, Y') }}
                                    </td>

                                    <!-- Total Cost -->
                                    <td class="px-4 py-3 align-middle font-bold text-slate-900 whitespace-nowrap text-xs border-r border-border-light">
                                        {{ $project->total_cost ?? 'N/A' }}
                                    </td>

                                     <!-- Action Buttons -->
                                     <td class="px-4 py-3 align-middle text-right whitespace-nowrap w-28">
                                         <div class="inline-flex items-center justify-end gap-1.5">
                                             <a href="{{ route('projects.show', $project->id) }}" title="View Project Details" class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-50 hover:bg-primary hover:text-white text-slate-600 transition-all border border-slate-200 shadow-2xs">
                                                 <span class="material-symbols-outlined text-[18px]">visibility</span>
                                             </a>
                                             <a href="{{ route('projects.edit', $project->id) }}" title="Edit Project" class="w-8 h-8 rounded-lg flex items-center justify-center bg-amber-50/80 hover:bg-amber-500 hover:text-white text-amber-700 transition-all border border-amber-200/80 shadow-2xs">
                                                 <span class="material-symbols-outlined text-[18px]">edit</span>
                                             </a>
                                             <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project documentation?')">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit" title="Delete Project" class="w-8 h-8 rounded-lg flex items-center justify-center bg-rose-50/80 hover:bg-rose-600 hover:text-white text-rose-600 transition-all border border-rose-200/80 shadow-2xs cursor-pointer">
                                                     <span class="material-symbols-outlined text-[18px]">delete</span>
                                                 </button>
                                             </form>
                                         </div>
                                     </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-slate-500 italic text-xs">
                                        No projects found. Click "New Project" to create one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-t border-border-light flex flex-col sm:flex-row justify-between items-center text-on-surface-variant text-xs rounded-b bg-surface-container-lowest gap-2">
                    <span>Showing {{ $projects->firstItem() ?? 0 }} to {{ $projects->lastItem() ?? 0 }} of {{ $projects->total() }} entries</span>
                    <div>
                        {{ $projects->links() }}
                    </div>
                </div>
            </section>

        </div>

        <!-- Footer -->
        <footer class="w-full py-2 px-5 text-center sm:text-left bg-surface-subtle border-t border-border-light mt-2 text-[11px] text-slate-500 shrink-0">
            <span>© {{ date('Y') }} Arbeit Technology. Confidential Internal Project Management System.</span>
        </footer>
    </div>
</main>
<script>
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('mobileBackdrop');
        if (!sidebar) return;
        const isHidden = sidebar.classList.contains('-translate-x-full');
        if (isHidden) {
            sidebar.classList.remove('-translate-x-full');
            if (window.innerWidth < 768) {
                setSidebarCollapsed(false, false);
            }
            if (backdrop) backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            if (backdrop) backdrop.classList.add('hidden');
        }
    }

    function toggleDesktopSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (!sidebar) return;

        if (window.innerWidth < 768) {
            // On mobile: collapse button slides drawer away
            sidebar.classList.add('-translate-x-full');
            const backdrop = document.getElementById('mobileBackdrop');
            if (backdrop) backdrop.classList.add('hidden');
        } else {
            // On desktop: toggle rail
            const isCollapsed = sidebar.classList.contains('w-16');
            setSidebarCollapsed(!isCollapsed, true);
        }
    }

    function setSidebarCollapsed(collapse, saveToStorage = true) {
        const sidebar = document.getElementById('sidebar');
        if (!sidebar) return;
        const textGroup = sidebar.querySelector('.sidebar-text-group');
        const logo = sidebar.querySelector('.sidebar-logo');
        const headerWrapper = sidebar.querySelector('.sidebar-header-wrapper');
        const texts = sidebar.querySelectorAll('.sidebar-text');
        const icons = sidebar.querySelectorAll('.sidebar-icon');
        const sidebarCollapseIcon = document.getElementById('sidebarCollapseIcon');

        if (collapse) {
            sidebar.classList.remove('w-52', 'px-3');
            sidebar.classList.add('w-16', 'px-2');
            if (textGroup) textGroup.classList.add('hidden');
            if (logo) logo.classList.add('hidden');
            if (headerWrapper) {
                headerWrapper.classList.remove('justify-between');
                headerWrapper.classList.add('justify-center');
            }
            texts.forEach(t => t.classList.add('hidden'));
            icons.forEach(i => {
                i.classList.remove('mr-2.5');
                i.classList.add('mx-auto');
            });
            if (sidebarCollapseIcon) sidebarCollapseIcon.innerText = 'chevron_right';
            if (saveToStorage && window.innerWidth >= 768) {
                localStorage.setItem('sidebar_collapsed', 'true');
            }
        } else {
            sidebar.classList.remove('w-16', 'px-2');
            sidebar.classList.add('w-52', 'px-3');
            if (textGroup) textGroup.classList.remove('hidden');
            if (logo) logo.classList.remove('hidden');
            if (headerWrapper) {
                headerWrapper.classList.remove('justify-center');
                headerWrapper.classList.add('justify-between');
            }
            texts.forEach(t => t.classList.remove('hidden'));
            icons.forEach(i => {
                i.classList.remove('mx-auto');
                i.classList.add('mr-2.5');
            });
            if (sidebarCollapseIcon) sidebarCollapseIcon.innerText = 'chevron_left';
            if (saveToStorage && window.innerWidth >= 768) {
                localStorage.setItem('sidebar_collapsed', 'false');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.innerWidth >= 768 && localStorage.getItem('sidebar_collapsed') === 'true') {
            setSidebarCollapsed(true, false);
        }
    });
</script>
</body>
</html>
