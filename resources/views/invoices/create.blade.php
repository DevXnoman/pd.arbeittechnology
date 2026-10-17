<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Receipt</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0mm; /* Removes browser URL footers, page numbers, and title headers */
            }
            html, body {
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
            .letterhead-pad {
                box-shadow: none !important;
                padding: 12mm 18mm !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
            }
            /* Hide input styling in print mode so it looks like plain typed text */
            input, select, textarea {
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                outline: none !important;
                padding: 0 !important;
                appearance: none !important;
                -webkit-appearance: none !important;
                font-family: inherit !important;
                color: black !important;
            }
            .no-print-border {
                border: none !important;
                background: transparent !important;
                box-shadow: none !important;
                height: 24mm !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            #signatureImg {
                height: 24mm !important;
                max-width: 100% !important;
                object-fit: contain !important;
                vertical-align: bottom !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
        }

        .receipt-font {
            font-family: 'Times New Roman', Times, serif, sans-serif;
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
                min-height: 275mm;
                padding: 12mm 18mm;
            }
        }

        /* Screen input hints */
        .editable-input {
            border: 1px dashed #cbd5e1;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }
        .editable-input:focus, .editable-input:hover {
            border-color: #0284c7;
            background-color: #ffffff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.15);
        }
    </style>
</head>
<body class="bg-slate-100 py-8 min-h-screen text-slate-900">

    <!-- Action Bar (Hidden on Print) -->
    <div class="max-w-[210mm] mx-auto mb-4 flex flex-wrap justify-between items-center gap-2.5 px-3 no-print">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Dashboard
        </a>
        
        <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="refreshReceiptNo()" title="Generate New Receipt Number" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-amber-800 bg-amber-50 hover:bg-amber-100 border border-amber-300 shadow-sm transition cursor-pointer">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                New Receipt No
            </button>

            <button type="button" onclick="resetReceiptForm()" title="Clear typed fields" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Reset Form
            </button>

            <button type="button" onclick="handlePrint()" class="inline-flex items-center gap-1.5 px-5 py-2 rounded-lg text-xs font-semibold text-white bg-cyan-700 hover:bg-cyan-800 shadow transition cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print / Save PDF
            </button>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1 px-3 py-2 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 shadow-sm transition cursor-pointer">
                    <svg class="w-4 h-4 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-[210mm] mx-auto overflow-x-auto px-2 sm:px-0">

    <!-- Main Money Receipt Pad Container -->
    <div class="letterhead-pad receipt-font border border-slate-300 relative overflow-hidden">

        <!-- WATERMARK BACKGROUND LOGO -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.15] select-none z-0">
            <img src="{{ asset('images/logo.png') }}" alt="Watermark" class="w-[480px] object-contain">
        </div>

        <div class="relative z-10">

            <!-- HEADER LOGO & CONTACT INFO -->
            <div class="flex justify-between items-start border-b border-slate-400 pb-3 mb-6">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Arbeit Technology Logo" class="h-20 w-auto object-contain">
                </div>
                <div class="text-right text-[12px] text-slate-800 space-y-0.5 leading-snug">
                    <p><strong class="font-bold">Phone:</strong> +880 1707-387608</p>
                    <p><strong class="font-bold">Email:</strong> contact@arbeittechnology.com</p>
                    <p><strong class="font-bold">Website:</strong> arbeittechnology.com</p>
                    <p><strong class="font-bold">Address:</strong> H-26, Road-3, Block-C, Banasree, Dhaka-1219</p>
                </div>
            </div>

            <!-- TITLE -->
            <div class="mb-6 pt-1">
                <h1 class="text-center font-bold text-2xl text-black tracking-wide">Money Receipt</h1>
            </div>

            <!-- RECEIPT NO & DATE ROW -->
            <div class="mb-6 text-sm flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-black">Receipt No:</span>
                    <input type="text" id="receiptNo" value="{{ $receiptNo }}" class="editable-input px-2 py-0.5 rounded text-sm w-44 font-semibold text-slate-900" placeholder="AT-2026-446">
                </div>
                <div class="flex items-center gap-1">
                    <span class="font-bold text-black">Date:</span>
                    <input type="text" id="receiptDate" value="{{ $currentDate }}" class="editable-input px-2 py-0.5 rounded text-sm w-36 text-slate-900 font-medium" placeholder="22 June 2026">
                </div>
            </div>

            <!-- RECEIVED FROM SECTION -->
            <div class="space-y-4 mb-6">
                <div>
                    <span class="font-bold text-black text-sm border-b border-black pb-0.5 inline-block">Received From:</span>
                </div>

                <div class="pl-2 space-y-3.5 text-sm">
                    <div class="flex items-center">
                        <span class="w-28 font-bold text-black">Client</span>
                        <span class="mr-2 font-bold text-black">:</span>
                        <input type="text" id="clientName" value="Skyline IT" class="editable-input px-2.5 py-1 rounded text-sm flex-1 font-medium text-slate-900" placeholder="Enter Client / Company Name">
                    </div>

                    <div class="flex items-center">
                        <span class="w-28 font-bold text-black">Contact</span>
                        <span class="mr-2 font-bold text-black">:</span>
                        <input type="text" id="clientContact" value="+8801753454568" class="editable-input px-2.5 py-1 rounded text-sm flex-1 font-medium text-slate-900" placeholder="Enter Contact Phone Number">
                    </div>

                    <div class="flex items-start">
                        <span class="w-28 font-bold text-black pt-1">Address</span>
                        <span class="mr-2 font-bold text-black pt-1">:</span>
                        <textarea id="clientAddress" rows="2" class="editable-input px-2.5 py-1 rounded text-sm flex-1 font-medium text-slate-900 resize-none" placeholder="Enter Client Address">848, Begum Rokeya Avenue, Dhaka, Bangladesh</textarea>
                    </div>
                </div>
            </div>

            <!-- PURPOSE SECTION -->
            <div class="mb-6 text-sm flex items-center">
                <span class="w-28 font-bold text-black">Purpose:</span>
                <input type="text" id="purpose" value="LMS Website Development" class="editable-input px-2.5 py-1 rounded text-sm flex-1 font-medium text-slate-900" placeholder="Enter Payment Purpose (e.g. Website Development)">
            </div>

            <!-- FINANCIAL DETAILS SECTION -->
            <div class="space-y-3.5 mb-16 text-sm">
                <div class="flex items-center">
                    <span class="w-44 font-bold text-black">Amount Received:</span>
                    <input type="text" id="amountReceived" value="25,000 BDT" class="editable-input px-2.5 py-1 rounded text-sm w-64 font-bold text-slate-900" placeholder="e.g. 25,000 BDT">
                </div>

                <div class="flex items-center">
                    <span class="w-44 font-bold text-black">Payment Method:</span>
                    <input type="text" id="paymentMethod" value="bKash" class="editable-input px-2.5 py-1 rounded text-sm w-64 font-medium text-slate-900" placeholder="e.g. bKash / Bank Transfer / Cash">
                </div>

                <div class="flex items-center">
                    <span class="w-44 font-bold text-black">Due Balance Amount:</span>
                    <input type="text" id="dueBalance" value="30,000 BDT" class="editable-input px-2.5 py-1 rounded text-sm w-64 font-medium text-slate-900" placeholder="e.g. 30,000 BDT">
                </div>
            </div>

            <!-- FOOTER SIGNATURE SECTION -->
            <div class="mt-8 pt-2 flex justify-between items-end text-xs text-slate-800">
                <div class="w-1/2">
                    <!-- Blank left space matching screenshot -->
                </div>
                
                <div class="w-72 text-left space-y-0.5">
                    <p class="font-bold text-black mb-0.5 text-xs">Authorized Signature:</p>
                    
                    <!-- DIGITAL SIGNATURE DISPLAY & UPLOAD CONTAINER -->
                    <div class="h-24 w-full flex items-end justify-center relative group cursor-pointer border border-dashed border-slate-300 hover:border-cyan-600 bg-slate-50/40 hover:bg-slate-50 rounded transition-all no-print-border" onclick="document.getElementById('signatureFileInput').click()" title="Click to Change Digital Signature Image">
                        
                        <input type="file" id="signatureFileInput" accept="image/*" class="hidden" onchange="loadSignatureImage(event)">
                        
                        <!-- Default or Uploaded Signature Image -->
                        <img id="signatureImg" src="{{ asset('images/signature.png') }}" alt="Digital Signature" class="h-24 max-w-[320px] object-contain z-10 block">

                        <!-- Hover Controls (Shown on screen) -->
                        <div id="sigControlButtons" class="absolute top-1 right-1 flex items-center gap-1.5 no-print z-20">
                            <button type="button" onclick="event.stopPropagation(); document.getElementById('signatureFileInput').click()" class="px-2 py-0.5 rounded text-[11px] font-sans font-semibold bg-white text-cyan-800 border border-cyan-300 shadow-2xs hover:bg-cyan-50 cursor-pointer">
                                Change
                            </button>
                            <button type="button" onclick="resetSignatureToDefault(event)" class="px-2 py-0.5 rounded text-[11px] font-sans font-semibold bg-white text-slate-700 border border-slate-300 shadow-2xs hover:bg-slate-100 cursor-pointer" title="Reset to default signature">
                                Reset Default
                            </button>
                        </div>
                    </div>

                    <!-- SIGNATURE LINE & DETAILS -->
                    <div class="border-t border-slate-500 pt-1 space-y-0.5">
                        <div class="flex items-center gap-1">
                            <span class="font-bold text-black text-xs">Name:</span>
                            <input type="text" id="signatoryName" value="MD. Ali Akbar" class="editable-input px-1.5 py-0.5 rounded text-xs flex-1 font-bold text-black">
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="font-bold text-black text-xs">Designation:</span>
                            <input type="text" id="signatoryDesignation" value="Managing Director" class="editable-input px-1.5 py-0.5 rounded text-xs flex-1 font-medium text-black">
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="font-bold text-black text-xs">Date:</span>
                            <input type="text" id="signatoryDate" value="{{ $currentDate }}" class="editable-input px-1.5 py-0.5 rounded text-xs flex-1 font-medium text-black">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div> <!-- /overflow-x-auto wrapper -->

    <!-- JS Form Control Scripts -->
    <script>
        // Synchronize top receipt date with signatory date automatically
        const receiptDateInput = document.getElementById('receiptDate');
        const signatoryDateInput = document.getElementById('signatoryDate');

        receiptDateInput.addEventListener('input', function() {
            signatoryDateInput.value = this.value;
        });

        function handlePrint() {
            const originalTitle = document.title;
            document.title = ' ';
            window.print();
            setTimeout(() => {
                document.title = originalTitle;
            }, 500);
        }

        function refreshReceiptNo() {
            const year = new Date().getFullYear();
            const rand = Math.floor(100 + Math.random() * 900);
            document.getElementById('receiptNo').value = `AT-${year}-${rand}`;
        }

        function resetReceiptForm() {
            if (confirm('Are you sure you want to clear the form?')) {
                document.getElementById('clientName').value = '';
                document.getElementById('clientContact').value = '';
                document.getElementById('clientAddress').value = '';
                document.getElementById('purpose').value = '';
                document.getElementById('amountReceived').value = '';
                document.getElementById('paymentMethod').value = '';
                document.getElementById('dueBalance').value = '';
            }
        }

        const defaultSignatureUrl = "{{ asset('images/signature.png') }}";

        // Digital Signature Image Upload & Persistence
        function loadSignatureImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const dataUrl = e.target.result;
                    setSignatureImage(dataUrl);
                    localStorage.setItem('custom_user_signature_v2', dataUrl);
                };
                reader.readAsDataURL(file);
            }
        }

        function setSignatureImage(dataUrl) {
            const img = document.getElementById('signatureImg');
            if (img) {
                img.src = dataUrl;
                img.classList.remove('hidden');
            }
        }

        function resetSignatureToDefault(event) {
            if (event) event.stopPropagation();
            const img = document.getElementById('signatureImg');
            const fileInput = document.getElementById('signatureFileInput');
            if (img) {
                img.src = defaultSignatureUrl;
                if (fileInput) fileInput.value = '';
                localStorage.removeItem('saved_digital_signature');
                localStorage.removeItem('custom_user_signature_v2');
            }
        }

        // Restore saved digital signature on page load (or fallback to default signature)
        window.addEventListener('DOMContentLoaded', () => {
            // Remove old legacy cached signature (e.g. Abdullah signature from prior tests)
            localStorage.removeItem('saved_digital_signature');
            
            const customSig = localStorage.getItem('custom_user_signature_v2');
            if (customSig) {
                setSignatureImage(customSig);
            } else {
                setSignatureImage(defaultSignatureUrl);
            }
        });
    </script>

</body>
</html>
