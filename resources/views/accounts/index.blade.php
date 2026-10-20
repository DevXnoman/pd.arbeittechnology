<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Accounts & Finance - Arbeit Technology</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&family=DM+Sans:wght@600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="{{ asset('js/xlsx.full.min.js') }}"></script>
    <script>
        if (typeof XLSX === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"><\/script>');
        }
    </script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#091426",
                        secondary: "#006972",
                        "surface-subtle": "#F8FAFC",
                        "border-light": "#E2E8F0"
                    },
                    fontFamily: {
                        sans: ["Hanken Grotesk", "sans-serif"],
                        headline: ["DM Sans", "sans-serif"],
                        "headline-md": ["DM Sans", "sans-serif"],
                        "label-md": ["Hanken Grotesk", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
        .active-tab-nav {
            border-bottom: 2px solid #0284c7;
            color: #0284c7;
            font-weight: 700;
        }
        .inactive-tab-nav {
            color: #64748b;
            font-weight: 500;
        }
        .inactive-tab-nav:hover {
            color: #1e293b;
        }
        .custom-scroll::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans h-screen flex flex-col md:flex-row overflow-hidden">

<!-- Toast Notification -->
<div id="toast" class="fixed top-5 right-5 z-50 transform translate-y-[-100%] opacity-0 transition-all duration-300 pointer-events-none flex items-center bg-slate-900 text-white px-4 py-2.5 rounded-lg shadow-xl border border-slate-700 text-xs font-medium space-x-2">
    <span class="material-symbols-outlined text-emerald-400 text-[18px]">check_circle</span>
    <span id="toast-message">Success</span>
</div>

<!-- Mobile Sidebar Backdrop -->
<div id="mobileBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/60 z-40 hidden md:hidden backdrop-blur-xs transition-opacity"></div>

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
        <!-- Dashboard -->
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.index') }}" title="Dashboard">
            <img src="{{ asset('images/icons/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Dashboard</span>
        </a>
        <!-- Add New Project -->
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.create') }}" title="Add New Project">
            <img src="{{ asset('images/icons/add-project.png') }}" alt="Add New Project" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Add New Project</span>
        </a>
        <!-- Projects -->
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.list') }}" title="Projects">
            <img src="{{ asset('images/icons/projects.png') }}" alt="Projects" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Projects</span>
        </a>
        <!-- Lead Tracking -->
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('leads.index') }}" title="Lead Tracking">
            <img src="{{ asset('images/icons/leads.png') }}" alt="Lead Tracking" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Lead Tracking</span>
        </a>
        <!-- Active Tab: Accounts -->
        <a class="flex items-center px-3 py-2.5 bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 rounded-lg transition-all font-semibold shadow-xs group" href="{{ route('accounts.index') }}" title="Accounts">
            <span class="material-symbols-outlined text-[20px] text-cyan-300 mr-2.5 sidebar-icon shrink-0">account_balance_wallet</span>
            <span class="font-label-md text-xs text-cyan-300 font-semibold sidebar-text whitespace-nowrap">Accounts</span>
        </a>
        <!-- Money Receipt -->
        <a class="flex items-center px-3 py-2.5 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('invoices.create') }}" title="Money Receipt">
            <img src="{{ asset('images/icons/receipt.png') }}" alt="Money Receipt" class="w-5 h-5 mr-2.5 object-contain sidebar-icon shrink-0"/>
            <span class="font-label-md text-xs sidebar-text whitespace-nowrap">Money Receipt</span>
        </a>
    </nav>

    <!-- User & Logout -->
    <div class="pt-3 border-t border-slate-800 text-xs sidebar-text-group">
        <div class="flex items-center justify-between text-slate-400">
            <span class="truncate">{{ Auth::user()->name ?? 'Admin' }}</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-rose-400 cursor-pointer p-1" title="Logout">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Main Content Area -->
<div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">

    <!-- Top Header Bar -->
    <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-3 shrink-0 shadow-2xs">
        <div class="flex items-center space-x-3">
            <button type="button" onclick="toggleMobileSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 p-1">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-700 flex items-center justify-center font-bold">
                <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
            </div>
            <div>
                <h1 class="font-headline font-bold text-base text-slate-900 leading-tight">Accounts & Finance</h1>
                <p class="text-[11px] text-slate-500">Track client payments, inflow, and office expenses</p>
            </div>
        </div>

        <div class="flex items-center flex-wrap gap-2">
            <!-- Search Filter -->
            <form action="{{ route('accounts.index') }}" method="GET" class="relative">
                @if($selectedMonth)
                    <input type="hidden" name="month" value="{{ $selectedMonth }}"/>
                @endif
                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search client, purpose, receipt..." class="pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 focus:border-cyan-600 outline-none w-48 sm:w-60"/>
            </form>

            <!-- + Add Expense Button -->
            <button onclick="openAddExpenseModal()" type="button" class="inline-flex items-center px-3 py-1.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white text-xs font-bold rounded-lg shadow-2xs transition-colors cursor-pointer space-x-1">
                <span class="material-symbols-outlined text-[16px]">add</span>
                <span>Add Expense</span>
            </button>

            <!-- + Create Bill / Money Receipt Button -->
            <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-3 py-1.5 bg-cyan-700 hover:bg-cyan-800 text-white text-xs font-bold rounded-lg shadow-2xs transition-colors cursor-pointer space-x-1">
                <span class="material-symbols-outlined text-[16px]">receipt</span>
                <span>Create Money Receipt</span>
            </a>

            <!-- Export to Excel Button -->
            <button onclick="exportAccountsToExcel()" type="button" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-2xs transition-colors cursor-pointer space-x-1" title="Export this month's statement to Excel (.xlsx)">
                <span class="material-symbols-outlined text-[16px]">download</span>
                <span>Export</span>
            </button>
        </div>
    </header>

    <!-- Scrollable Body Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-5 custom-scroll">

        <!-- Month Filter Tabs (Google Sheets Style) -->
        <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-2xs flex items-center justify-between gap-2 overflow-x-auto custom-scroll">
            <div class="flex items-center space-x-1.5 overflow-x-auto py-0.5">
                <!-- All Time Tab -->
                <a href="{{ route('accounts.index', ['month' => 'all', 'search' => request('search')]) }}"
                   class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap flex items-center space-x-1 {{ $selectedMonth === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span class="material-symbols-outlined text-[15px]">all_inclusive</span>
                    <span>All Time</span>
                </a>

                @foreach($allMonths as $month)
                    <a href="{{ route('accounts.index', ['month' => $month, 'search' => request('search')]) }}"
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap flex items-center space-x-1 {{ $selectedMonth === $month ? 'bg-cyan-700 text-white shadow-xs' : 'bg-slate-50 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                        <span class="material-symbols-outlined text-[15px]">calendar_month</span>
                        <span>{{ $month }}</span>
                        @if($month === date('F Y'))
                            <span class="px-1.5 py-0.2 bg-emerald-400 text-slate-900 text-[9px] font-black rounded uppercase">Current</span>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="text-[11px] text-slate-500 font-medium whitespace-nowrap px-2 shrink-0">
                Period: <strong class="text-slate-800">{{ $selectedMonth === 'all' ? 'All Time Overview' : $selectedMonth }}</strong>
            </div>
        </div>

        <!-- KPI Summary Cards (4 Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- 1. Total Inflow (Received) -->
            <div class="bg-white rounded-xl p-4 border border-emerald-100 shadow-2xs flex items-start justify-between relative overflow-hidden">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Total Inflow (আদায়)</span>
                    <h3 class="text-2xl font-headline font-bold text-emerald-600">৳ {{ number_format($totalInflow, 2) }}</h3>
                    <p class="text-[11px] text-slate-400">Total client payments received</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">trending_up</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
            </div>

            <!-- 2. Total Office Expenses -->
            <div class="bg-white rounded-xl p-4 border border-rose-100 shadow-2xs flex items-start justify-between relative overflow-hidden">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Office Expenses (খরচ)</span>
                    <h3 class="text-2xl font-headline font-bold text-rose-600">৳ {{ number_format($totalExpenses, 2) }}</h3>
                    <p class="text-[11px] text-slate-400">Hardware, bills, snacks & misc</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">trending_down</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-rose-500"></div>
            </div>

            <!-- 3. Net Cash Flow / Balance -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-2xs flex items-start justify-between relative overflow-hidden">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Net Balance (উদ্বৃত্ত)</span>
                    <h3 class="text-2xl font-headline font-bold {{ $netBalance >= 0 ? 'text-cyan-700' : 'text-rose-600' }}">
                        ৳ {{ number_format($netBalance, 2) }}
                    </h3>
                    <p class="text-[11px] text-slate-400">{{ $netBalance >= 0 ? 'Cash Surplus (Inflow - Expense)' : 'Deficit this period' }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg {{ $netBalance >= 0 ? 'bg-cyan-50 text-cyan-700' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">account_balance</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 {{ $netBalance >= 0 ? 'bg-cyan-600' : 'bg-rose-500' }}"></div>
            </div>

            <!-- 4. Total Market Due -->
            <div class="bg-white rounded-xl p-4 border border-amber-100 shadow-2xs flex items-start justify-between relative overflow-hidden">
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Outstanding Due (বাকি)</span>
                    <h3 class="text-2xl font-headline font-bold text-amber-600">৳ {{ number_format($totalDue, 2) }}</h3>
                    <p class="text-[11px] text-slate-400">Pending receivable from clients</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[22px]">pending_actions</span>
                </div>
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
            </div>

        </div>

        <!-- Main Workspace Tabs: Client Inflow vs Office Expenses -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            
            <!-- Navigation Header for Two Tabs -->
            <div class="border-b border-slate-200 px-4 flex items-center justify-between">
                <div class="flex space-x-6">
                    <button type="button" onclick="switchMainTab('inflow')" id="tabBtnInflow" class="py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 active-tab-nav">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span>Client Payments & Inflow</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ $receipts->count() }}</span>
                    </button>

                    <button type="button" onclick="switchMainTab('expenses')" id="tabBtnExpenses" class="py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 inactive-tab-nav">
                        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                        <span>Office Expenses</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">{{ $expenses->count() }}</span>
                    </button>
                </div>

                <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-500">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Auto-synced with Money Receipts</span>
                </div>
            </div>

            <!-- Tab 1: Client Payments & Inflow Table -->
            <div id="tabContentInflow" class="block">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse" id="inflowTable">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold border-b border-slate-200 tracking-wider">
                                <th class="py-2.5 px-3 w-10 text-center">#</th>
                                <th class="py-2.5 px-3">Receipt No</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3">Client Name</th>
                                <th class="py-2.5 px-3">Purpose</th>
                                <th class="py-2.5 px-3">Method</th>
                                <th class="py-2.5 px-3 text-right">Amount Received</th>
                                <th class="py-2.5 px-3 text-right">Due Balance</th>
                                <th class="py-2.5 px-3 text-center w-28">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($receipts as $index => $receipt)
                                <tr class="hover:bg-slate-50/80 transition-colors receipt-row"
                                    data-receipt-no="{{ $receipt->receipt_no }}"
                                    data-date="{{ $receipt->receipt_date ? $receipt->receipt_date->format('Y-m-d') : '' }}"
                                    data-client="{{ $receipt->client_name }}"
                                    data-contact="{{ $receipt->client_contact }}"
                                    data-purpose="{{ $receipt->purpose }}"
                                    data-method="{{ $receipt->payment_method }}"
                                    data-received="{{ $receipt->amount_received }}"
                                    data-due="{{ $receipt->due_balance }}">
                                    <td class="py-2.5 px-3 text-center font-mono text-slate-400 text-[11px]">{{ $index + 1 }}</td>
                                    <td class="py-2.5 px-3 font-mono font-bold text-cyan-800">
                                        <a href="{{ route('invoices.show', $receipt->id) }}" class="hover:underline flex items-center space-x-1" title="View Money Receipt">
                                            <span>{{ $receipt->receipt_no }}</span>
                                            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                        </a>
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-600 font-mono whitespace-nowrap">
                                        {{ $receipt->receipt_date ? $receipt->receipt_date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 font-semibold text-slate-900">
                                        <div>{{ $receipt->client_name }}</div>
                                        @if($receipt->client_contact)
                                            <div class="text-[11px] font-normal text-slate-400 font-mono">{{ $receipt->client_contact }}</div>
                                        @endif
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-700 max-w-xs truncate" title="{{ $receipt->purpose }}">
                                        {{ $receipt->purpose ?? '-' }}
                                    </td>
                                    <td class="py-2.5 px-3">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $receipt->payment_method ?: 'Cash' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-600 text-sm">
                                        ৳ {{ number_format($receipt->amount_received, 2) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold {{ $receipt->due_balance > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                        ৳ {{ number_format($receipt->due_balance, 2) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <a href="{{ route('invoices.show', $receipt->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-cyan-50 text-cyan-800 hover:bg-cyan-100 rounded text-[11px] font-bold border border-cyan-200 transition" title="Print/View Pad Receipt">
                                                <span class="material-symbols-outlined text-[14px]">print</span>
                                                <span>Receipt</span>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $receipt->id) }}" method="POST" onsubmit="return confirm('Delete this Money Receipt and payment entry?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded hover:bg-rose-50 transition cursor-pointer" title="Delete Entry">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-8 text-center text-slate-400 text-xs">
                                        <span class="material-symbols-outlined text-[32px] text-slate-300 block mb-1">payments</span>
                                        No client payments or receipts found for this period.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 2: Office Expenses Table -->
            <div id="tabContentExpenses" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse" id="expensesTable">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 uppercase text-[10px] font-bold border-b border-slate-200 tracking-wider">
                                <th class="py-2.5 px-3 w-10 text-center">#</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3">Purpose / Item</th>
                                <th class="py-2.5 px-3">Category</th>
                                <th class="py-2.5 px-3">Spent By</th>
                                <th class="py-2.5 px-3">Notes</th>
                                <th class="py-2.5 px-3 text-right">Amount (BDT)</th>
                                <th class="py-2.5 px-3 text-center w-24">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($expenses as $index => $expense)
                                <tr class="hover:bg-slate-50/80 transition-colors expense-row"
                                    data-id="{{ $expense->id }}"
                                    data-date="{{ $expense->expense_date ? $expense->expense_date->format('Y-m-d') : '' }}"
                                    data-purpose="{{ $expense->purpose }}"
                                    data-category="{{ $expense->category }}"
                                    data-amount="{{ $expense->amount }}"
                                    data-spent-by="{{ $expense->spent_by }}"
                                    data-notes="{{ $expense->notes }}">
                                    <td class="py-2.5 px-3 text-center font-mono text-slate-400 text-[11px]">{{ $index + 1 }}</td>
                                    <td class="py-2.5 px-3 text-slate-600 font-mono whitespace-nowrap">
                                        {{ $expense->expense_date ? $expense->expense_date->format('d M Y') : '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 font-bold text-slate-900">
                                        {{ $expense->purpose }}
                                    </td>
                                    <td class="py-2.5 px-3">
                                        @php
                                            $catConfig = $categories[$expense->category] ?? ['bg' => 'bg-slate-100 text-slate-800 border-slate-200', 'icon' => 'tag'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $catConfig['bg'] }}">
                                            <span class="material-symbols-outlined text-[13px]">{{ $catConfig['icon'] }}</span>
                                            <span>{{ $expense->category }}</span>
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-600">
                                        {{ $expense->spent_by ?: '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-slate-500 max-w-xs truncate" title="{{ $expense->notes }}">
                                        {{ $expense->notes ?: '-' }}
                                    </td>
                                    <td class="py-2.5 px-3 text-right font-mono font-bold text-rose-600 text-sm">
                                        ৳ {{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="py-2.5 px-3 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1">
                                            <button type="button" onclick="openEditExpenseModal(this)" class="p-1 text-slate-400 hover:text-cyan-700 rounded hover:bg-slate-100 transition cursor-pointer" title="Edit Expense">
                                                <span class="material-symbols-outlined text-[16px]">edit</span>
                                            </button>
                                            <form action="{{ route('accounts.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Delete this expense entry?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded hover:bg-rose-50 transition cursor-pointer" title="Delete Expense">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-8 text-center text-slate-400 text-xs">
                                        <span class="material-symbols-outlined text-[32px] text-slate-300 block mb-1">receipt_long</span>
                                        No office expenses recorded for this period. Click "+ Add Expense" above to record one.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. Add Office Expense Modal -->
<div id="addExpenseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 max-w-md w-full p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-headline font-bold text-slate-900 text-sm flex items-center space-x-2">
                <span class="material-symbols-outlined text-rose-600">add_shopping_cart</span>
                <span>Record Office Expense</span>
            </h3>
            <button type="button" onclick="closeAddExpenseModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form action="{{ route('accounts.expenses.store') }}" method="POST" class="space-y-3.5">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Date</label>
                    <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none font-mono"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Amount (BDT)</label>
                    <input type="number" step="0.01" name="amount" required placeholder="e.g. 1500" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none font-mono font-bold text-slate-900"/>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Purpose / Item Name</label>
                <input type="text" name="purpose" required placeholder="e.g. Headphone for office, Internet bill, Evening Snacks" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none"/>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                    <select name="category" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none bg-white">
                        @foreach(array_keys($categories) as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Spent By</label>
                    <input type="text" name="spent_by" placeholder="e.g. Noman, Admin" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none"/>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Remarks (Optional)</label>
                <textarea name="notes" rows="2" placeholder="Any additional details or shop info..." class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-rose-500 outline-none resize-none"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeAddExpenseModal()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg shadow-sm transition cursor-pointer">Save Expense</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Edit Office Expense Modal -->
<div id="editExpenseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl border border-slate-200 max-w-md w-full p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-headline font-bold text-slate-900 text-sm flex items-center space-x-2">
                <span class="material-symbols-outlined text-cyan-700">edit_note</span>
                <span>Edit Office Expense</span>
            </h3>
            <button type="button" onclick="closeEditExpenseModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form id="editExpenseForm" method="POST" class="space-y-3.5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Date</label>
                    <input type="date" id="editExpenseDate" name="expense_date" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none font-mono"/>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Amount (BDT)</label>
                    <input type="number" step="0.01" id="editExpenseAmount" name="amount" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none font-mono font-bold text-slate-900"/>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Purpose / Item Name</label>
                <input type="text" id="editExpensePurpose" name="purpose" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none"/>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Category</label>
                    <select id="editExpenseCategory" name="category" required class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none bg-white">
                        @foreach(array_keys($categories) as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Spent By</label>
                    <input type="text" id="editExpenseSpentBy" name="spent_by" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none"/>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Notes / Remarks (Optional)</label>
                <textarea id="editExpenseNotes" name="notes" rows="2" class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-1 focus:ring-cyan-600 outline-none resize-none"></textarea>
            </div>

            <div class="flex justify-end space-x-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeEditExpenseModal()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition cursor-pointer">Cancel</button>
                <button type="submit" class="px-4 py-1.5 bg-cyan-700 hover:bg-cyan-800 text-white text-xs font-bold rounded-lg shadow-sm transition cursor-pointer">Update Expense</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script>
    const SELECTED_MONTH = "{{ $selectedMonth }}";

    function showToast(message = "Success") {
        const toast = document.getElementById('toast');
        if (!toast) return;
        document.getElementById('toast-message').innerText = message;
        toast.classList.remove('translate-y-[-100%]', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-[-100%]', 'opacity-0');
        }, 2000);
    }

    @if(session('success'))
        showToast("{{ session('success') }}");
    @endif

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
        const textGroup = sidebar.querySelectorAll('.sidebar-text-group');
        const logo = sidebar.querySelector('.sidebar-logo');
        const headerWrapper = sidebar.querySelector('.sidebar-header-wrapper');
        const texts = sidebar.querySelectorAll('.sidebar-text');
        const icons = sidebar.querySelectorAll('.sidebar-icon');
        const sidebarCollapseIcon = document.getElementById('sidebarCollapseIcon');

        if (collapse) {
            sidebar.classList.remove('w-52', 'px-3');
            sidebar.classList.add('w-16', 'px-2');
            textGroup.forEach(g => g.classList.add('hidden'));
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
            textGroup.forEach(g => g.classList.remove('hidden'));
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

    // Switch between Client Inflow and Office Expenses tab
    function switchMainTab(tab) {
        const inflowContent = document.getElementById('tabContentInflow');
        const expensesContent = document.getElementById('tabContentExpenses');
        const tabBtnInflow = document.getElementById('tabBtnInflow');
        const tabBtnExpenses = document.getElementById('tabBtnExpenses');

        if (tab === 'inflow') {
            inflowContent.classList.remove('hidden');
            expensesContent.classList.add('hidden');
            tabBtnInflow.className = "py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 active-tab-nav";
            tabBtnExpenses.className = "py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 inactive-tab-nav";
        } else {
            inflowContent.classList.add('hidden');
            expensesContent.classList.remove('hidden');
            tabBtnExpenses.className = "py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 active-tab-nav";
            tabBtnInflow.className = "py-3 px-1 text-xs transition-colors flex items-center space-x-1.5 inactive-tab-nav";
        }
    }

    // Add Expense Modal
    function openAddExpenseModal() {
        document.getElementById('addExpenseModal').classList.remove('hidden');
    }
    function closeAddExpenseModal() {
        document.getElementById('addExpenseModal').classList.add('hidden');
    }

    // Edit Expense Modal
    function openEditExpenseModal(btn) {
        const row = btn.closest('tr.expense-row');
        if (!row) return;

        const id = row.dataset.id;
        const date = row.dataset.date;
        const purpose = row.dataset.purpose;
        const category = row.dataset.category;
        const amount = row.dataset.amount;
        const spentBy = row.dataset.spentBy;
        const notes = row.dataset.notes;

        document.getElementById('editExpenseForm').action = `{{ url('/accounts/expenses') }}/${id}`;
        document.getElementById('editExpenseDate').value = date;
        document.getElementById('editExpensePurpose').value = purpose;
        document.getElementById('editExpenseCategory').value = category;
        document.getElementById('editExpenseAmount').value = amount;
        document.getElementById('editExpenseSpentBy').value = spentBy || '';
        document.getElementById('editExpenseNotes').value = notes || '';

        document.getElementById('editExpenseModal').classList.remove('hidden');
    }
    function closeEditExpenseModal() {
        document.getElementById('editExpenseModal').classList.add('hidden');
    }

    // Export Accounts Statement to Excel (.xlsx) using SheetJS
    function exportAccountsToExcel() {
        if (typeof XLSX === 'undefined') {
            window.location.href = `{{ route('accounts.export') }}?month=${encodeURIComponent(SELECTED_MONTH)}`;
            return;
        }

        const wb = XLSX.utils.book_new();

        // 1. Inflow Sheet Data
        const inflowRows = document.querySelectorAll('#inflowTable tbody tr.receipt-row');
        const inflowData = [];
        inflowRows.forEach((r, idx) => {
            inflowData.push({
                '#': idx + 1,
                'Receipt No': r.dataset.receiptNo,
                'Date': r.dataset.date,
                'Client Name': r.dataset.client,
                'Contact': r.dataset.contact || '',
                'Purpose': r.dataset.purpose || '',
                'Payment Method': r.dataset.method || '',
                'Amount Received (BDT)': parseFloat(r.dataset.received || 0),
                'Due Balance (BDT)': parseFloat(r.dataset.due || 0)
            });
        });

        const wsInflow = XLSX.utils.json_to_sheet(inflowData);
        wsInflow['!cols'] = [
            { wch: 6 }, { wch: 16 }, { wch: 14 }, { wch: 22 }, { wch: 16 }, { wch: 26 }, { wch: 14 }, { wch: 20 }, { wch: 18 }
        ];
        XLSX.utils.book_append_sheet(wb, wsInflow, 'Client Inflow');

        // 2. Expenses Sheet Data
        const expenseRows = document.querySelectorAll('#expensesTable tbody tr.expense-row');
        const expenseData = [];
        expenseRows.forEach((r, idx) => {
            expenseData.push({
                '#': idx + 1,
                'Date': r.dataset.date,
                'Purpose / Item': r.dataset.purpose,
                'Category': r.dataset.category,
                'Spent By': r.dataset.spentBy || '',
                'Notes': r.dataset.notes || '',
                'Amount (BDT)': parseFloat(r.dataset.amount || 0)
            });
        });

        const wsExpenses = XLSX.utils.json_to_sheet(expenseData);
        wsExpenses['!cols'] = [
            { wch: 6 }, { wch: 14 }, { wch: 26 }, { wch: 18 }, { wch: 16 }, { wch: 24 }, { wch: 16 }
        ];
        XLSX.utils.book_append_sheet(wb, wsExpenses, 'Office Expenses');

        const safeMonth = (SELECTED_MONTH || 'Statement').replace(/[^a-zA-Z0-9_-]/g, '_');
        const today = new Date().toISOString().split('T')[0];
        const fileName = `Accounts_Statement_${safeMonth}_${today}.xlsx`;

        XLSX.writeFile(wb, fileName);
        showToast('Accounts statement exported to Excel ✓');
    }
</script>

</body>
</html>
