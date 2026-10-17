<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Add New Lead - Arbeit Technology</title>
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
    <nav class="space-y-1.5">
        <a class="flex items-center px-3 py-2 text-white/75 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.index') }}">
            <img src="{{ asset('images/icons/dashboard.png') }}" alt="Dashboard" class="w-4 h-4 mr-2 object-contain shrink-0"/> Dashboard
        </a>
        <a class="flex items-center px-3 py-2 text-white/75 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.create') }}">
            <img src="{{ asset('images/icons/add-project.png') }}" alt="Add New Project" class="w-4 h-4 mr-2 object-contain shrink-0"/> Add New Project
        </a>
        <a class="flex items-center px-3 py-2 text-white/75 hover:bg-white/10 rounded-md text-xs" href="{{ route('projects.list') }}">
            <img src="{{ asset('images/icons/projects.png') }}" alt="Projects" class="w-4 h-4 mr-2 object-contain shrink-0"/> Projects
        </a>
        <a class="flex items-center px-3 py-2 bg-slate-800 text-cyan-300 rounded-md text-xs font-bold" href="{{ route('leads.index') }}">
            <img src="{{ asset('images/icons/leads.png') }}" alt="Lead Tracking" class="w-4 h-4 mr-2 object-contain shrink-0"/> Lead Tracking
        </a>
        <a class="flex items-center px-3 py-2 text-white/75 hover:bg-white/10 rounded-md text-xs" href="{{ route('invoices.create') }}">
            <img src="{{ asset('images/icons/receipt.png') }}" alt="Money Receipt" class="w-4 h-4 mr-2 object-contain shrink-0"/> Money Receipt
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
            <h1 class="font-headline-md font-bold text-slate-900 text-base">Add New Lead</h1>
        </div>
    </header>

    <div class="p-6 max-w-4xl w-full mx-auto">
        <form action="{{ route('leads.store') }}" method="POST" class="bg-white border border-slate-200 shadow-sm rounded-lg p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Client Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Client Name / Business Name *</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" required placeholder="e.g. MD Kefayet Ullah Sumon" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                    @error('client_name') <span class="text-rose-500 text-[11px]">{{ $message }}</span> @enderror
                </div>

                <!-- Niche -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Niche / Category</label>
                    <input type="text" name="niche" value="{{ old('niche') }}" placeholder="e.g. E-commerce Multi Category, Portfolio Website" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contact Number (Phone / WhatsApp) *</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number') }}" required placeholder="e.g. 01980393098" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="client@example.com" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>

                <!-- Campaign / Month Tab -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Campaign / Month Tab *</label>
                    <input type="text" name="campaign_month" value="{{ old('campaign_month', $defaultCampaign) }}" list="campaignList" required placeholder="e.g. August 2026 (2nd Ad)" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                    <datalist id="campaignList">
                        @foreach($existingCampaigns as $camp)
                            <option value="{{ $camp }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Lead Incoming Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Incoming Date *</label>
                    <input type="date" name="lead_incoming_date" value="{{ old('lead_incoming_date', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>

                <!-- Quoted Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Quoted Amount</label>
                    <input type="text" name="quoted_amount" value="{{ old('quoted_amount') }}" placeholder="e.g. ৳115,000 or 20000-25000" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>

                <!-- Sold Amount -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sold Amount (if closed)</label>
                    <input type="text" name="sold_amount" value="{{ old('sold_amount') }}" placeholder="e.g. ৳115,000" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary"/>
                </div>
            </div>

            <!-- Work Scope Tags -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Work Scope (Tech Tags)</label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['MERN', 'Laravel', 'WordPress', 'React', 'Vue', 'Next.js', 'Flutter', 'Multivendor', 'E-commerce'] as $tag)
                        <label class="inline-flex items-center space-x-1.5 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-md cursor-pointer text-xs font-medium hover:bg-slate-100">
                            <input type="checkbox" name="work_scope[]" value="{{ $tag }}" class="rounded text-secondary focus:ring-secondary"/>
                            <span>{{ $tag }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status (Manually Typed Text) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Status (Manually Typed) *</label>
                <input type="text" name="status" value="{{ old('status', 'Quotation deya hoise') }}" list="statusSuggestions" required placeholder="Type status manually e.g. Quotation deya hoise, Office e ashbe" class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary font-medium text-slate-900"/>
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
                <textarea name="note" rows="3" placeholder="Enter conversation details or requirement notes..." class="w-full px-3 py-2 border border-slate-300 rounded-md text-xs focus:ring-1 focus:ring-secondary focus:border-secondary">{{ old('note') }}</textarea>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                <a href="{{ route('leads.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-md hover:bg-slate-200">Cancel</a>
                <button type="submit" class="px-5 py-2 bg-secondary text-white text-xs font-bold rounded-md hover:bg-cyan-700 shadow-sm">Save Lead</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
