<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lead Details - {{ $lead->client_name }}</title>
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
                        "secondary": "#006972",
                        "primary": "#091426",
                        "border-light": "#E2E8F0",
                        "surface-subtle": "#F8FAFC",
                        "surface": "#fbf8fa"
                    },
                    "fontFamily": {
                        "label-md": ["Hanken Grotesk"],
                        "headline-md": ["DM Sans"],
                        "body-md": ["Hanken Grotesk"]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-surface-subtle text-on-surface font-body-md min-h-screen flex flex-col md:flex-row">

<!-- SideNavBar -->
<aside class="w-52 bg-slate-900 text-white flex flex-col shrink-0 p-4 space-y-2 hidden md:flex min-h-screen border-r border-slate-800">
    <div class="flex flex-col space-y-2.5 mb-6 px-1">
        <div class="bg-white rounded-xl p-2.5 flex items-center justify-center w-full shadow-sm">
            <img class="h-11 w-auto max-w-full object-contain" src="{{ asset('images/logo.png') }}" alt="Logo"/>
        </div>
        <div>
            <h1 class="text-xs font-bold text-cyan-400 leading-snug">Lead & Project Management System</h1>
        </div>
    </div>
    <nav class="space-y-1.5">
        <a class="flex items-center px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-md text-xs font-medium transition-all" href="{{ route('projects.index') }}">
            <img src="{{ asset('images/icons/dashboard.png') }}" alt="Dashboard" class="w-4 h-4 mr-2 object-contain shrink-0"/> Dashboard
        </a>
        <a class="flex items-center px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-md text-xs font-medium transition-all" href="{{ route('projects.create') }}">
            <img src="{{ asset('images/icons/add-project.png') }}" alt="Add New Project" class="w-4 h-4 mr-2 object-contain shrink-0"/> Add New Project
        </a>
        <a class="flex items-center px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-lg transition-all font-medium group" href="{{ route('projects.list') }}">
            <img src="{{ asset('images/icons/projects.png') }}" alt="Projects" class="w-4 h-4 mr-2 object-contain shrink-0"/> Projects
        </a>
        <a class="flex items-center px-3 py-2 bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 rounded-md text-xs font-semibold shadow-xs" href="{{ route('leads.index') }}">
            <img src="{{ asset('images/icons/leads.png') }}" alt="Lead Tracking" class="w-4 h-4 mr-2 object-contain shrink-0"/> Lead Tracking
        </a>
        <a class="flex items-center px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-md text-xs font-medium transition-all" href="{{ route('accounts.index') }}">
            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-cyan-400 mr-2 shrink-0">account_balance_wallet</span> Accounts
        </a>
        <a class="flex items-center px-3 py-2 text-slate-300 hover:text-white hover:bg-slate-800/80 rounded-md text-xs font-medium transition-all" href="{{ route('invoices.create') }}">
            <img src="{{ asset('images/icons/receipt.png') }}" alt="Money Receipt" class="w-4 h-4 mr-2 object-contain shrink-0"/> Money Receipt
        </a>
    </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 flex flex-col min-h-screen">
    <header class="bg-surface border-b border-border-light flex items-center justify-between px-6 h-14 shrink-0">
        <div class="flex items-center space-x-3">
            <a href="{{ route('leads.index', ['campaign' => $lead->campaign_month]) }}" class="text-slate-500 hover:text-slate-800 flex items-center">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <h1 class="font-headline-md font-bold text-slate-900 text-base">Lead Profile: {{ $lead->client_name }}</h1>
        </div>
        <div class="flex items-center space-x-2">
            @if(!$lead->project_id)
                <form action="{{ route('leads.convert', $lead->id) }}" method="POST" onsubmit="return confirm('Convert this lead into an active Project?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-md shadow-sm">
                        <span class="material-symbols-outlined text-[16px] mr-1">rocket_launch</span>
                        Convert to Project
                    </button>
                </form>
            @else
                <a href="{{ route('projects.show', $lead->project_id) }}" class="inline-flex items-center px-3 py-1.5 bg-cyan-700 hover:bg-cyan-800 text-white text-xs font-bold rounded-md shadow-sm">
                    <span class="material-symbols-outlined text-[16px] mr-1">folder</span>
                    View Linked Project
                </a>
            @endif
            <a href="{{ route('leads.edit', $lead->id) }}" class="px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold rounded-md border border-slate-300">
                Edit Lead
            </a>
        </div>
    </header>

    <div class="p-6 max-w-5xl w-full mx-auto space-y-6">

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-md flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500"><span class="material-symbols-outlined text-[16px]">close</span></button>
            </div>
        @endif

        <!-- Profile Overview Card -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-4">
                <div>
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-mono text-[10px] font-bold rounded uppercase">
                        {{ $lead->campaign_month }}
                    </span>
                    <h2 class="text-xl font-bold text-slate-900 mt-1">{{ $lead->client_name }}</h2>
                    <p class="text-xs text-slate-500 font-medium">{{ $lead->niche ?: 'General Client' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Contact Number:</span>
                        <div class="flex items-center space-x-2 mt-0.5">
                            <span class="font-mono font-bold text-slate-800 text-sm">{{ $lead->contact_number }}</span>
                            @php $cleanPhone = preg_replace('/[^0-9]/', '', $lead->contact_number); @endphp
                            @if($cleanPhone)
                                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="inline-flex items-center px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[11px] font-bold hover:bg-emerald-200">
                                    WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <span class="text-slate-400 block font-medium">Incoming Date:</span>
                        <span class="font-mono font-semibold text-slate-800 text-xs mt-0.5 block">
                            {{ \Carbon\Carbon::parse($lead->lead_incoming_date)->format('F j, Y') }}
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-400 block font-medium">Quoted Amount:</span>
                        <span class="font-mono font-bold text-slate-900 text-sm mt-0.5 block">
                            {{ $lead->quoted_amount ?: 'Not specified' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-slate-400 block font-medium">Sold Amount:</span>
                        <span class="font-mono font-bold text-emerald-700 text-sm mt-0.5 block">
                            {{ $lead->sold_amount ?: 'Pending' }}
                        </span>
                    </div>
                </div>

                <!-- Work Scope Badges -->
                <div>
                    <span class="text-slate-400 block text-xs font-medium mb-1">Work Scope:</span>
                    <div class="flex flex-wrap gap-1.5">
                        @if(is_array($lead->work_scope) && count($lead->work_scope) > 0)
                            @foreach($lead->work_scope as $scope)
                                <span class="px-2 py-0.5 bg-cyan-50 border border-cyan-200 text-cyan-800 font-bold text-xs rounded">
                                    {{ $scope }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-slate-400 italic text-xs">No scope specified</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status & Action Box -->
            <div class="bg-slate-50 border border-slate-200 rounded-md p-4 flex flex-col justify-between space-y-4">
                <div>
                    <span class="text-slate-400 block text-xs font-medium">Current Status (Typed):</span>
                    <div class="mt-1 p-2 bg-amber-50 border border-amber-200 text-amber-900 rounded font-bold text-xs">
                        {{ $lead->status }}
                    </div>
                </div>

                <div>
                    <span class="text-slate-400 block text-xs font-medium">Latest Observation Note:</span>
                    <p class="text-xs text-slate-700 mt-1 italic bg-white p-2 border border-slate-200 rounded">
                        "{{ $lead->note ?: 'No note recorded' }}"
                    </p>
                </div>
            </div>
        </div>

        <!-- Activity Log & Conversation Timeline -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-lg p-6 space-y-6">
            <h3 class="font-headline-md font-bold text-slate-900 text-sm flex items-center">
                <span class="material-symbols-outlined text-secondary mr-2">history</span>
                Conversation Log & Activity History
            </h3>

            <!-- Add Follow-Up Note Form -->
            <form action="{{ route('leads.add-note', $lead->id) }}" method="POST" class="space-y-3 bg-slate-50 p-4 border border-slate-200 rounded-md">
                @csrf
                <label class="block text-xs font-bold text-slate-700">Add Call / Meeting Note</label>
                <textarea name="note_content" rows="2" required placeholder="e.g. Called client. Agreed on ৳25,000 budget. Meeting scheduled tomorrow at 3 PM..." class="w-full px-3 py-2 border border-slate-300 rounded text-xs focus:ring-1 focus:ring-secondary"></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded shadow-xs">
                        Log Activity Note
                    </button>
                </div>
            </form>

            <!-- Timeline Entries -->
            <div class="space-y-4 pt-2">
                @forelse($lead->notes as $noteLog)
                    <div class="flex items-start space-x-3 text-xs border-l-2 border-slate-200 pl-4 py-1">
                        <div class="flex-1 bg-slate-50 border border-slate-200 rounded-md p-3">
                            <div class="flex items-center justify-between text-slate-500 mb-1">
                                <span class="font-bold text-slate-800">{{ $noteLog->logged_by }}</span>
                                <span class="font-mono text-[11px]">{{ $noteLog->created_at->format('M j, Y h:i A') }}</span>
                            </div>
                            <p class="text-slate-800 whitespace-pre-line">{{ $noteLog->note_content }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">No historical activity logs recorded yet.</p>
                @endforelse
            </div>
        </div>

    </div>
</main>

</body>
</html>
