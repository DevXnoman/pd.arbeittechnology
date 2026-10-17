<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbeit Technology - Project Documentation</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm 10mm;
            }
            html, body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                height: auto !important;
                min-height: auto !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print, .no-print * {
                display: none !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                visibility: hidden !important;
            }
            .letterhead-pad {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-height: auto !important;
                height: auto !important;
                border: none !important;
            }

            /* Prevent ANY section, table, or section header from breaking across pages */
            .pad-content > div,
            .pad-content table,
            .pad-content tr,
            .pad-content tbody,
            .print-prevent-break {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                break-inside: avoid-page !important;
            }

            .pad-content h3 {
                page-break-after: avoid !important;
                break-after: avoid !important;
                break-after: avoid-page !important;
            }

            .hidden-for-print, #printableQuotationContainer.hidden-for-print {
                display: none !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .show-for-print {
                display: block !important;
            }
            .page-break-before {
                page-break-before: always !important;
                break-before: page !important;
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
            #printableQuotationContainer {
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
            }
            #printableQuotationContainer .letterhead-pad {
                padding: 0 !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
            #quotationIframe {
                height: 275mm !important;
                width: 100% !important;
                border: none !important;
            }
        }
        .letterhead-pad {
            width: 100%;
            max-width: 210mm;
            min-height: auto;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 1rem;
            position: relative;
            box-sizing: border-box;
        }
        @media (min-width: 640px) {
            .letterhead-pad {
                padding: 8mm 12mm;
            }
        }
        @media (min-width: 768px) {
            .letterhead-pad {
                min-height: 297mm;
                padding: 10mm 15mm;
            }
        }

        .pad-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-slate-100 py-10">

    <!-- Action Bar -->
    <div class="max-w-[210mm] mx-auto mb-4 flex flex-wrap justify-between items-center gap-2.5 px-3 no-print">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition">
            <span class="material-symbols-outlined text-[18px] text-slate-500">arrow_back</span>
            Back to Dashboard
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-300 shadow-sm transition">
                <span class="material-symbols-outlined text-[18px] text-amber-600">edit</span>
                Edit Project
            </a>
            <button onclick="handlePrintClick()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-lg text-xs font-semibold text-white bg-cyan-700 hover:bg-cyan-800 shadow transition cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">print</span>
                Print / Save PDF
            </button>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 shadow-sm transition cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-[210mm] mx-auto mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg no-print">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-[210mm] mx-auto overflow-x-auto px-2 sm:px-0">

    <!-- Main Letterhead Container -->
    <div class="letterhead-pad text-slate-800 text-xs border border-slate-300">

        <div class="pad-content">

            <!-- HEADER -->
            <div class="flex justify-between items-center border-b border-cyan-500/80 pb-3 mb-4">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Arbeit Technology Logo" class="h-20 w-auto object-contain">
                </div>
                <div class="text-right text-[11px] text-slate-700 space-y-1 font-medium leading-tight">
                    <p><strong>Phone:</strong> +880 1707-387608</p>
                    <p><strong>Email:</strong> contact@arbeittechnology.com</p>
                    <p><strong>Website:</strong> arbeittechnology.com</p>
                    <p><strong>Address:</strong> C-26, Road-3, Banasree, Dhaka-1219</p>
                </div>
            </div>

            <!-- 1. PROJECT INFORMATION -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">1. Project Information & Status</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Project Name *</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">{{ $project->project_name }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Project Type</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">{{ $project->project_type }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Client / Company *</td>
                        <td class="border border-slate-300 p-1.5 font-medium">{{ $project->client_name }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Status</td>
                        <td class="border border-slate-300 p-1.5 font-bold text-cyan-800">{{ $project->status }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Start Date *</td>
                        <td class="border border-slate-300 p-1.5 font-medium">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Target Delivery *</td>
                        <td class="border border-slate-300 p-1.5 font-medium">{{ $project->target_delivery_date ? \Carbon\Carbon::parse($project->target_delivery_date)->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr class="no-print">
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Priority</td>
                        <td colspan="3" class="border border-slate-300 p-1.5 font-medium">{{ $project->priority }}</td>
                    </tr>
                </table>
            </div>

            <!-- 2. TEAM ALLOCATION & RESPONSIBILITIES -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">2. Team Allocation & Responsibilities</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 text-left">Role</th>
                        <th class="border border-slate-300 p-1 text-left">Team Member Name</th>
                        <th class="border border-slate-300 p-1 text-left">Core Responsibility</th>
                    </tr>
                    @forelse($project->teams as $team)
                        <tr>
                            <td class="border border-slate-300 p-1.5 font-semibold bg-slate-50/50">{{ $team->role }}</td>
                            <td class="border border-slate-300 p-1.5 font-medium">{{ $team->team_member }}</td>
                            <td class="border border-slate-300 p-1.5 text-slate-600">{{ $team->responsibility ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border border-slate-300 p-1.5 text-slate-500 italic text-center">No team allocation defined.</td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <!-- 3. TECHNICAL SPECIFICATIONS & STACK -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">3. Technical Specifications & Stack</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Frontend Framework:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">{{ $project->stack_frontend ?? 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Backend Framework:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">{{ $project->stack_backend ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Database Engine:</td>
                        <td colspan="3" class="border border-slate-300 p-1.5 font-medium">{{ $project->stack_database ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <!-- 4. QUOTATION & FINANCIAL RECORD -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">4. Quotation & Financial Record</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Quotation File Ref:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">
                            @if(!empty($project->quotation_file))
                                @php
                                    $isUrl = \Illuminate\Support\Str::startsWith($project->quotation_file, ['http://', 'https://']);
                                    $fileUrl = $isUrl ? $project->quotation_file : asset($project->quotation_file);
                                @endphp
                                <a href="{{ $fileUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-800 border border-cyan-300 font-semibold text-xs transition shadow-2xs">
                                    <span class="material-symbols-outlined text-[16px] text-cyan-600">visibility</span>
                                    <span>{{ $isUrl ? 'View Drive Quotation' : 'View Quotation PDF' }}</span>
                                </a>
                            @else
                                <span class="text-slate-400 italic">Not Uploaded</span>
                            @endif
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Total Project Cost:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-bold text-slate-900">{{ $project->total_cost ?? 'N/A' }}</td>
                    </tr>
                </table>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 text-left">Payment Milestone</th>
                        <th class="border border-slate-300 p-1 text-left">Amount</th>
                        <th class="border border-slate-300 p-1 text-left">Date Paid</th>
                        <th class="border border-slate-300 p-1 text-left">Status</th>
                    </tr>
                    @forelse($project->finances as $finance)
                        <tr>
                            <td class="border border-slate-300 p-1.5 font-medium">{{ $finance->milestone_name }}</td>
                            <td class="border border-slate-300 p-1.5 font-semibold">{{ $finance->amount ?? 'N/A' }}</td>
                            <td class="border border-slate-300 p-1.5">{{ $finance->date_paid ? \Carbon\Carbon::parse($finance->date_paid)->format('M d, Y') : 'N/A' }}</td>
                            <td class="border border-slate-300 p-1.5">
                                <span class="{{ $finance->status === 'Paid' ? 'text-emerald-600 font-bold' : 'text-amber-600 font-medium' }}">
                                    ✓ {{ $finance->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-slate-300 p-1.5 text-slate-500 italic text-center">No payment milestones recorded.</td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <!-- 5. REVISION & BUG TRACKING -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">5. Revision & Bug Tracking Log</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 w-12 text-center">No.</th>
                        <th class="border border-slate-300 p-1 w-28">Date Requested</th>
                        <th class="border border-slate-300 p-1 text-left">Revision / Bug Description</th>
                        <th class="border border-slate-300 p-1 w-28">Status</th>
                    </tr>
                    @forelse($project->revisions as $index => $revision)
                        <tr>
                            <td class="border border-slate-300 p-1 text-center font-bold">0{{ $index + 1 }}</td>
                            <td class="border border-slate-300 p-1">{{ $revision->request_date ? \Carbon\Carbon::parse($revision->request_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="border border-slate-300 p-1">{{ $revision->description }}</td>
                            <td class="border border-slate-300 p-1 font-semibold {{ $revision->status === 'Done' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $revision->status }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-slate-300 p-1.5 text-slate-500 italic text-center">No revision or bug logs recorded.</td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <!-- 6. CHANGE REQUEST & EXTRA WORK -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">6. Change Request & Extra Work (Scope Creep)</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 w-28">Date</th>
                        <th class="border border-slate-300 p-1 text-left">Extra Feature / Scope Change</th>
                        <th class="border border-slate-300 p-1 w-24">Extra Cost</th>
                        <th class="border border-slate-300 p-1 w-28">Approved?</th>
                    </tr>
                    @forelse($project->changeRequests as $cr)
                        <tr>
                            <td class="border border-slate-300 p-1">{{ $cr->request_date ? \Carbon\Carbon::parse($cr->request_date)->format('M d, Y') : 'N/A' }}</td>
                            <td class="border border-slate-300 p-1">{{ $cr->feature_description }}</td>
                            <td class="border border-slate-300 p-1 font-semibold">{{ $cr->extra_cost ?? 'N/A' }}</td>
                            <td class="border border-slate-300 p-1 font-semibold {{ $cr->is_approved === 'Yes' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $cr->is_approved }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-slate-300 p-1.5 text-slate-500 italic text-center">No extra scope / change requests recorded.</td>
                        </tr>
                    @endforelse
                </table>
            </div>

            <!-- 7. SERVER, DOMAIN & CREDENTIAL INFRASTRUCTURE -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">7. Server, Domain & Access Credentials</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain URL:</td>
                        <td class="border border-slate-300 p-1.5 w-4/5 font-bold text-cyan-700" colspan="3">
                            @if(!empty($project->infrastructure?->domain_url))
                                <a href="{{ Str::startsWith($project->infrastructure->domain_url, ['http://', 'https://']) ? $project->infrastructure->domain_url : 'https://' . $project->infrastructure->domain_url }}" target="_blank" class="underline hover:text-cyan-900">
                                    {{ $project->infrastructure->domain_url }}
                                </a>
                            @else
                                <span class="text-slate-400 font-normal italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain Provider:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">{{ $project->infrastructure?->domain_provider ?? 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain Access:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">
                            @if(!empty($project->infrastructure?->domain_user) || !empty($project->infrastructure?->domain_pass))
                                <span><strong>User:</strong> {{ $project->infrastructure->domain_user ?? '-' }}</span> | 
                                <span><strong>Pass:</strong> {{ $project->infrastructure->domain_pass ?? '-' }}</span>
                            @else
                                <span class="text-slate-400 italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Hosting Provider:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">{{ $project->infrastructure?->hosting_provider ?? 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Hosting Access:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">
                            @if(!empty($project->infrastructure?->hosting_user) || !empty($project->infrastructure?->hosting_pass))
                                <span><strong>User:</strong> {{ $project->infrastructure->hosting_user ?? '-' }}</span> | 
                                <span><strong>Pass:</strong> {{ $project->infrastructure->hosting_pass ?? '-' }}</span>
                            @else
                                <span class="text-slate-400 italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Server IP Address:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">{{ $project->infrastructure?->server_ip ?? 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Panel / Access URL:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10 font-medium">
                            @if(!empty($project->infrastructure?->panel_url))
                                <a href="{{ Str::startsWith($project->infrastructure->panel_url, ['http://', 'https://']) ? $project->infrastructure->panel_url : 'https://' . $project->infrastructure->panel_url }}" target="_blank" class="text-cyan-700 underline font-semibold">
                                    {{ $project->infrastructure->panel_url }}
                                </a>
                            @else
                                <span class="text-slate-400 italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @if(!empty($project->infrastructure?->extra_credentials) && is_array($project->infrastructure->extra_credentials) && count($project->infrastructure->extra_credentials) > 0)
                <table class="w-full border-collapse border border-slate-300 mt-1">
                    <tr class="bg-slate-50 text-xs">
                        <th class="border border-slate-300 p-1 text-left w-1/4">Access / Credential Title</th>
                        <th class="border border-slate-300 p-1 text-left w-1/4">Username / Email</th>
                        <th class="border border-slate-300 p-1 text-left w-1/4">Password / Secret Key</th>
                        <th class="border border-slate-300 p-1 text-left">Notes / Details</th>
                    </tr>
                    @foreach($project->infrastructure->extra_credentials as $cred)
                        <tr>
                            <td class="border border-slate-300 p-1.5 font-semibold bg-slate-50/30">{{ $cred['title'] ?? '-' }}</td>
                            <td class="border border-slate-300 p-1.5 font-medium">{{ $cred['username'] ?? '-' }}</td>
                            <td class="border border-slate-300 p-1.5 font-medium text-slate-800">{{ $cred['password'] ?? '-' }}</td>
                            <td class="border border-slate-300 p-1.5 text-slate-600">{{ $cred['notes'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>
                @endif
            </div>

            <!-- 8. POST-DELIVERY SUPPORT & MAINTENANCE -->
            <div class="print-prevent-break">
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">8. Post-Delivery Support & Maintenance</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Free Support Period</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">{{ $project->support_period ?? 'N/A' }}</td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Support Expiry Date</td>
                        <td class="border border-slate-300 p-1.5 w-1/4 font-medium">
                            {{ $project->support_expiry ? \Carbon\Carbon::parse($project->support_expiry)->format('M d, Y') : 'N/A' }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 9. FINAL HANDOVER CHECKLIST -->
            <div class="print-prevent-break">
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">9. Final Handover Checklist</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 text-left">Handover Task</th>
                        <th class="border border-slate-300 p-1 w-24 text-center">Status</th>
                    </tr>
                    @php
                        $chk = $project->handover_checklist ?? [];
                    @endphp
                    <tr>
                        <td class="border border-slate-300 p-1">1. Production Deployment & Env Optimized</td>
                        <td class="border border-slate-300 p-1 text-center font-bold {{ !empty($chk['chk_1']) ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ !empty($chk['chk_1']) ? '☑ Completed' : '☐ Pending' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1">2. Database Migration & Seeders Executed</td>
                        <td class="border border-slate-300 p-1 text-center font-bold {{ !empty($chk['chk_2']) ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ !empty($chk['chk_2']) ? '☑ Completed' : '☐ Pending' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1">3. Final QA & Client Approval Received</td>
                        <td class="border border-slate-300 p-1 text-center font-bold {{ !empty($chk['chk_3']) ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ !empty($chk['chk_3']) ? '☑ Completed' : '☐ Pending' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1">4. Source Code & Admin Access Transferred</td>
                        <td class="border border-slate-300 p-1 text-center font-bold {{ !empty($chk['chk_4']) ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ !empty($chk['chk_4']) ? '☑ Completed' : '☐ Pending' }}
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- FOOTER SIGNATURE -->
        <div class="mt-10 pt-4 border-t border-slate-300 flex justify-between items-end text-[11px] text-slate-600">
            <p>Generated by Arbeit Technology Management System</p>
            <div class="text-center">
                <div class="h-16"></div>
                <p class="border-t border-slate-500 pt-1 px-8">Authorised Signature</p>
            </div>
        </div>

        </div> <!-- /pad-content -->

    </div>
    </div> <!-- /overflow-x-auto wrapper -->

    @if(!empty($project->quotation_file))
        @php
            $isUrl = \Illuminate\Support\Str::startsWith($project->quotation_file, ['http://', 'https://']);
            $fileUrl = $isUrl ? $project->quotation_file : asset($project->quotation_file);
        @endphp
        <!-- PRINTABLE QUOTATION CONTAINER -->
        <div id="printableQuotationContainer" class="hidden-for-print page-break-before mt-8 max-w-[210mm] mx-auto">
            <div class="letterhead-pad text-slate-800 text-xs border border-slate-300 p-0 overflow-hidden">
                <div class="bg-[#36a3ae] text-white font-bold px-4 py-2 uppercase text-xs tracking-wide no-print flex justify-between items-center">
                    <span>Attached Quotation Document</span>
                    <a href="{{ $fileUrl }}" target="_blank" class="text-white hover:underline text-[11px]">Open Original File ↗</a>
                </div>
                <iframe id="quotationIframe" src="{{ $fileUrl }}#toolbar=0&navpanes=0" class="w-full h-[1050px] border-0"></iframe>
            </div>
        </div>
    @endif

    <!-- PRINT OPTIONS MODAL POPUP -->
    <div id="printModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 no-print">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 border border-slate-200 animate-in fade-in zoom-in duration-200">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-cyan-700 text-[24px]">print</span>
                    <h3 class="font-bold text-slate-900 text-sm">Print / Save PDF Options</h3>
                </div>
                <button onclick="closePrintModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <p class="text-xs text-slate-600 mt-3 mb-4">Choose what content you want to include in your print output or PDF export:</p>

            <div class="space-y-3">
                <!-- Option 1: Only Documentation -->
                <button onclick="executePrint(false)" class="w-full text-left p-3.5 rounded-xl border border-slate-200 hover:border-cyan-600 hover:bg-cyan-50/50 transition group flex items-start gap-3 cursor-pointer">
                    <div class="p-2 rounded-lg bg-slate-100 group-hover:bg-cyan-100 text-slate-700 group-hover:text-cyan-800 transition shrink-0">
                        <span class="material-symbols-outlined text-[22px]">description</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-xs text-slate-800 group-hover:text-cyan-900">1. Only Project Documentation</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Prints only the A4 Arbeit Technology Documentation letterhead pad.</p>
                    </div>
                </button>

                <!-- Option 2: Documentation + Quotation -->
                <button onclick="executePrint(true)" class="w-full text-left p-3.5 rounded-xl border border-slate-200 hover:border-cyan-600 hover:bg-cyan-50/50 transition group flex items-start gap-3 cursor-pointer">
                    <div class="p-2 rounded-lg bg-slate-100 group-hover:bg-cyan-100 text-slate-700 group-hover:text-cyan-800 transition shrink-0">
                        <span class="material-symbols-outlined text-[22px]">attachment</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-xs text-slate-800 group-hover:text-cyan-900">2. Documentation + Attached Quotation PDF</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">Prints the Documentation page followed by the attached Quotation PDF.</p>
                    </div>
                </button>
            </div>

            <div class="mt-5 pt-3 border-t border-slate-100 flex justify-end">
                <button onclick="closePrintModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <script>
        const hasQuotationFile = {{ !empty($project->quotation_file) ? 'true' : 'false' }};

        function handlePrintClick() {
            if (hasQuotationFile) {
                document.getElementById('printModal').classList.remove('hidden');
            } else {
                executePrint(false);
            }
        }

        function closePrintModal() {
            const modal = document.getElementById('printModal');
            if (modal) modal.classList.add('hidden');
        }

        function executePrint(includeQuotation) {
            closePrintModal();
            const qContainer = document.getElementById('printableQuotationContainer');
            if (qContainer) {
                if (includeQuotation) {
                    qContainer.classList.remove('hidden-for-print');
                    qContainer.classList.add('show-for-print');
                } else {
                    qContainer.classList.remove('show-for-print');
                    qContainer.classList.add('hidden-for-print');
                }
            }
            setTimeout(() => {
                window.print();
            }, 200);
        }
    </script>

</body>
</html>
