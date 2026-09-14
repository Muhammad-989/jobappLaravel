@extends('layouts.app')
@section('content')
<section class="bg-brand"><div class="mx-auto max-w-6xl px-6 py-16 text-white"><p class="mb-3 font-semibold text-accent">Find work that fits your life.</p><h1 class="max-w-2xl text-4xl font-bold tracking-tight sm:text-5xl">Your next opportunity starts here.</h1>
<form method="GET" class="mt-8 grid gap-3 rounded-xl bg-white p-3 text-slate-900 shadow-xl md:grid-cols-[1fr_1fr_180px_auto]">
<input name="q" value="{{ request('q') }}" placeholder="Job title or keyword" class="rounded-lg border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-accent">
<input name="location" value="{{ request('location') }}" placeholder="Location" class="rounded-lg border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-accent">
<select name="category" class="rounded-lg border-slate-200 px-4 py-3"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>@endforeach</select>
<button class="rounded-lg bg-accent px-6 py-3 font-bold text-slate-900 hover:bg-yellow-300">Search</button>
</form></div></section>
<section class="mx-auto max-w-6xl px-6 py-12"><div class="mb-6 flex items-end justify-between"><div><h2 class="text-2xl font-bold">Latest opportunities</h2><p class="mt-1 text-slate-500">{{ $jobs->total() }} jobs to explore</p></div></div>
<div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">@forelse($jobs as $job)<a href="{{ route('jobs.show', $job) }}" class="group rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-brand hover:shadow-md"><div class="flex items-start justify-between gap-3"><div class="grid h-11 w-11 place-items-center rounded-lg bg-red-50 font-bold text-brand">{{ strtoupper(substr($job->company->name, 0, 1)) }}</div><span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-800">{{ $job->employment_type }}</span></div><h3 class="mt-5 text-lg font-bold group-hover:text-brand">{{ $job->title }}</h3><p class="mt-1 font-medium text-slate-600">{{ $job->company->name }}</p><p class="mt-4 text-sm text-slate-500">{{ $job->location }} · {{ $job->category?->name ?? 'General' }}</p><p class="mt-5 text-sm text-slate-500">{{ Str::limit($job->description, 110) }}</p></a>@empty<div class="col-span-full rounded-xl border border-dashed border-slate-300 p-12 text-center text-slate-500">No jobs match your search yet.</div>@endforelse</div>
<div class="mt-8">{{ $jobs->links() }}</div></section>
@endsection
