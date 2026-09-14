<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Workfolk' }} · Workfolk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="{{ route('jobs.index') }}" class="text-2xl font-bold tracking-tight text-brand">workfolk<span class="text-accent">.</span></a>
            <div class="flex items-center gap-4 text-sm font-semibold">
                <a href="{{ route('jobs.index') }}" class="text-slate-600 hover:text-brand">Find jobs</a>
                @auth
                    @if(auth()->user()->isEmployer())
                        <a href="{{ route('employer.dashboard') }}" class="text-slate-600 hover:text-brand">Employer dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-slate-600 hover:text-brand">Log out</button></form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-brand">Log in</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-brand px-4 py-2 text-white hover:bg-brand-dark">Create account</a>
                @endauth
            </div>
        </div>
    </nav>
    @if(session('success'))<div class="mx-auto mt-6 max-w-6xl rounded-lg bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>@endif
    <main>@yield('content')</main>
    <footer class="mt-20 border-t border-slate-200 bg-white"><div class="mx-auto max-w-6xl px-6 py-8 text-sm text-slate-500">A simple, honest job search project.</div></footer>
</body>
</html>
