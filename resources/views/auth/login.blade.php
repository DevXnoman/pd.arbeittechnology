<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Arbeit Technology</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;500;600;700&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#091426",
                        "surface-subtle": "#F8FAFC",
                        "border-light": "#E2E8F0",
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F8FAFC;
            color: #1b1b1d;
            font-family: 'Hanken Grotesk', sans-serif;
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-50">

<div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 p-8 shadow-lg">
    
    <!-- Header with Original Logo -->
    <div class="flex flex-col items-center text-center mb-8">
        <img alt="Logo" class="h-16 w-auto mb-4 object-contain" src="{{ asset('images/logo.png') }}"/>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight" style="font-family: 'DM Sans', sans-serif;">Lead & Project Management System</h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-rose-50 border border-rose-300 text-rose-800 text-xs font-medium space-y-1">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('login') }}" class="space-y-5" method="POST">
        @csrf

        <!-- Username / Email -->
        <div>
            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2" for="login">Username or Email</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">person</span>
                <input autocomplete="username" class="w-full pl-11 pr-4 py-2.5 text-xs text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 transition-all placeholder:text-slate-400" id="login" name="login" placeholder="Username (e.g. Admin)" required type="text" value="{{ old('login', 'Admin') }}"/>
            </div>
        </div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-2" for="password">Password</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">lock</span>
                <input autocomplete="current-password" class="w-full pl-11 pr-4 py-2.5 text-xs text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:border-cyan-600 focus:ring-2 focus:ring-cyan-600/20 transition-all placeholder:text-slate-400" id="password" name="password" placeholder="••••••••" required type="password"/>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                <input class="h-4 w-4 rounded border-slate-300 text-cyan-700 focus:ring-cyan-600/20" id="remember" name="remember" type="checkbox" checked/>
                <span>Remember Me</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-lg shadow-sm font-bold text-xs text-white transition-all cursor-pointer hover:opacity-90" style="background-color: #0e7490;" type="submit">
                <span>Login to System</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
        </div>
    </form>

    <div class="mt-6 pt-4 border-t border-slate-200 text-center text-[11px] text-slate-500">
        © {{ date('Y') }} Arbeit Technology. Confidential Internal System.
    </div>

</div>

</body>
</html>
