@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md px-6 py-16"><h1 class="text-3xl font-bold">Welcome back</h1><p class="mt-2 text-slate-500">Log in to apply for jobs or manage your listings.</p><form method="POST" action="{{ route('login.store') }}" class="mt-8 grid gap-5">@csrf
<label class="grid gap-2 text-sm font-semibold">Email<input name="email" type="email" value="{{ old('email') }}" required class="rounded-lg border-slate-300 px-4 py-3">@error('email')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
<label class="grid gap-2 text-sm font-semibold">Password<input name="password" type="password" required class="rounded-lg border-slate-300 px-4 py-3"></label>
<button class="rounded-lg bg-brand px-5 py-3 font-bold text-white hover:bg-brand-dark">Log in</button></form><p class="mt-6 text-sm text-slate-500">New here? <a href="{{ route('register') }}" class="font-semibold text-brand">Create an account</a></p></div>
@endsection
