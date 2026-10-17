<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Lead - {{ $lead->client_name }}</title>
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
<aside class="w-60 bg-primary text-white flex flex-col shrink-0 p-4 space-y-2 hidden md:flex min-h-screen">
    <div class="flex flex-col space-y-2.5 mb-6 px-1">
        <div class="bg-white rounded-xl p-2.5 flex items-center justify-center w-full shadow-sm">
            <img class="h-12 w-auto max-w-full object-contain" src="{{ asset('images/logo.png') }}" alt="Logo"/>
        </div>
        <div>
            <h1 class="text-xs font-bold text-cyan-400 leading-snug">Lead & Project Management System</h1>
        </div>
    </div>
    <nav class="space-y-1">
        <a class="flex items-center px-3 py-2 text-white/70 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.index') }}">
            <span class="material-symbols-outlined mr-2 text-[18px]">dashboard</span> Dashboard
        </a>
        <a class="flex items-center px-3 py-2 text-white/70 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.create') }}">
            <span class="material-symbols-outlined mr-2 text-[18px]">add_box</span> Add New Project
        </a>
        <a class="flex items-center px-3 py-2 text-white/70 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.list') }}">
            <span class="material-symbols-outlined mr-2 text-[18px]">folder_open</span> Projects
        </a>
        <a class="flex items-center px-3 py-2 bg-slate-800 text-white rounded-md text-xs font-bold" href="{{ route('leads.index') }}">
            <span class="material-symbols-outlined mr-2 text-[18px]">contacts</span> Lead Tracking
        </a>
        <a class="flex items-center px-3 py-2 text-white/70 hover:bg-white/10 rounded-md text-xs" href="{{ route('invoices.create') }}">
            <span class="material-symbols-outlined mr-2 text-[18px]">receipt_long</span> Money Receipt
        </a>
    </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 flex flex-col min-h-screen">
    <header class="bg-surface border-b border-border-light flex items-center justify-between px-6 h-14 shrink-0">
        <div class="flex items-center space-x-3">
            <a href="{{ route('leads.index') }}" class="text-slate-500 hover:text-slate-800 flex items-center">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <h1 class="font-headline-md font-bold text-slate-900 text-base">Edit Lead: {{ $lead->client_name }}</h1>
        </div>
    </header>

    <div class="p-6 max-w-4xl w-full mx-auto">
        <form action="{{ route('leads.update', $lead->id) }}" method="POST" class="bg-white border border-slate-200 shadow-sm rounded-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Client Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Client Name / Business Name *</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $lead->client_name) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Niche -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Niche / Category</label>
                    <input type="text" name="niche" value="{{ old('niche', $lead->niche) }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contact Number *</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $lead->contact_number) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $lead->email) }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Campaign / Month Tab -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Campaign / Month Tab *</label>
                    <input type="text" name="campaign_month" value="{{ old('campaign_month', $lead->campaign_month) }}" list="campaignList" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                    <datalist id="campaignList">
                        @foreach($existingCampaigns as $camp)
                            <option value="{{ $camp }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Lead Incoming Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Incoming Date *</label>
                    <input type="date" name="lead_incoming_date" value="{{ old('lead_incoming_date', \Carbon\Carbon::parse($lead->lead_incoming_date)->format('Y-m-d')) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Quoted Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Quoted Amount</label>
                    <input type="text" name="quoted_amount" value="{{ old('quoted_amount', $lead->quoted_amount) }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>

                <!-- Sold Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sold Amount</label>
                    <input type="text" name="sold_amount" value="{{ old('sold_amount', $lead->sold_amount) }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary"/>
                </div>
            </div>

            <!-- Work Scope Tags -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Work Scope (Tech Tags)</label>
                <div class="flex flex-wrap gap-3">
                    @php $currentScope = is_array($lead->work_scope) ? $lead->work_scope : []; @endphp
                    @foreach(['MERN', 'Laravel', 'WordPress', 'React', 'Vue', 'Next.js', 'Flutter', 'Multivendor', 'E-commerce'] as $tag)
                        <label class="inline-flex items-center space-x-1.5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-md cursor-pointer text-xs font-medium hover:bg-slate-100">
                            <input type="checkbox" name="work_scope[]" value="{{ $tag }}" {{ in_array($tag, $currentScope) ? 'checked' : '' }} class="rounded text-secondary focus:ring-secondary"/>
                            <span>{{ $tag }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status (Manually Typed Text) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status (Manually Typed) *</label>
                <input type="text" name="status" value="{{ old('status', $lead->status) }}" list="statusSuggestions" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary font-medium text-slate-900"/>
                <datalist id="statusSuggestions">
                    <option value="Quotation deya hoise">
                    <option value="Mirpur office e jeye kotha bolte hobe">
                    <option value="Office e ashbe">
                    <option value="Kotha hoy nai">
                    <option value="Call recieve kore nai, message deya hoise">
                    <option value="Whats app e reply dei nai">
                    <option value="Won (Converted to Project)">
                    <option value="Lost / Not Interested">
                </datalist>
            </div>

            <!-- Note -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Note / Observation</label>
                <textarea name="note" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary">{{ old('note', $lead->note) }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                <a href="{{ route('leads.index', ['campaign' => $lead->campaign_month]) }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-secondary text-white text-xs font-bold rounded-md hover:bg-cyan-700 shadow-sm">Update Lead</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
