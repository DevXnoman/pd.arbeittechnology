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
                margin: 12mm 15mm;
            }
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print, .no-print * {
                display: none !important;
                height: 0 !important;
                visibility: hidden !important;
            }
            input, select, textarea {
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                padding: 0 !important;
                appearance: none !important;
                -webkit-appearance: none !important;
            }
            .letterhead-pad {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 100% !important;
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
        <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition">
            <span class="material-symbols-outlined text-[18px] text-slate-500">arrow_back</span>
            Back to Project Details
        </a>
        <div class="flex flex-wrap items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-lg text-xs font-semibold text-white bg-cyan-700 hover:bg-cyan-800 shadow transition cursor-pointer">
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

    @if(isset($errors) && $errors->any())
        <div class="max-w-[210mm] mx-auto mb-4 bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg no-print text-xs">
            <strong class="font-bold">Validation Errors:</strong>
            <ul class="list-disc ml-5 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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

        <!-- FORM START -->
        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            @php
                $leadDev = $project->teams->where('role', 'Lead Developer')->first()?->team_member;
                $frontendDev = $project->teams->where('role', 'Frontend / Blade / UI')->first()?->team_member;
                $dbDev = $project->teams->where('role', 'Database & API')->first()?->team_member;

                $advFinance = $project->finances->where('milestone_name', 'Advance / Initial Payment')->first();
                $finalFinance = $project->finances->where('milestone_name', 'Final Delivery Payment')->first();

                $stackLaravel = is_array($project->stack_laravel) ? $project->stack_laravel : [];
                $stackPhp = is_array($project->stack_php) ? $project->stack_php : [];
                $stackFrontend = is_array($project->stack_frontend) ? $project->stack_frontend : [];
                $chk = is_array($project->handover_checklist) ? $project->handover_checklist : [];
            @endphp

            <!-- 1. PROJECT INFORMATION -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">1. Project Information & Status</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Project Name *</td>
                        <td class="border border-slate-300 p-1.5 w-1/4"><input type="text" name="project_name" required class="w-full focus:outline-none" value="{{ old('project_name', $project->project_name) }}"></td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Project Type</td>
                        <td class="border border-slate-300 p-1.5 w-1/4">
                            <div class="relative flex items-center w-full">
                                <input type="text" name="project_type" id="project_type_input" class="w-full focus:outline-none pr-6 bg-transparent" placeholder="Type or select..." value="{{ old('project_type', $project->project_type) }}">
                                <div class="absolute right-0 top-0 bottom-0 w-6 flex items-center justify-center pointer-events-none text-slate-700">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="4 9 12 17 20 9"></polyline>
                                    </svg>
                                </div>
                                <select onchange="if(this.value){ document.getElementById('project_type_input').value = this.value; } this.selectedIndex = 0;" class="absolute right-0 top-0 bottom-0 w-6 opacity-0 cursor-pointer" title="Select Project Type">
                                    <option value="" disabled selected></option>
                                    <option value="E-Commerce">E-Commerce</option>
                                    <option value="Portfolio">Portfolio</option>
                                    <option value="Real-Estate">Real-Estate</option>
                                    <option value="LMS">LMS</option>
                                    <option value="Visa Processing">Visa Processing</option>
                                    <option value="Management System">Management System</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Client / Company *</td>
                        <td class="border border-slate-300 p-1.5"><input type="text" name="client_name" required class="w-full focus:outline-none" value="{{ old('client_name', $project->client_name) }}"></td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Status</td>
                        <td class="border border-slate-300 p-1.5">
                            <select name="status" class="w-full focus:outline-none bg-transparent">
                                <option value="In Progress" {{ old('status', $project->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Not Started" {{ old('status', $project->status) == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                                <option value="Testing" {{ old('status', $project->status) == 'Testing' ? 'selected' : '' }}>Testing</option>
                                <option value="Completed" {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="On Hold" {{ old('status', $project->status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Start Date *</td>
                        <td class="border border-slate-300 p-1.5"><input type="date" name="start_date" required class="w-full focus:outline-none" value="{{ old('start_date', $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('Y-m-d') : '') }}"></td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Target Delivery *</td>
                        <td class="border border-slate-300 p-1.5"><input type="date" name="target_delivery_date" required class="w-full focus:outline-none" value="{{ old('target_delivery_date', $project->target_delivery_date ? \Carbon\Carbon::parse($project->target_delivery_date)->format('Y-m-d') : '') }}"></td>
                    </tr>
                    <tr class="no-print">
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Priority</td>
                        <td colspan="3" class="border border-slate-300 p-1.5">
                            <select name="priority" class="w-full focus:outline-none bg-transparent">
                                <option value="Normal" {{ old('priority', $project->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="High" {{ old('priority', $project->priority) == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Urgent" {{ old('priority', $project->priority) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 2. TEAM ALLOCATION -->
            <div>
                <div class="flex justify-between items-center bg-[#36a3ae] px-3 py-1.5 shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    <h3 class="text-white font-bold uppercase text-xs tracking-wide">2. Team Allocation & Responsibilities</h3>
                    <button type="button" onclick="addTeamRow()" class="no-print bg-white/20 hover:bg-white/30 text-white text-[11px] font-semibold px-2.5 py-0.5 rounded transition flex items-center gap-1 cursor-pointer">
                        <span class="material-symbols-outlined text-[14px]">add</span> Add Developer / Member
                    </button>
                </div>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="border border-slate-300 p-1 text-left w-1/4">Role</th>
                            <th class="border border-slate-300 p-1 text-left w-1/3">Team Member Name</th>
                            <th class="border border-slate-300 p-1 text-left">Core Responsibility</th>
                            <th class="border border-slate-300 p-1 text-center w-8 no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="teamRows">
                        @forelse($project->teams as $team)
                            <tr>
                                <td class="border border-slate-300 p-1.5 font-medium">
                                    <input type="text" name="team_roles[]" value="{{ $team->role }}" class="w-full focus:outline-none bg-transparent font-medium" placeholder="Role">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_members[]" class="w-full focus:outline-none" placeholder="Name" value="{{ $team->team_member }}">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_responsibilities[]" class="w-full focus:outline-none text-slate-600" value="{{ $team->responsibility }}" placeholder="Responsibility">
                                </td>
                                <td class="border border-slate-300 p-1.5 text-center no-print">
                                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="border border-slate-300 p-1.5 font-medium">
                                    <input type="text" name="team_roles[]" value="Project Manager" class="w-full focus:outline-none bg-transparent font-medium">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_members[]" class="w-full focus:outline-none" placeholder="Name" value="{{ $project->project_manager }}">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_responsibilities[]" class="w-full focus:outline-none text-slate-600" value="Project Oversight & Client Communication">
                                </td>
                                <td class="border border-slate-300 p-1.5 text-center no-print">
                                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-slate-300 p-1.5 font-medium">
                                    <input type="text" name="team_roles[]" value="Assigned Developer" class="w-full focus:outline-none bg-transparent font-medium">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_members[]" class="w-full focus:outline-none" placeholder="Developer Name" value="{{ $leadDev }}">
                                </td>
                                <td class="border border-slate-300 p-1.5">
                                    <input type="text" name="team_responsibilities[]" class="w-full focus:outline-none text-slate-600" value="Full Stack Development & Deployment">
                                </td>
                                <td class="border border-slate-300 p-1.5 text-center no-print">
                                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 3. PROJECT TECHNOLOGY STACK -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">3. Project Technology Stack</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/6">Frontend</td>
                        <td class="border border-slate-300 p-1.5 w-2/6">
                            <select name="stack_frontend" class="w-full focus:outline-none bg-transparent font-medium">
                                <option value="">-- Select Frontend --</option>
                                <option value="Next.js" {{ old('stack_frontend', $project->stack_frontend) == 'Next.js' ? 'selected' : '' }}>Next.js</option>
                                <option value="React.js" {{ old('stack_frontend', $project->stack_frontend) == 'React.js' ? 'selected' : '' }}>React.js</option>
                                <option value="Vue.js" {{ old('stack_frontend', $project->stack_frontend) == 'Vue.js' ? 'selected' : '' }}>Vue.js</option>
                                <option value="Blade + Tailwind" {{ old('stack_frontend', $project->stack_frontend) == 'Blade + Tailwind' ? 'selected' : '' }}>Blade + Tailwind</option>
                                <option value="WordPress Theme / Elementor" {{ old('stack_frontend', $project->stack_frontend) == 'WordPress Theme / Elementor' ? 'selected' : '' }}>WordPress Theme / Elementor</option>
                                <option value="HTML5 / CSS3 / JavaScript" {{ old('stack_frontend', $project->stack_frontend) == 'HTML5 / CSS3 / JavaScript' ? 'selected' : '' }}>HTML5 / CSS3 / JavaScript</option>
                            </select>
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/6">Backend</td>
                        <td class="border border-slate-300 p-1.5 w-2/6">
                            <select name="stack_backend" class="w-full focus:outline-none bg-transparent font-medium">
                                <option value="">-- Select Backend --</option>
                                <option value="Node.js + Express.js" {{ old('stack_backend', $project->stack_backend) == 'Node.js + Express.js' ? 'selected' : '' }}>Node.js + Express.js</option>
                                <option value="Laravel (PHP)" {{ old('stack_backend', $project->stack_backend) == 'Laravel (PHP)' ? 'selected' : '' }}>Laravel (PHP)</option>
                                <option value="WordPress CMS" {{ old('stack_backend', $project->stack_backend) == 'WordPress CMS' ? 'selected' : '' }}>WordPress CMS</option>
                                <option value="PHP (Custom)" {{ old('stack_backend', $project->stack_backend) == 'PHP (Custom)' ? 'selected' : '' }}>PHP (Custom)</option>
                                <option value="Python / Django" {{ old('stack_backend', $project->stack_backend) == 'Python / Django' ? 'selected' : '' }}>Python / Django</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold">Database</td>
                        <td colspan="3" class="border border-slate-300 p-1.5">
                            <select name="stack_database" class="w-full focus:outline-none bg-transparent font-medium">
                                <option value="">-- Select Database --</option>
                                <option value="MongoDB" {{ old('stack_database', $project->stack_database) == 'MongoDB' ? 'selected' : '' }}>MongoDB</option>
                                <option value="MySQL" {{ old('stack_database', $project->stack_database) == 'MySQL' ? 'selected' : '' }}>MySQL</option>
                                <option value="PostgreSQL" {{ old('stack_database', $project->stack_database) == 'PostgreSQL' ? 'selected' : '' }}>PostgreSQL</option>
                                <option value="SQLite" {{ old('stack_database', $project->stack_database) == 'SQLite' ? 'selected' : '' }}>SQLite</option>
                                <option value="Firebase / Firestore" {{ old('stack_database', $project->stack_database) == 'Firebase / Firestore' ? 'selected' : '' }}>Firebase / Firestore</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 4. QUOTATION & FINANCIAL RECORD -->
            <div>
                <div class="flex justify-between items-center bg-[#36a3ae] px-3 py-1.5 shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    <h3 class="text-white font-bold uppercase text-xs tracking-wide">4. Quotation & Financial Record</h3>
                    <button type="button" onclick="addMilestoneRow()" class="bg-cyan-900 hover:bg-black text-white text-[10px] font-bold px-2 py-0.5 rounded no-print cursor-pointer">
                        + Add Milestone
                    </button>
                </div>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Quotation File / Link:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4">
                            <div class="space-y-1.5 p-0.5">
                                <div class="flex items-center rounded border border-slate-300 bg-white focus-within:border-cyan-600 focus-within:ring-1 focus-within:ring-cyan-600 transition shadow-2xs">
                                    <span class="px-2 text-slate-400 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[15px]">link</span>
                                    </span>
                                    <input type="text" name="quotation_file" class="w-full py-1 pr-2 text-xs focus:outline-none bg-transparent placeholder:text-slate-400" placeholder="Paste Drive URL or Link..." value="{{ old('quotation_file', $project->quotation_file) }}">
                                </div>
                                <div class="flex items-center justify-between gap-1.5">
                                    <label class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 text-[11px] font-semibold cursor-pointer transition shadow-2xs">
                                        <span class="material-symbols-outlined text-[14px] text-rose-600">upload_file</span>
                                        <span>Upload PDF</span>
                                        <input type="file" name="quotation_file_pdf" accept=".pdf,application/pdf" class="hidden" onchange="const f = this.files[0]?.name; if(f){ document.getElementById('edit-pdf-name').innerText = f; }">
                                    </label>
                                    <span id="edit-pdf-name" class="text-[10px] text-slate-500 truncate max-w-[130px]">No file selected</span>
                                </div>
                                @if(!empty($project->quotation_file))
                                    @php
                                        $isUrl = \Illuminate\Support\Str::startsWith($project->quotation_file, ['http://', 'https://']);
                                        $fileUrl = $isUrl ? $project->quotation_file : asset($project->quotation_file);
                                    @endphp
                                    <div class="flex items-center gap-1 text-[10px] text-cyan-800 bg-cyan-50 border border-cyan-200 px-2 py-0.5 rounded font-medium truncate">
                                        <span class="material-symbols-outlined text-[13px] text-cyan-600 shrink-0">check_circle</span>
                                        <span class="shrink-0 text-slate-500">Current:</span>
                                        <a href="{{ $fileUrl }}" target="_blank" class="truncate font-semibold underline hover:text-cyan-900" title="{{ $project->quotation_file }}">
                                            {{ $isUrl ? 'Google Drive Link' : basename($project->quotation_file) }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Total Project Cost:</td>
                        <td class="border border-slate-300 p-1.5 w-1/4"><input type="text" name="total_cost" class="w-full focus:outline-none font-semibold" placeholder="e.g. 50,000 BDT / $500" value="{{ old('total_cost', $project->total_cost) }}"></td>
                    </tr>
                </table>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <thead>
                        <tr class="bg-slate-50 text-xs">
                            <th class="border border-slate-300 p-1 text-left">Payment Milestone</th>
                            <th class="border border-slate-300 p-1 text-left w-1/4">Amount</th>
                            <th class="border border-slate-300 p-1 text-left w-1/4">Date Paid</th>
                            <th class="border border-slate-300 p-1 text-center w-28">Status</th>
                            <th class="border border-slate-300 p-1 w-8 text-center no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="milestone-tbody">
                        @forelse($project->finances as $index => $finance)
                        <tr>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_names[]" class="w-full focus:outline-none font-medium" value="{{ $finance->milestone_name }}" placeholder="Milestone Name"></td>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_amounts[]" class="w-full focus:outline-none" placeholder="Amount" value="{{ $finance->amount }}"></td>
                            <td class="border border-slate-300 p-1.5"><input type="date" name="milestone_dates[]" class="w-full focus:outline-none" value="{{ old('milestone_dates.'.$index, $finance->date_paid ? \Carbon\Carbon::parse($finance->date_paid)->format('Y-m-d') : '') }}"></td>
                            <td class="border border-slate-300 p-1.5 text-center">
                                <select name="milestone_statuses[]" class="w-full focus:outline-none bg-transparent text-center font-semibold">
                                    <option value="Due" {{ $finance->status != 'Paid' ? 'selected' : '' }}>Due</option>
                                    <option value="Paid" {{ $finance->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </td>
                            <td class="border border-slate-300 p-1 text-center no-print">
                                <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_names[]" class="w-full focus:outline-none font-medium" value="Advance / Initial Payment" placeholder="Milestone Name"></td>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_amounts[]" class="w-full focus:outline-none" placeholder="Amount" value="{{ old('adv_amount') }}"></td>
                            <td class="border border-slate-300 p-1.5"><input type="date" name="milestone_dates[]" class="w-full focus:outline-none" value="{{ old('adv_date') }}"></td>
                            <td class="border border-slate-300 p-1.5 text-center">
                                <select name="milestone_statuses[]" class="w-full focus:outline-none bg-transparent text-center font-semibold">
                                    <option value="Due" {{ old('adv_status') != 'Paid' ? 'selected' : '' }}>Due</option>
                                    <option value="Paid" {{ old('adv_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </td>
                            <td class="border border-slate-300 p-1 text-center no-print">
                                <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_names[]" class="w-full focus:outline-none font-medium" value="Final Delivery Payment" placeholder="Milestone Name"></td>
                            <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_amounts[]" class="w-full focus:outline-none" placeholder="Amount" value="{{ old('final_amount') }}"></td>
                            <td class="border border-slate-300 p-1.5"><input type="date" name="milestone_dates[]" class="w-full focus:outline-none" value="{{ old('final_date') }}"></td>
                            <td class="border border-slate-300 p-1.5 text-center">
                                <select name="milestone_statuses[]" class="w-full focus:outline-none bg-transparent text-center font-semibold">
                                    <option value="Due" {{ old('final_status') != 'Paid' ? 'selected' : '' }}>Due</option>
                                    <option value="Paid" {{ old('final_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </td>
                            <td class="border border-slate-300 p-1 text-center no-print">
                                <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 5. REVISION & BUG TRACKING -->
            <div>
                <div class="flex justify-between items-center bg-slate-200 px-2 py-1">
                    <h3 class="text-slate-800 font-bold uppercase text-[11px]">5. Revision & Bug Tracking Log</h3>
                    <button type="button" onclick="addRevisionRow()" class="bg-slate-700 hover:bg-slate-800 text-white text-[10px] font-bold px-2 py-0.5 rounded no-print cursor-pointer">
                        + Add Revision Row
                    </button>
                </div>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="border border-slate-300 p-1 w-12 text-center">No.</th>
                            <th class="border border-slate-300 p-1 w-28">Date Requested</th>
                            <th class="border border-slate-300 p-1 text-left">Revision / Bug Description</th>
                            <th class="border border-slate-300 p-1 w-24 text-center">Status</th>
                            <th class="border border-slate-300 p-1 w-8 text-center no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="revision-tbody">
                        @php
                            $maxRevRows = max(3, $project->revisions->count());
                        @endphp
                        @for($i=1; $i<=$maxRevRows; $i++)
                        @php
                            $rev = $project->revisions->get($i - 1);
                        @endphp
                        <tr>
                            <td class="border border-slate-300 p-1 text-center font-bold rev-no">0{{$i}}</td>
                            <td class="border border-slate-300 p-1"><input type="date" name="rev_date_{{$i}}" class="w-full focus:outline-none" value="{{ old('rev_date_'.$i, $rev?->request_date ? \Carbon\Carbon::parse($rev->request_date)->format('Y-m-d') : '') }}"></td>
                            <td class="border border-slate-300 p-1"><input type="text" name="rev_desc_{{$i}}" class="w-full focus:outline-none" placeholder="Details" value="{{ old('rev_desc_'.$i, $rev?->description) }}"></td>
                            <td class="border border-slate-300 p-1 text-center"><label class="cursor-pointer"><input type="checkbox" name="rev_status_{{$i}}" value="Done" {{ old('rev_status_'.$i, $rev?->status) == 'Done' ? 'checked' : '' }}> Done</label></td>
                            <td class="border border-slate-300 p-1 text-center no-print">
                                <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- 6. CHANGE REQUEST & EXTRA WORK -->
            <div>
                <div class="flex justify-between items-center bg-slate-200 px-2 py-1">
                    <h3 class="text-slate-800 font-bold uppercase text-[11px]">6. Change Request & Extra Work (Scope Creep)</h3>
                    <button type="button" onclick="addExtraScopeRow()" class="bg-cyan-700 hover:bg-cyan-800 text-white text-[10px] font-bold px-2 py-0.5 rounded no-print cursor-pointer">
                        + Add Extra Scope Row
                    </button>
                </div>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="border border-slate-300 p-1 w-28">Date</th>
                            <th class="border border-slate-300 p-1 text-left">Extra Feature / Scope Change</th>
                            <th class="border border-slate-300 p-1 w-24">Extra Cost</th>
                            <th class="border border-slate-300 p-1 w-24 text-center">Approved?</th>
                            <th class="border border-slate-300 p-1 w-8 text-center no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="scope-tbody">
                        @php
                            $maxScopeRows = max(3, $project->changeRequests->count());
                        @endphp
                        @for($i=1; $i<=$maxScopeRows; $i++)
                        @php
                            $extra = $project->changeRequests->get($i - 1);
                        @endphp
                        <tr>
                            <td class="border border-slate-300 p-1"><input type="date" name="extra_date_{{$i}}" class="w-full focus:outline-none" value="{{ old('extra_date_'.$i, $extra?->request_date ? \Carbon\Carbon::parse($extra->request_date)->format('Y-m-d') : '') }}"></td>
                            <td class="border border-slate-300 p-1"><input type="text" name="extra_desc_{{$i}}" class="w-full focus:outline-none" placeholder="Feature description" value="{{ old('extra_desc_'.$i, $extra?->feature_description) }}"></td>
                            <td class="border border-slate-300 p-1"><input type="text" name="extra_cost_{{$i}}" class="w-full focus:outline-none" placeholder="Amount" value="{{ old('extra_cost_'.$i, $extra?->extra_cost) }}"></td>
                            <td class="border border-slate-300 p-1 text-center"><label class="cursor-pointer"><input type="checkbox" name="extra_app_{{$i}}" value="Yes" {{ old('extra_app_'.$i, $extra?->is_approved) == 'Yes' ? 'checked' : '' }}> Yes</label></td>
                            <td class="border border-slate-300 p-1 text-center no-print">
                                <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- 7. SERVER, DOMAIN & CREDENTIAL INFRASTRUCTURE -->
            <div>
                <div class="flex justify-between items-center bg-[#36a3ae] px-3 py-1.5 shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                    <h3 class="text-white font-bold uppercase text-xs tracking-wide">7. Server, Domain & Access Credentials</h3>
                    <button type="button" onclick="addCredentialRow()" class="bg-cyan-900 hover:bg-black text-white text-[10px] font-bold px-2 py-0.5 rounded no-print cursor-pointer">
                        + Add Credential Row
                    </button>
                </div>
                <table class="w-full border-collapse border border-slate-300 mt-0.5 text-xs">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain URL:</td>
                        <td class="border border-slate-300 p-1.5 w-4/5" colspan="3">
                            <input type="text" name="domain_url" class="w-full focus:outline-none font-medium" placeholder="https://clientdomain.com" value="{{ old('domain_url', $project->infrastructure?->domain_url) }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain Provider:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <input type="text" name="domain_provider" class="w-full focus:outline-none" placeholder="e.g. Namecheap / GoDaddy" value="{{ old('domain_provider', $project->infrastructure?->domain_provider) }}">
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Domain Access:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <div class="flex gap-2">
                                <input type="text" name="domain_user" class="w-1/2 focus:outline-none border-r border-slate-200 pr-1 text-xs" placeholder="Username / Email" value="{{ old('domain_user', $project->infrastructure?->domain_user) }}">
                                <input type="text" name="domain_pass" class="w-1/2 focus:outline-none text-xs" placeholder="Password" value="{{ old('domain_pass', $project->infrastructure?->domain_pass) }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Hosting Provider:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <input type="text" name="hosting_provider" class="w-full focus:outline-none" placeholder="e.g. DigitalOcean / AWS / cPanel" value="{{ old('hosting_provider', $project->infrastructure?->hosting_provider) }}">
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Hosting Access:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <div class="flex gap-2">
                                <input type="text" name="hosting_user" class="w-1/2 focus:outline-none border-r border-slate-200 pr-1 text-xs" placeholder="Username / Email" value="{{ old('hosting_user', $project->infrastructure?->hosting_user) }}">
                                <input type="text" name="hosting_pass" class="w-1/2 focus:outline-none text-xs" placeholder="Password" value="{{ old('hosting_pass', $project->infrastructure?->hosting_pass) }}">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Server IP Address:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <input type="text" name="server_ip" class="w-full focus:outline-none" placeholder="e.g. 192.168.1.1" value="{{ old('server_ip', $project->infrastructure?->server_ip) }}">
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/5">Panel / Access URL:</td>
                        <td class="border border-slate-300 p-1.5 w-3/10">
                            <input type="text" name="panel_url" class="w-full focus:outline-none" placeholder="e.g. https://server.com:2083" value="{{ old('panel_url', $project->infrastructure?->panel_url) }}">
                        </td>
                    </tr>
                </table>

                @php
                    $hasExtraCreds = !empty($project->infrastructure?->extra_credentials) && is_array($project->infrastructure->extra_credentials) && count($project->infrastructure->extra_credentials) > 0;
                @endphp
                <table id="credential-table" class="w-full border-collapse border border-slate-300 mt-1 text-xs {{ $hasExtraCreds ? '' : 'hidden' }}">
                    <thead>
                        <tr class="bg-slate-50 text-xs">
                            <th class="border border-slate-300 p-1 text-left w-1/4">Access / Credential Title</th>
                            <th class="border border-slate-300 p-1 text-left w-1/4">Username / Email</th>
                            <th class="border border-slate-300 p-1 text-left w-1/4">Password / Secret Key</th>
                            <th class="border border-slate-300 p-1 text-left">Notes / Details</th>
                            <th class="border border-slate-300 p-1 w-8 text-center no-print"></th>
                        </tr>
                    </thead>
                    <tbody id="credential-tbody">
                        @if($hasExtraCreds)
                            @foreach($project->infrastructure->extra_credentials as $cred)
                                <tr>
                                    <td class="border border-slate-300 p-1.5"><input type="text" name="cred_titles[]" class="w-full focus:outline-none font-medium" placeholder="Title (e.g. Database / SSH / API)" value="{{ $cred['title'] ?? '' }}"></td>
                                    <td class="border border-slate-300 p-1.5"><input type="text" name="cred_usernames[]" class="w-full focus:outline-none" placeholder="Username or Email" value="{{ $cred['username'] ?? '' }}"></td>
                                    <td class="border border-slate-300 p-1.5"><input type="text" name="cred_passwords[]" class="w-full focus:outline-none" placeholder="Password or Secret" value="{{ $cred['password'] ?? '' }}"></td>
                                    <td class="border border-slate-300 p-1.5"><input type="text" name="cred_notes[]" class="w-full focus:outline-none text-slate-600" placeholder="Notes (Port, DB Name, Link, etc.)" value="{{ $cred['notes'] ?? '' }}"></td>
                                    <td class="border border-slate-300 p-1 text-center no-print">
                                        <button type="button" onclick="removeCredentialRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- 8. POST-DELIVERY SUPPORT & MAINTENANCE -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">8. Post-Delivery Support & Maintenance</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Free Support Period</td>
                        <td class="border border-slate-300 p-1.5 w-1/4">
                            <select name="support_period" class="w-full focus:outline-none bg-transparent">
                                <option value="3 Months" {{ old('support_period', $project->support_period) == '3 Months' ? 'selected' : '' }}>3 Months</option>
                                <option value="6 Months" {{ old('support_period', $project->support_period) == '6 Months' ? 'selected' : '' }}>6 Months</option>
                                <option value="1 Year" {{ old('support_period', $project->support_period) == '1 Year' ? 'selected' : '' }}>1 Year</option>
                            </select>
                        </td>
                        <td class="border border-slate-300 p-1.5 bg-slate-50 font-semibold w-1/4">Support Expiry Date</td>
                        <td class="border border-slate-300 p-1.5 w-1/4"><input type="date" name="support_expiry" class="w-full focus:outline-none" value="{{ old('support_expiry', $project->support_expiry ? \Carbon\Carbon::parse($project->support_expiry)->format('Y-m-d') : '') }}"></td>
                    </tr>
                </table>
            </div>

            <!-- 9. FINAL HANDOVER CHECKLIST -->
            <div>
                <h3 class="bg-[#36a3ae] text-white font-bold px-3 py-1.5 uppercase text-xs tracking-wide shadow-sm" style="background-color: #36a3ae; -webkit-print-color-adjust: exact; print-color-adjust: exact;">9. Final Handover Checklist</h3>
                <table class="w-full border-collapse border border-slate-300 mt-0.5">
                    <tr class="bg-slate-50">
                        <th class="border border-slate-300 p-1 text-left">Handover Task</th>
                        <th class="border border-slate-300 p-1 w-24 text-center">Status</th>
                    </tr>
                    <tr><td class="border border-slate-300 p-1">1. Production Deployment & Env Optimized</td><td class="border border-slate-300 p-1 text-center"><input type="checkbox" name="chk_1" value="1" {{ old('chk_1', !empty($chk['chk_1'])) ? 'checked' : '' }}></td></tr>
                    <tr><td class="border border-slate-300 p-1">2. Database Migration & Seeders Executed</td><td class="border border-slate-300 p-1 text-center"><input type="checkbox" name="chk_2" value="1" {{ old('chk_2', !empty($chk['chk_2'])) ? 'checked' : '' }}></td></tr>
                    <tr><td class="border border-slate-300 p-1">3. Final QA & Client Approval Received</td><td class="border border-slate-300 p-1 text-center"><input type="checkbox" name="chk_3" value="1" {{ old('chk_3', !empty($chk['chk_3'])) ? 'checked' : '' }}></td></tr>
                    <tr><td class="border border-slate-300 p-1">4. Source Code & Admin Access Transferred</td><td class="border border-slate-300 p-1 text-center"><input type="checkbox" name="chk_4" value="1" {{ old('chk_4', !empty($chk['chk_4'])) ? 'checked' : '' }}></td></tr>
                </table>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="text-center pt-2 no-print flex justify-center gap-4">
                <button type="submit" class="text-white px-8 py-2.5 rounded-lg font-bold shadow transition cursor-pointer hover:opacity-90" style="background-color: #0e7490;">
                    Update Project Documentation
                </button>
            </div>

        </form>

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

    <script>
        function addCredentialRow(title = '', username = '', password = '', notes = '') {
            const table = document.getElementById('credential-table');
            if (table) table.classList.remove('hidden');

            const tbody = document.getElementById('credential-tbody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border border-slate-300 p-1.5"><input type="text" name="cred_titles[]" class="w-full focus:outline-none font-medium" placeholder="Title (e.g. Database / SSH / API)" value="${title}"></td>
                <td class="border border-slate-300 p-1.5"><input type="text" name="cred_usernames[]" class="w-full focus:outline-none" placeholder="Username or Email" value="${username}"></td>
                <td class="border border-slate-300 p-1.5"><input type="text" name="cred_passwords[]" class="w-full focus:outline-none" placeholder="Password or Secret" value="${password}"></td>
                <td class="border border-slate-300 p-1.5"><input type="text" name="cred_notes[]" class="w-full focus:outline-none text-slate-600" placeholder="Notes (Port, DB Name, Link, etc.)" value="${notes}"></td>
                <td class="border border-slate-300 p-1 text-center no-print">
                    <button type="button" onclick="removeCredentialRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        function removeCredentialRow(btn) {
            const tr = btn.closest('tr');
            const tbody = document.getElementById('credential-tbody');
            tr.remove();
            if (tbody.children.length === 0) {
                const table = document.getElementById('credential-table');
                if (table) table.classList.add('hidden');
            }
        }

        let milestoneCount = {{ max(2, $project->finances->count()) }};
        function addMilestoneRow() {
            milestoneCount++;
            const tbody = document.getElementById('milestone-tbody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_names[]" class="w-full focus:outline-none font-medium" value="Milestone ${milestoneCount}" placeholder="Milestone Name"></td>
                <td class="border border-slate-300 p-1.5"><input type="text" name="milestone_amounts[]" class="w-full focus:outline-none" placeholder="Amount"></td>
                <td class="border border-slate-300 p-1.5"><input type="date" name="milestone_dates[]" class="w-full focus:outline-none"></td>
                <td class="border border-slate-300 p-1.5 text-center">
                    <select name="milestone_statuses[]" class="w-full focus:outline-none bg-transparent text-center font-semibold">
                        <option value="Due" selected>Due</option>
                        <option value="Paid">Paid</option>
                    </select>
                </td>
                <td class="border border-slate-300 p-1 text-center no-print">
                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        let teamDevCount = {{ max(1, $project->teams->count()) }};
        function addTeamRow() {
            teamDevCount++;
            const tbody = document.getElementById('teamRows');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border border-slate-300 p-1.5 font-medium">
                    <input type="text" name="team_roles[]" value="Developer ${teamDevCount}" class="w-full focus:outline-none bg-transparent font-medium" placeholder="Role (e.g. Developer ${teamDevCount})">
                </td>
                <td class="border border-slate-300 p-1.5">
                    <input type="text" name="team_members[]" class="w-full focus:outline-none" placeholder="Developer ${teamDevCount} Name">
                </td>
                <td class="border border-slate-300 p-1.5">
                    <input type="text" name="team_responsibilities[]" class="w-full focus:outline-none text-slate-600" value="Feature Development & Code Review" placeholder="Responsibility">
                </td>
                <td class="border border-slate-300 p-1.5 text-center no-print">
                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        let revCount = {{ max(3, $project->revisions->count()) }};
        function addRevisionRow() {
            revCount++;
            const tbody = document.getElementById('revision-tbody');
            const tr = document.createElement('tr');
            const numFormatted = revCount < 10 ? '0' + revCount : revCount;
            tr.innerHTML = `
                <td class="border border-slate-300 p-1 text-center font-bold rev-no">${numFormatted}</td>
                <td class="border border-slate-300 p-1"><input type="date" name="rev_date_${revCount}" class="w-full focus:outline-none"></td>
                <td class="border border-slate-300 p-1"><input type="text" name="rev_desc_${revCount}" class="w-full focus:outline-none" placeholder="Details"></td>
                <td class="border border-slate-300 p-1 text-center"><label class="cursor-pointer"><input type="checkbox" name="rev_status_${revCount}" value="Done"> Done</label></td>
                <td class="border border-slate-300 p-1 text-center no-print">
                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        let scopeCount = {{ max(3, $project->changeRequests->count()) }};
        function addExtraScopeRow() {
            scopeCount++;
            const tbody = document.getElementById('scope-tbody');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="border border-slate-300 p-1"><input type="date" name="extra_date_${scopeCount}" class="w-full focus:outline-none"></td>
                <td class="border border-slate-300 p-1"><input type="text" name="extra_desc_${scopeCount}" class="w-full focus:outline-none" placeholder="Feature description"></td>
                <td class="border border-slate-300 p-1"><input type="text" name="extra_cost_${scopeCount}" class="w-full focus:outline-none" placeholder="Amount"></td>
                <td class="border border-slate-300 p-1 text-center"><label class="cursor-pointer"><input type="checkbox" name="extra_app_${scopeCount}" value="Yes"> Yes</label></td>
                <td class="border border-slate-300 p-1 text-center no-print">
                    <button type="button" onclick="removeRow(this)" class="text-rose-600 font-bold hover:text-rose-800 text-xs cursor-pointer">✕</button>
                </td>
            `;
            tbody.appendChild(tr);
        }

        function removeRow(btn) {
            const tr = btn.closest('tr');
            if (tr) tr.remove();
        }
    </script>

</body>
</html>
