<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lead Tracking Directory - Arbeit Technology</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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
            font-size: 12px;
        }
        td {
            position: relative;
        }
        /* True Google Sheets Crisp Gridlines */
        #leadsTable {
            border-collapse: collapse !important;
            border: 1px solid #cbd5e1 !important;
            width: 100%;
        }
        #leadsTable th, 
        #leadsTable td {
            border: 1px solid #cbd5e1 !important;
        }
        #leadsTable thead th {
            background-color: #f1f5f9 !important;
            border-bottom: 2px solid #94a3b8 !important;
            font-weight: 700;
        }
        #leadsTable tbody tr.sheet-row:hover td {
            background-color: #f8fafc;
        }
        /* Standard Compact Cell Inputs (Name, Phone, Date, Quoted, Sold) */
        .cell-input {
            width: 100%;
            height: 26px;
            background-color: transparent;
            border: 0;
            padding: 3px 6px;
            font-size: 11px;
            color: #1e293b;
            outline: none;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: text;
            display: block;
            line-height: 1.4;
        }
        .cell-input:focus {
            background-color: #ffffff;
            border: 1px solid #0284c7;
            border-radius: 4px;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2);
            outline: none;
        }

        /* Expanding Multi-line Textarea Cells (Niche, Note / Activity) */
        .cell-input-expand {
            width: 100%;
            height: 26px;
            background-color: transparent;
            border: 0;
            padding: 3px 6px;
            font-size: 11px;
            color: #1e293b;
            outline: none;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            resize: none;
            cursor: text;
            display: block;
            line-height: 1.4;
        }
        .cell-input-expand:focus {
            position: absolute;
            top: -2px;
            left: 50% !important;
            transform: translateX(-50%) !important;
            z-index: 60;
            width: 300px !important;
            max-width: calc(100vw - 32px) !important;
            height: 84px !important;
            background-color: #ffffff;
            box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.22), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 2px solid #0284c7;
            border-radius: 8px;
            padding: 6px 10px;
            white-space: pre-wrap !important;
            word-break: break-word !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            resize: none;
            outline: none;
            line-height: 1.45;
        }

        /* Expanding Status Cell (Status) */
        .cell-input-status {
            width: 100%;
            height: 26px;
            background-color: rgba(254, 243, 199, 0.7);
            border: 1px solid #fde68a;
            padding: 2px 6px;
            font-size: 11px;
            color: #0f172a;
            border-radius: 4px;
            font-weight: 600;
            outline: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            resize: none;
            cursor: text;
            display: block;
            line-height: 1.4;
        }
        .cell-input-status:focus {
            position: absolute;
            top: -2px;
            left: 50% !important;
            transform: translateX(-50%) !important;
            z-index: 60;
            width: 300px !important;
            max-width: calc(100vw - 32px) !important;
            height: 84px !important;
            background-color: #fffbeb;
            box-shadow: 0 12px 28px -5px rgba(0, 0, 0, 0.22), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border: 2px solid #f59e0b;
            border-radius: 8px;
            padding: 6px 10px;
            white-space: pre-wrap !important;
            word-break: break-word !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            resize: none;
            outline: none;
            line-height: 1.45;
        }
    </style>
</head>
<body class="bg-surface-subtle text-on-surface font-body-md h-screen flex flex-col md:flex-row overflow-hidden" onclick="closeAllPopovers(event)">

<!-- Floating Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 transform translate-y-[-100%] opacity-0 transition-all duration-300 pointer-events-none">
    <div class="bg-slate-900 text-white px-3.5 py-2 rounded-lg shadow-lg text-xs font-semibold flex items-center space-x-2 border border-slate-700">
        <span class="material-symbols-outlined text-emerald-400 text-[18px]">check_circle</span>
        <span id="toast-message">Saved</span>
    </div>
</div>

<!-- Mobile Top Bar -->
<header class="bg-primary text-on-primary flex md:hidden items-center justify-between px-4 h-14 shrink-0 z-30 shadow-md">
    <div class="flex items-center space-x-2.5">
        <button type="button" onclick="toggleMobileSidebar()" class="p-1.5 -ml-1 rounded-md hover:bg-white/10 focus:outline-none cursor-pointer">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>
        <img class="h-8 w-auto rounded-md object-contain bg-white p-1" src="{{ asset('images/logo.png') }}" alt="Logo"/>
        <div>
            <h1 class="font-bold text-xs text-on-primary leading-tight">Lead & Project Management System</h1>
            <p class="text-[10px] text-cyan-400 font-medium">Lead Tracking Directory</p>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Overlay -->
<div id="mobileBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

<!-- SideNavBar Drawer -->
<aside id="sidebar" class="fixed md:static inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out flex flex-col bg-primary text-on-primary h-full w-60 shadow-xl md:shadow-md py-6 px-3 space-y-1.5 z-50 md:z-20 shrink-0">
    <div class="mb-6 px-1 flex flex-col space-y-2.5 sidebar-header-wrapper transition-all">
        <div class="flex items-center justify-between w-full">
            <div class="bg-white rounded-xl p-2.5 flex items-center justify-center flex-1 min-w-0 shadow-sm sidebar-logo transition-all">
                <img class="h-12 w-auto max-w-full object-contain" src="{{ asset('images/logo.png') }}" alt="Logo"/>
            </div>
            <!-- Desktop Collapse Button -->
            <button type="button" onclick="toggleDesktopSidebar()" class="hidden md:flex text-white/70 hover:text-white p-1 ml-1.5 rounded-md hover:bg-white/10 transition-colors shrink-0" title="Toggle Sidebar">
                <span class="material-symbols-outlined text-[20px]" id="sidebarCollapseIcon">menu_open</span>
            </button>
            <!-- Mobile Close Button -->
            <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-white/70 hover:text-white p-1 ml-1.5 shrink-0">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="min-w-0 sidebar-text-group transition-all">
            <h1 class="font-headline-md text-xs font-bold text-cyan-400 leading-snug">Lead & Project Management System</h1>
        </div>
    </div>
    <nav class="flex-1 space-y-1 overflow-y-auto pr-1">
        <!-- Dashboard -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-70 hover:opacity-100 transition-all rounded-md hover:bg-primary-fixed-dim/10 group" href="{{ route('projects.index') }}" title="Dashboard">
            <span class="material-symbols-outlined mr-2.5 text-[18px] sidebar-icon">dashboard</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Dashboard</span>
        </a>
        <!-- Add New Project -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-70 hover:opacity-100 transition-all rounded-md hover:bg-primary-fixed-dim/10 group" href="{{ route('projects.create') }}" title="Add New Project">
            <span class="material-symbols-outlined mr-2.5 text-[18px] sidebar-icon">add_box</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Add New Project</span>
        </a>
        <!-- Projects -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-70 hover:opacity-100 transition-all rounded-md hover:bg-primary-fixed-dim/10 group" href="{{ route('projects.list') }}" title="Projects">
            <span class="material-symbols-outlined mr-2.5 text-[18px] sidebar-icon">folder_open</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Projects</span>
        </a>
        <!-- Active Tab: Lead Tracking -->
        <a class="flex items-center px-3 py-2.5 bg-primary-container text-on-primary-container rounded-md transition-transform duration-200 ease-in-out hover:bg-primary-fixed-dim/10 font-semibold group" href="{{ route('leads.index') }}" title="Lead Tracking">
            <span class="material-symbols-outlined mr-2.5 text-[18px] sidebar-icon" style="font-variation-settings: 'FILL' 1;">contacts</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Lead Tracking</span>
        </a>
        <!-- Money Receipt -->
        <a class="flex items-center px-3 py-2.5 text-on-primary-container opacity-70 hover:opacity-100 transition-all rounded-md hover:bg-primary-fixed-dim/10 group" href="{{ route('invoices.create') }}" title="Money Receipt">
            <span class="material-symbols-outlined mr-2.5 text-[18px] sidebar-icon">receipt_long</span>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Money Receipt</span>
        </a>
    </nav>
</aside>

<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-surface-subtle">

    <!-- TopAppBar -->
    <header class="bg-surface border-b border-border-light flex flex-wrap sm:flex-nowrap justify-between items-center w-full px-4 sm:px-6 py-2 sm:h-14 shrink-0 z-10 shadow-sm gap-2">
        <div class="flex items-center space-x-3">
            <button type="button" onclick="toggleDesktopSidebar()" class="hidden md:flex items-center justify-center p-1.5 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Collapse/Expand Sidebar">
                <span class="material-symbols-outlined text-[20px]" id="headerCollapseIcon">menu_open</span>
            </button>
            <span class="material-symbols-outlined text-primary text-[22px]">contacts</span>
            <h2 class="font-headline-md font-bold text-base text-primary">Lead Tracking Directory</h2>
            <!-- Google Sheets Style Cloud Sync Status Indicator -->
            <div class="hidden sm:flex items-center space-x-1.5 text-xs pl-3 border-l border-slate-200" id="cloudSyncIndicator" title="All edits automatically save to cloud in real-time">
                <span class="material-symbols-outlined text-[17px] text-emerald-600 transition-all duration-200" id="cloudSyncIcon">cloud_done</span>
                <span class="text-[11px] font-medium text-slate-500" id="cloudSyncText">All changes saved</span>
            </div>
        </div>
        <div class="flex items-center space-x-2.5 w-full sm:w-auto justify-end">
            <!-- Search Form -->
            <form action="{{ route('leads.index') }}" method="GET" class="relative flex-1 sm:w-64">
                @if($selectedCampaign)
                    <input type="hidden" name="campaign" value="{{ $selectedCampaign }}"/>
                @endif
                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client, phone, niche..." class="w-full pl-8 pr-3 py-1.5 bg-surface-subtle border border-border-light rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary outline-none"/>
            </form>
            <!-- CSV Import Button -->
            <button onclick="openImportModal()" type="button" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-md border border-slate-300 transition-colors shadow-2xs">
                <span class="material-symbols-outlined text-[16px] mr-1">upload_file</span>
                Import CSV
            </button>
        </div>
    </header>

    <!-- Scrollable Workspace -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-4">

        <!-- Dynamic Month / Ad Campaign Tabs Navigation (Most Recent First) -->
        <div class="glass-card p-1.5 bg-white flex flex-wrap items-center justify-between gap-2 overflow-x-auto">
            <div class="flex items-center space-x-1 overflow-x-auto py-0.5 max-w-full">
                <!-- All Leads Tab -->
                <a href="{{ route('leads.index', array_merge(request()->except('page'), ['campaign' => 'all'])) }}"
                   class="px-3.5 py-1.5 rounded-md text-xs font-bold transition-all whitespace-nowrap flex items-center space-x-1.5 {{ $selectedCampaign === 'all' ? 'bg-primary text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <span class="material-symbols-outlined text-[15px]">clear_all</span>
                    <span>All Leads</span>
                </a>

                @foreach($campaigns as $campaign)
                    <a href="{{ route('leads.index', array_merge(request()->except('page'), ['campaign' => $campaign])) }}"
                       class="px-3.5 py-1.5 rounded-md text-xs font-bold transition-all whitespace-nowrap flex items-center space-x-1.5 {{ $selectedCampaign === $campaign ? 'bg-secondary text-white shadow-sm' : 'bg-slate-50 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        <span class="material-symbols-outlined text-[15px]">campaign</span>
                        <span>{{ $campaign }}</span>
                        @if($loop->first)
                            <span class="px-1.5 py-0.2 bg-emerald-400 text-slate-900 text-[9px] font-black rounded uppercase tracking-wider">Latest</span>
                        @endif
                    </a>
                @endforeach

                <!-- + Add Tab Button (Google Sheets Style) -->
                <button type="button" onclick="openNewTabModal()" class="px-2.5 py-1.5 rounded-md text-xs font-bold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 border border-dashed border-slate-300 transition-all whitespace-nowrap flex items-center space-x-1 cursor-pointer" title="Add New Month or Ad Campaign Tab">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    <span>New Tab</span>
                </button>
            </div>

            <div class="flex items-center space-x-2 text-xs text-slate-500 font-medium shrink-0 px-2">
                <span>Total: <strong class="text-primary font-bold" id="totalLeadsCount">{{ $totalLeads }}</strong> leads</span>
                <span>•</span>
                <span>Won: <strong class="text-emerald-600 font-bold">{{ $convertedCount }}</strong></span>
            </div>
        </div>

        <!-- Google Sheet Editable Table -->
        <div class="glass-card overflow-hidden bg-white border border-slate-200 shadow-sm rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse" id="leadsTable">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 border-b border-slate-200 uppercase tracking-wider text-[10px] font-bold">
                            <th class="py-2 px-1.5 border-r border-slate-200 text-center w-7">#</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[120px]">Name</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[110px]">Niche</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[115px]">Contact Number</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[130px]">Work Scope (Tech Stack)</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[95px]">Incoming Date</th>
                            <th class="py-2 px-1.5 border-r border-slate-200 w-24">Quoted Amount</th>
                            <th class="py-2 px-1.5 border-r border-slate-200 w-24">Sold Amount</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[130px]">Status (Editable)</th>
                            <th class="py-2 px-2 border-r border-slate-200 min-w-[130px]">Note / Activity</th>
                            <th class="py-2 px-1 text-center min-w-[90px]">Actions</th>
                        </tr>
                    </thead                    <tbody class="divide-y divide-slate-200 text-slate-800" id="leadsTableBody">
                        @foreach($leads as $index => $lead)
                            @php
                                $currentScopes = is_array($lead->work_scope) ? $lead->work_scope : [];
                                $cleanPhone = preg_replace('/[^0-9]/', '', $lead->contact_number);
                            @endphp
                            <tr class="sheet-row hover:bg-slate-50/80 transition-colors {{ $lead->project_id ? 'bg-emerald-50/40' : '' }}" 
                                data-lead-id="{{ $lead->id }}" 
                                data-scopes='@json($currentScopes)'>
                                <!-- Index -->
                                <td class="py-1 px-2 border-r border-slate-200 text-center font-mono text-slate-400 font-semibold text-[11px] select-none bg-slate-50/60 row-index-cell">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Name (Editable) -->
                                <td class="p-0 border-r border-slate-200 font-bold">
                                    <input type="text" value="{{ $lead->client_name }}" data-field="client_name"
                                           oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                           class="cell-input font-bold text-slate-900"/>
                                </td>

                                <!-- Niche (Editable) -->
                                <td class="p-0 border-r border-slate-200">
                                    <textarea rows="1" title="{{ $lead->niche }}" data-field="niche"
                                              oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                              class="cell-input-expand text-slate-600">{{ $lead->niche }}</textarea>
                                </td>

                                <!-- Contact Number (Editable + WhatsApp Link) -->
                                <td class="p-0 border-r border-slate-200">
                                    <div class="flex items-center pr-1.5 contact-container">
                                        <input type="text" value="{{ $lead->contact_number }}" title="{{ $lead->contact_number }}" data-field="contact_number"
                                               oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                               class="cell-input font-mono"/>
                                        <a href="{{ $cleanPhone ? 'https://wa.me/'.$cleanPhone : '#' }}" target="_blank" title="Chat on WhatsApp" 
                                           class="whatsapp-btn {{ $cleanPhone ? '' : 'hidden' }} text-emerald-600 hover:text-emerald-700 p-0.5 shrink-0">
                                            <span class="material-symbols-outlined text-[15px]">chat</span>
                                        </a>
                                    </div>
                                </td>

                                <!-- Work Scope Column -->
                                <td class="py-1 px-2 border-r border-slate-200 relative scope-td">
                                    <div class="flex flex-wrap gap-1 items-center min-h-[26px] cursor-pointer rounded px-1 hover:bg-slate-100/80 transition-colors scope-trigger" 
                                         onclick="openGlobalScopePopover(event, this)">
                                        <div class="scope-badges flex flex-wrap gap-1 items-center">
                                            @forelse($currentScopes as $scope)
                                                @php
                                                    $pillStyle = match($scope) {
                                                        'WordPress' => 'bg-sky-600 text-white font-bold',
                                                        'MERN' => 'bg-rose-500 text-white font-bold',
                                                        'Laravel' => 'bg-amber-600 text-white font-bold',
                                                        'Mobile app' => 'bg-emerald-600 text-white font-bold',
                                                        'Digital Marketing' => 'bg-purple-600 text-white font-bold',
                                                        default => 'bg-slate-700 text-white font-bold'
                                                    };
                                                @endphp
                                                <span class="px-2 py-0.5 text-[10px] rounded-full shadow-2xs {{ $pillStyle }}">
                                                    {{ $scope }}
                                                </span>
                                            @empty
                                                <span class="text-slate-400 italic text-[11px] flex items-center">
                                                    + Assign Scope
                                                </span>
                                            @endforelse
                                        </div>
                                    </div>
                                </td>

                                <!-- Incoming Date -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="date" value="{{ $lead->lead_incoming_date ? \Carbon\Carbon::parse($lead->lead_incoming_date)->format('Y-m-d') : '' }}" data-field="lead_incoming_date"
                                           onchange="handleCellBlur(this)"
                                           class="cell-input font-mono text-slate-600"/>
                                </td>

                                <!-- Quoted Amount -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="text" value="{{ $lead->quoted_amount }}" data-field="quoted_amount"
                                           oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                           class="cell-input font-mono font-bold text-slate-900"/>
                                </td>

                                <!-- Sold Amount -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="text" value="{{ $lead->sold_amount }}" data-field="sold_amount"
                                           oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                           class="cell-input font-mono font-bold text-emerald-700"/>
                                </td>

                                <!-- Status -->
                                <td class="p-1 border-r border-slate-200">
                                    <textarea rows="1" title="{{ $lead->status }}" data-field="status" list="statusSuggestions"
                                              oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                              class="cell-input-status">{{ $lead->status }}</textarea>
                                </td>

                                <!-- Note / Activity -->
                                <td class="p-0 border-r border-slate-200">
                                    <textarea rows="1" title="{{ $lead->note }}" data-field="note"
                                              oninput="handleCellInput(this)" onblur="handleCellBlur(this)"
                                              class="cell-input-expand text-slate-700">{{ $lead->note }}</textarea>
                                </td>

                                <!-- Actions -->
                                <td class="py-1 px-2 text-center whitespace-nowrap actions-td">
                                    <div class="flex items-center justify-center space-x-1">
                                        <a href="{{ route('leads.show', $lead->id) }}" class="p-1 text-slate-400 hover:text-secondary rounded hover:bg-slate-100" title="View Detail Timeline">
                                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        </a>
                                        @if(!$lead->project_id)
                                            <form action="{{ route('leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Convert this lead into an active Project?');" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded" title="Convert to Project">
                                                    <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('projects.show', $lead->project_id) }}" class="p-1 text-cyan-600 hover:text-cyan-700 hover:bg-cyan-50 rounded" title="View Linked Project">
                                                <span class="material-symbols-outlined text-[16px]">folder</span>
                                            </a>
                                        @endif
                                        <button type="button" onclick="deleteLeadRow(this, {{ $lead->id }})" class="p-1 text-slate-400 hover:text-rose-600 rounded hover:bg-rose-50" title="Delete Row">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Google Sheets Empty Grid Rows Filling the Screen -->
                        @php
                            $existingCount = $leads->count();
                            $targetTotalRows = max(20, $existingCount + 10);
                            $emptyRowsCount = $targetTotalRows - $existingCount;
                        @endphp
                        @for($i = 1; $i <= $emptyRowsCount; $i++)
                            @php $rowIndex = $existingCount + $i; @endphp
                            <tr class="sheet-row hover:bg-slate-50/50 transition-colors" data-row-index="{{ $rowIndex }}" data-scopes="[]">
                                <!-- Index -->
                                <td class="py-1 px-2 border-r border-slate-200 text-center font-mono text-slate-400 font-semibold text-[11px] select-none bg-slate-50/60 row-index-cell">
                                    {{ $rowIndex }}
                                </td>

                                <!-- Name -->
                                <td class="p-0 border-r border-slate-200 font-bold">
                                    <input type="text" data-field="client_name" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-bold text-slate-900"/>
                                </td>

                                <!-- Niche -->
                                <td class="p-0 border-r border-slate-200">
                                    <textarea rows="1" data-field="niche" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-expand text-slate-600"></textarea>
                                </td>

                                <!-- Contact Number -->
                                <td class="p-0 border-r border-slate-200">
                                    <div class="flex items-center pr-1.5 contact-container">
                                        <input type="text" data-field="contact_number" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono"/>
                                        <a href="#" target="_blank" title="Chat on WhatsApp" class="whatsapp-btn hidden text-emerald-600 hover:text-emerald-700 p-0.5 shrink-0">
                                            <span class="material-symbols-outlined text-[15px]">chat</span>
                                        </a>
                                    </div>
                                </td>

                                <!-- Work Scope -->
                                <td class="py-1 px-2 border-r border-slate-200 relative scope-td">
                                    <div class="flex flex-wrap gap-1 items-center min-h-[26px] cursor-pointer rounded px-1 hover:bg-slate-100/80 transition-colors scope-trigger" onclick="openGlobalScopePopover(event, this)">
                                        <div class="scope-badges flex flex-wrap gap-1 items-center">
                                            <span class="text-slate-400 italic text-[11px] flex items-center">+ Assign Scope</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Incoming Date -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="date" data-field="lead_incoming_date" value="" onchange="handleNewRowBlur(this)" class="cell-input font-mono text-slate-600"/>
                                </td>

                                <!-- Quoted Amount -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="text" data-field="quoted_amount" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono font-bold text-slate-900"/>
                                </td>

                                <!-- Sold Amount -->
                                <td class="p-0 border-r border-slate-200">
                                    <input type="text" data-field="sold_amount" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono font-bold text-emerald-700"/>
                                </td>

                                <!-- Status -->
                                <td class="p-1 border-r border-slate-200">
                                    <textarea rows="1" data-field="status" list="statusSuggestions" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-status"></textarea>
                                </td>

                                <!-- Note -->
                                <td class="p-0 border-r border-slate-200">
                                    <textarea rows="1" data-field="note" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-expand text-slate-700"></textarea>
                                </td>

                                <!-- Actions -->
                                <td class="py-1 px-2 text-center whitespace-nowrap actions-td">
                                    <span class="text-slate-300 text-xs select-none">•</span>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Global Google Sheets Multi-Select Dropdown Popover Overlay -->
        <div id="global-scope-popover" class="scope-popover fixed z-50 hidden bg-white border border-slate-200 rounded-xl shadow-xl p-3 w-56 space-y-2 text-left">
            <div class="flex items-center space-x-1.5 pb-2 border-b border-slate-100">
                <span class="material-symbols-outlined text-slate-400 text-[16px]">search</span>
                <input type="text" onkeyup="filterPopoverItems(this)" placeholder="Search Tech Stack..." class="w-full text-xs border-0 outline-none p-0 focus:ring-0 text-slate-700"/>
            </div>

            <div class="space-y-1.5 max-h-48 overflow-y-auto pt-1 popover-items-list">
                @foreach($allowedTechStacks as $techName => $styles)
                    <button type="button" 
                            onclick="toggleGlobalScopeItem('{{ $techName }}', this)"
                            data-tech="{{ $techName }}"
                            data-assigned="false"
                            class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all text-left cursor-pointer hover:bg-slate-50">
                        <span class="px-2 py-0.5 text-[10px] rounded-full {{ $styles['pill'] }}">
                            {{ $techName }}
                        </span>
                        <span class="material-symbols-outlined text-[16px] text-transparent check-icon">
                            check_circle
                        </span>
                    </button>
                @endforeach
            </div>
        </div>ody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Status Autocomplete Datalist -->
<datalist id="statusSuggestions">
    <option value="Quotation deya hoise">
    <option value="Mirpur office e jeye kotha bolte hobe">
    <option value="Office e ashbe">
    <option value="Kotha hoy nai">
    <option value="Call recieve kore nai, message deya hoise">
    <option value="Whats app e reply dei nai">
    <option value="Live meeting done">
    <option value="Office visit planned">
    <option value="Visiting card sent">
    <option value="Followup pending">
    <option value="Won (Converted to Project)">
    <option value="Lost / Not Interested">
</datalist>

<!-- CSV Import Modal -->
<div id="importModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl border border-slate-200 max-w-md w-full p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <h3 class="font-headline-md font-bold text-slate-900 text-sm flex items-center">
                <span class="material-symbols-outlined text-secondary mr-2">upload_file</span>
                Import Google Sheets CSV
            </h3>
            <button type="button" onclick="closeImportModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Target Campaign / Month Tab</label>
                <input type="text" name="campaign_month" value="{{ $selectedCampaign !== 'all' ? $selectedCampaign : date('F Y') }}" required class="w-full px-3 py-1.5 border border-slate-300 rounded text-xs focus:ring-1 focus:ring-secondary"/>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Select CSV File</label>
                <input type="file" name="csv_file" accept=".csv, .txt" required class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeImportModal()" class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded hover:bg-slate-200">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-secondary text-white text-xs font-bold rounded hover:bg-cyan-700 shadow-sm">Start Import</button>
            </div>
        </form>
    </div>
</div>

<!-- Create New Tab Modal (Google Sheets Style) -->
<div id="newTabModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 max-w-sm w-full p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <h3 class="font-headline-md font-bold text-slate-900 text-sm flex items-center">
                <span class="material-symbols-outlined text-secondary mr-2 text-[20px]">tab</span>
                Create Month / Campaign Tab
            </h3>
            <button type="button" onclick="closeNewTabModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form onsubmit="handleCreateTabSubmit(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tab Name (Month or Ad Campaign)</label>
                <input type="text" id="newTabNameInput" required placeholder="e.g. November 2026, Facebook Ad - Dental" class="w-full px-3 py-2 border border-slate-300 rounded text-xs focus:ring-1 focus:ring-secondary outline-none"/>
                <p class="text-[11px] text-slate-400 mt-1">This will open a dedicated sheet tab for this month or ad campaign.</p>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="closeNewTabModal()" class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-semibold rounded hover:bg-slate-200">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-secondary text-white text-xs font-bold rounded hover:bg-cyan-700 shadow-sm">Open Tab</button>
            </div>
        </form>
    </div>
</div>

<script>
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const CURRENT_CAMPAIGN = "{{ $selectedCampaign !== 'all' ? $selectedCampaign : ($campaigns[0] ?? date('F Y')) }}";

let newRowScopes = [];

const TECH_PILL_STYLES = {
    'WordPress': 'bg-sky-600 text-white font-bold',
    'MERN': 'bg-rose-500 text-white font-bold',
    'Laravel': 'bg-amber-600 text-white font-bold',
    'Mobile app': 'bg-emerald-600 text-white font-bold',
    'Digital Marketing': 'bg-purple-600 text-white font-bold'
};

// Google Sheets Style Real-time Cloud Sync Status
function setCloudSyncStatus(status) {
    const icon = document.getElementById('cloudSyncIcon');
    const text = document.getElementById('cloudSyncText');
    if (!icon || !text) return;

    if (status === 'saving') {
        icon.innerText = 'sync';
        icon.className = 'material-symbols-outlined text-[17px] text-amber-500 animate-spin';
        text.innerText = 'Saving...';
        text.className = 'text-[11px] font-medium text-amber-600';
    } else if (status === 'saved') {
        icon.innerText = 'cloud_done';
        icon.className = 'material-symbols-outlined text-[17px] text-emerald-600';
        text.innerText = 'All changes saved';
        text.className = 'text-[11px] font-medium text-slate-500';
    } else if (status === 'error') {
        icon.innerText = 'error';
        icon.className = 'material-symbols-outlined text-[17px] text-rose-500';
        text.innerText = 'Save error';
        text.className = 'text-[11px] font-medium text-rose-600';
    }
}

function showToast(message = "Saved") {
    const toast = document.getElementById('toast');
    if (!toast) return;
    document.getElementById('toast-message').innerText = message;
    toast.classList.remove('translate-y-[-100%]', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-[-100%]', 'opacity-0');
    }, 1500);
}

// Update WhatsApp icon for a given row
function updateRowWhatsApp(row, phone) {
    const cleanPhone = (phone || '').replace(/[^0-9]/g, '');
    const waBtn = row.querySelector('.whatsapp-btn');
    if (!waBtn) return;
    if (cleanPhone.length >= 7) {
        waBtn.href = `https://wa.me/${cleanPhone}`;
        waBtn.classList.remove('hidden');
    } else {
        waBtn.classList.add('hidden');
    }
}

// Real-time debounce auto-save for EXISTING cells
const cellDebounceTimers = new Map();

function handleCellInput(input) {
    const row = input.closest('tr');
    const leadId = row.getAttribute('data-lead-id');
    if (!leadId) {
        handleNewRowInput(input);
        return;
    }

    setCloudSyncStatus('saving');
    const key = `${leadId}_${input.dataset.field}`;
    if (cellDebounceTimers.has(key)) {
        clearTimeout(cellDebounceTimers.get(key));
    }
    const timer = setTimeout(() => {
        saveExistingFieldNow(leadId, input.dataset.field, input.value, row);
        cellDebounceTimers.delete(key);
    }, 450);
    cellDebounceTimers.set(key, timer);
}

function handleCellBlur(input) {
    const row = input.closest('tr');
    const leadId = row.getAttribute('data-lead-id');
    if (!leadId) {
        handleNewRowBlur(input);
        return;
    }

    const key = `${leadId}_${input.dataset.field}`;
    if (cellDebounceTimers.has(key)) {
        clearTimeout(cellDebounceTimers.get(key));
        cellDebounceTimers.delete(key);
    }
    saveExistingFieldNow(leadId, input.dataset.field, input.value, row);
}

function saveExistingFieldNow(leadId, fieldName, fieldValue, row) {
    const data = {};
    data[fieldName] = fieldValue;

    fetch(`/leads/${leadId}/quick-update`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(resData => {
        if (resData.success) {
            setCloudSyncStatus('saved');
            if (fieldName === 'contact_number' && row) {
                updateRowWhatsApp(row, fieldValue);
            }
        } else {
            setCloudSyncStatus('error');
        }
    })
    .catch(err => {
        console.error("Save error:", err);
        setCloudSyncStatus('error');
    });
}

// Real-time debounce auto-save for EMPTY (new) rows
const newRowDebounceTimers = new Map();

function handleNewRowInput(input) {
    const row = input.closest('tr');
    if (row.hasAttribute('data-lead-id')) {
        handleCellInput(input);
        return;
    }

    setCloudSyncStatus('saving');
    if (newRowDebounceTimers.has(row)) {
        clearTimeout(newRowDebounceTimers.get(row));
    }
    const timer = setTimeout(() => {
        saveNewRowNow(row);
        newRowDebounceTimers.delete(row);
    }, 500);
    newRowDebounceTimers.set(row, timer);
}

function handleNewRowBlur(input) {
    const row = input.closest('tr');
    if (row.hasAttribute('data-lead-id')) {
        handleCellBlur(input);
        return;
    }

    if (newRowDebounceTimers.has(row)) {
        clearTimeout(newRowDebounceTimers.get(row));
        newRowDebounceTimers.delete(row);
    }
    saveNewRowNow(row);
}

function saveNewRowNow(row) {
    if (row.dataset.isSaving === 'true' || row.hasAttribute('data-lead-id')) return;

    const clientName = (row.querySelector('[data-field="client_name"]')?.value || '').trim();
    const niche = (row.querySelector('[data-field="niche"]')?.value || '').trim();
    const contact = (row.querySelector('[data-field="contact_number"]')?.value || '').trim();
    const date = row.querySelector('[data-field="lead_incoming_date"]')?.value || '';
    const quoted = (row.querySelector('[data-field="quoted_amount"]')?.value || '').trim();
    const sold = (row.querySelector('[data-field="sold_amount"]')?.value || '').trim();
    const status = (row.querySelector('[data-field="status"]')?.value || '').trim();
    const note = (row.querySelector('[data-field="note"]')?.value || '').trim();
    let scopes = [];
    try {
        scopes = JSON.parse(row.dataset.scopes || '[]');
    } catch(e) { scopes = []; }

    // If row is completely empty, don't create lead
    if (!clientName && !niche && !contact && !quoted && !sold && !status && !note && scopes.length === 0) {
        return;
    }

    row.dataset.isSaving = 'true';
    setCloudSyncStatus('saving');

    const payload = {
        client_name: clientName || 'New Client',
        niche: niche,
        contact_number: contact,
        work_scope: scopes,
        lead_incoming_date: date || null,
        quoted_amount: quoted,
        sold_amount: sold,
        status: status || 'New Lead',
        note: note,
        campaign_month: CURRENT_CAMPAIGN
    };

    fetch("{{ route('leads.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        row.dataset.isSaving = 'false';
        if (data.success && data.lead) {
            const lead = data.lead;
            row.setAttribute('data-lead-id', lead.id);

            // Update WhatsApp icon
            if (contact) {
                updateRowWhatsApp(row, contact);
            }

            // Update Actions cell
            const actionsTd = row.querySelector('.actions-td');
            if (actionsTd) {
                actionsTd.innerHTML = `
                    <div class="flex items-center justify-center space-x-1">
                        <a href="/leads/${lead.id}" class="p-1 text-slate-400 hover:text-secondary rounded hover:bg-slate-100" title="View Detail Timeline">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
                        </a>
                        <form action="/leads/${lead.id}/convert" method="POST" onsubmit="return confirm('Convert this lead into an active Project?');" class="inline">
                            <input type="hidden" name="_token" value="${CSRF_TOKEN}">
                            <button type="submit" class="p-1 text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded" title="Convert to Project">
                                <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                            </button>
                        </form>
                        <button type="button" onclick="deleteLeadRow(this, ${lead.id})" class="p-1 text-slate-400 hover:text-rose-600 rounded hover:bg-rose-50" title="Delete Row">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </div>
                `;
            }

            // Increment Total count in header
            const totalLeadsEl = document.getElementById('totalLeadsCount');
            if (totalLeadsEl) {
                totalLeadsEl.innerText = parseInt(totalLeadsEl.innerText || 0) + 1;
            }

            setCloudSyncStatus('saved');
            showToast("Row saved ✓");

            // Ensure we always have empty rows below
            ensureEmptyRowsBuffer();
        } else {
            setCloudSyncStatus('error');
        }
    })
    .catch(err => {
        console.error("Save error:", err);
        row.dataset.isSaving = 'false';
        setCloudSyncStatus('error');
    });
}

// Delete Lead Row with smooth AJAX removal
function deleteLeadRow(btn, leadId) {
    if (!confirm('Delete this lead row?')) return;
    const row = btn.closest('tr');
    setCloudSyncStatus('saving');

    fetch(`/leads/${leadId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            row.remove();
            renumberRows();
            ensureEmptyRowsBuffer();
            setCloudSyncStatus('saved');
            showToast("Row deleted");

            const totalLeadsEl = document.getElementById('totalLeadsCount');
            if (totalLeadsEl) {
                const curr = parseInt(totalLeadsEl.innerText || 1);
                totalLeadsEl.innerText = Math.max(0, curr - 1);
            }
        } else {
            setCloudSyncStatus('error');
        }
    })
    .catch(err => {
        console.error("Delete error:", err);
        setCloudSyncStatus('error');
    });
}

// Renumber table row index numbers
function renumberRows() {
    const tbody = document.getElementById('leadsTableBody');
    if (!tbody) return;
    tbody.querySelectorAll('tr.sheet-row').forEach((row, idx) => {
        const cell = row.querySelector('.row-index-cell');
        if (cell) cell.innerText = idx + 1;
    });
}

// Ensure at least 6 empty rows are always available at the bottom
function ensureEmptyRowsBuffer() {
    const tbody = document.getElementById('leadsTableBody');
    if (!tbody) return;
    const emptyRows = tbody.querySelectorAll('tr.sheet-row:not([data-lead-id])');
    if (emptyRows.length < 6) {
        const totalRows = tbody.querySelectorAll('tr.sheet-row').length;
        for (let i = 1; i <= 6; i++) {
            const nextIndex = totalRows + i;
            const tr = document.createElement('tr');
            tr.className = 'sheet-row hover:bg-slate-50/50 transition-colors';
            tr.dataset.rowIndex = nextIndex;
            tr.dataset.scopes = '[]';
            tr.innerHTML = `
                <td class="py-1 px-2 border-r border-slate-200 text-center font-mono text-slate-400 font-semibold text-[11px] select-none bg-slate-50/60 row-index-cell">
                    ${nextIndex}
                </td>
                <td class="p-0 border-r border-slate-200 font-bold">
                    <input type="text" data-field="client_name" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-bold text-slate-900"/>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <textarea rows="1" data-field="niche" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-expand text-slate-600"></textarea>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <div class="flex items-center pr-1.5 contact-container">
                        <input type="text" data-field="contact_number" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono"/>
                        <a href="#" target="_blank" title="Chat on WhatsApp" class="whatsapp-btn hidden text-emerald-600 hover:text-emerald-700 p-0.5 shrink-0">
                            <span class="material-symbols-outlined text-[15px]">chat</span>
                        </a>
                    </div>
                </td>
                <td class="py-1 px-2 border-r border-slate-200 relative scope-td">
                    <div class="flex flex-wrap gap-1 items-center min-h-[26px] cursor-pointer rounded px-1 hover:bg-slate-100/80 transition-colors scope-trigger" onclick="openGlobalScopePopover(event, this)">
                        <div class="scope-badges flex flex-wrap gap-1 items-center">
                            <span class="text-slate-400 italic text-[11px] flex items-center">+ Assign Scope</span>
                        </div>
                    </div>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <input type="date" data-field="lead_incoming_date" value="" onchange="handleNewRowBlur(this)" class="cell-input font-mono text-slate-600"/>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <input type="text" data-field="quoted_amount" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono font-bold text-slate-900"/>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <input type="text" data-field="sold_amount" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input font-mono font-bold text-emerald-700"/>
                </td>
                <td class="p-1 border-r border-slate-200">
                    <textarea rows="1" data-field="status" list="statusSuggestions" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-status"></textarea>
                </td>
                <td class="p-0 border-r border-slate-200">
                    <textarea rows="1" data-field="note" oninput="handleNewRowInput(this)" onblur="handleNewRowBlur(this)" class="cell-input-expand text-slate-700"></textarea>
                </td>
                <td class="py-1 px-2 text-center whitespace-nowrap actions-td">
                    <span class="text-slate-300 text-xs select-none">•</span>
                </td>
            `;
            tbody.appendChild(tr);
        }
    }
}

// Global Dynamic Positioning for Scope Popover
function positionScopePopover(popover, triggerEl) {
    if (!popover || !triggerEl) return;

    popover.style.visibility = 'hidden';
    popover.classList.remove('hidden');

    const rect = triggerEl.getBoundingClientRect();
    const popoverHeight = popover.offsetHeight || 240;
    const popoverWidth = popover.offsetWidth || 224;

    const viewportHeight = window.innerHeight;
    const viewportWidth = window.innerWidth;

    const spaceBelow = viewportHeight - rect.bottom;
    const spaceAbove = rect.top;

    let top;
    if (spaceBelow < (popoverHeight + 10) && spaceAbove > spaceBelow) {
        top = rect.top - popoverHeight - 4;
    } else {
        top = rect.bottom + 4;
    }

    if (top < 8) top = 8;
    else if (top + popoverHeight > viewportHeight - 8) {
        top = Math.max(8, viewportHeight - popoverHeight - 8);
    }

    let left = rect.left;
    if (left + popoverWidth > viewportWidth - 12) {
        left = Math.max(12, viewportWidth - popoverWidth - 12);
    }
    if (left < 12) left = 12;

    popover.style.top = `${top}px`;
    popover.style.left = `${left}px`;
    popover.style.visibility = 'visible';

    const searchInput = popover.querySelector('input[type="text"]');
    if (searchInput) {
        searchInput.value = '';
        popover.querySelectorAll('button[data-tech]').forEach(btn => btn.style.display = 'flex');
        setTimeout(() => searchInput.focus(), 30);
    }
}

let activeScopeRow = null;
let activeScopeTrigger = null;

function openGlobalScopePopover(event, trigger) {
    event.stopPropagation();
    closeAllPopovers();

    activeScopeTrigger = trigger;
    activeScopeRow = trigger.closest('tr');

    const popover = document.getElementById('global-scope-popover');
    if (!popover) return;

    let currentScopes = [];
    if (activeScopeRow.dataset.scopes) {
        try {
            currentScopes = JSON.parse(activeScopeRow.dataset.scopes);
        } catch(e) { currentScopes = []; }
    } else {
        activeScopeRow.querySelectorAll('.scope-badges span').forEach(b => {
            const text = b.innerText.trim();
            if (text && text !== '+ Assign Scope') currentScopes.push(text);
        });
        activeScopeRow.dataset.scopes = JSON.stringify(currentScopes);
    }

    popover.querySelectorAll('button[data-tech]').forEach(btn => {
        const tech = btn.getAttribute('data-tech');
        const isAssigned = currentScopes.includes(tech);
        btn.setAttribute('data-assigned', isAssigned ? 'true' : 'false');
        const checkIcon = btn.querySelector('.check-icon');
        if (checkIcon) {
            checkIcon.className = `material-symbols-outlined text-[16px] ${isAssigned ? 'text-emerald-600' : 'text-transparent'} check-icon`;
        }
    });

    positionScopePopover(popover, trigger);
}

function toggleGlobalScopeItem(techName, btn) {
    if (!activeScopeRow || !activeScopeTrigger) return;

    const isAssigned = btn.getAttribute('data-assigned') === 'true';
    const nextState = !isAssigned;
    btn.setAttribute('data-assigned', nextState ? 'true' : 'false');

    const checkIcon = btn.querySelector('.check-icon');
    if (checkIcon) {
        checkIcon.className = `material-symbols-outlined text-[16px] ${nextState ? 'text-emerald-600' : 'text-transparent'} check-icon`;
    }

    let scopes = [];
    try {
        scopes = JSON.parse(activeScopeRow.dataset.scopes || '[]');
    } catch(e) { scopes = []; }

    if (nextState) {
        if (!scopes.includes(techName)) scopes.push(techName);
    } else {
        scopes = scopes.filter(t => t !== techName);
    }

    activeScopeRow.dataset.scopes = JSON.stringify(scopes);

    const badgesContainer = activeScopeTrigger.querySelector('.scope-badges');
    if (badgesContainer) {
        if (scopes.length > 0) {
            badgesContainer.innerHTML = scopes.map(t => `<span class="px-2 py-0.5 text-[10px] rounded-full shadow-2xs ${TECH_PILL_STYLES[t] || 'bg-slate-700 text-white font-bold'}">${t}</span>`).join('');
        } else {
            badgesContainer.innerHTML = `<span class="text-slate-400 italic text-[11px] flex items-center">+ Assign Scope</span>`;
        }
    }

    if (activeScopeRow.hasAttribute('data-lead-id')) {
        const leadId = activeScopeRow.getAttribute('data-lead-id');
        setCloudSyncStatus('saving');
        fetch(`/leads/${leadId}/quick-update`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ work_scope: scopes })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                setCloudSyncStatus('saved');
                showToast("Work Scope updated ✓");
            }
        });
    } else {
        saveNewRowNow(activeScopeRow);
    }
}

function filterPopoverItems(input) {
    const filter = input.value.toLowerCase();
    const list = input.closest('.scope-popover').querySelectorAll('.popover-items-list button');
    list.forEach(btn => {
        const text = btn.getAttribute('data-tech').toLowerCase();
        btn.style.display = text.includes(filter) ? 'flex' : 'none';
    });
}

function closeAllPopovers(event) {
    if (event && event.target && event.target.closest && event.target.closest('.scope-popover')) return;
    document.querySelectorAll('.scope-popover').forEach(p => {
        p.classList.add('hidden');
        p.style.visibility = '';
    });
}

window.addEventListener('scroll', function(e) {
    if (e.target && e.target.closest && e.target.closest('.scope-popover')) return;
    closeAllPopovers();
}, true);

window.addEventListener('resize', closeAllPopovers);

// Google Sheets Enter-Key Navigation (Moves down to next row in the same column)
document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        const target = e.target;
        if (target && (target.classList.contains('cell-input') || target.classList.contains('cell-input-expand') || target.classList.contains('cell-input-status'))) {
            e.preventDefault();
            target.blur();
            const currentRow = target.closest('tr');
            if (currentRow) {
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const field = target.dataset.field;
                    const nextInput = nextRow.querySelector(`[data-field="${field}"]`);
                    if (nextInput) {
                        nextInput.focus();
                        if (nextInput.select) nextInput.select();
                    }
                }
            }
        }
    }
});

function toggleMobileSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('mobileBackdrop').classList.toggle('hidden');
}

function toggleDesktopSidebar() {
    const sidebar = document.getElementById('sidebar');
    const isCollapsed = sidebar.classList.contains('w-16');
    setSidebarCollapsed(!isCollapsed);
}

function setSidebarCollapsed(collapse) {
    const sidebar = document.getElementById('sidebar');
    const textGroup = sidebar.querySelector('.sidebar-text-group');
    const logo = sidebar.querySelector('.sidebar-logo');
    const headerWrapper = sidebar.querySelector('.sidebar-header-wrapper');
    const texts = sidebar.querySelectorAll('.sidebar-text');
    const icons = sidebar.querySelectorAll('.sidebar-icon');
    const sidebarCollapseIcon = document.getElementById('sidebarCollapseIcon');
    const headerCollapseIcon = document.getElementById('headerCollapseIcon');

    if (collapse) {
        sidebar.classList.remove('w-60', 'px-3');
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
        if (sidebarCollapseIcon) sidebarCollapseIcon.innerText = 'menu';
        if (headerCollapseIcon) headerCollapseIcon.innerText = 'menu';
        localStorage.setItem('sidebar_collapsed', 'true');
    } else {
        sidebar.classList.remove('w-16', 'px-2');
        sidebar.classList.add('w-60', 'px-3');
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
        if (sidebarCollapseIcon) sidebarCollapseIcon.innerText = 'menu_open';
        if (headerCollapseIcon) headerCollapseIcon.innerText = 'menu_open';
        localStorage.setItem('sidebar_collapsed', 'false');
    }
}

// Restore sidebar collapse state on page load
document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('sidebar_collapsed') === 'true') {
        setSidebarCollapsed(true);
    }
});

// Pressing Enter in expanding cell textarea saves & blurs without adding newline
document.addEventListener('keydown', function(e) {
    if (e.target && (e.target.classList.contains('cell-input-expand') || e.target.classList.contains('cell-input-status'))) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            e.target.blur();
        }
    }
});

function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

function openNewTabModal() {
    const modal = document.getElementById('newTabModal');
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => document.getElementById('newTabNameInput')?.focus(), 50);
    }
}

function closeNewTabModal() {
    const modal = document.getElementById('newTabModal');
    if (modal) modal.classList.add('hidden');
}

function handleCreateTabSubmit(event) {
    event.preventDefault();
    const input = document.getElementById('newTabNameInput');
    const name = (input ? input.value : '').trim();
    if (!name) return;
    window.location.href = `{{ route('leads.index') }}?campaign=${encodeURIComponent(name)}`;
}
</script>

</body>
</html>
