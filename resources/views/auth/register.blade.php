@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-md px-6 py-16"><h1 class="text-3xl font-bold">Create your account</h1><p class="mt-2 text-slate-500">Join as a jobseeker or publish opportunities as an employer.</p><form method="POST" action="{{ route('register.store') }}" class="mt-8 grid gap-5">@csrf
<label class="grid gap-2 text-sm font-semibold">Name<input name="name" value="{{ old('name') }}" required class="rounded-lg border-slate-300 px-4 py-3">@error('name')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
<label class="grid gap-2 text-sm font-semibold">Email<input name="email" type="email" value="{{ old('email') }}" required class="rounded-lg border-slate-300 px-4 py-3">@error('email')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
<label class="grid gap-2 text-sm font-semibold">I am joining as<select name="role" class="rounded-lg border-slate-300 px-4 py-3"><option value="jobseeker">Jobseeker</option><option value="employer" @selected(old('role') === 'employer')>Employer</option></select></label>
<label class="grid gap-2 text-sm font-semibold">Password<input name="password" type="password" required class="rounded-lg border-slate-300 px-4 py-3">@error('password')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
<label class="grid gap-2 text-sm font-semibold">Confirm password<input name="password_confirmation" type="password" required class="rounded-lg border-slate-300 px-4 py-3"></label>
<button class="rounded-lg bg-brand px-5 py-3 font-bold text-white hover:bg-brand-dark">Create account</button></form></div>
@endsection
