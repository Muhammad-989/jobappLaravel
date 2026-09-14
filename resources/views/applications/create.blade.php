@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-2xl px-6 py-12"><a href="{{ route('jobs.show', $job) }}" class="text-sm font-semibold text-brand">← Back to job</a><h1 class="mt-8 text-3xl font-bold">Apply for {{ $job->title }}</h1><p class="mt-2 text-slate-500">{{ $job->company->name }} · {{ $job->location }}</p><form method="POST" action="{{ route('applications.store', $job) }}" enctype="multipart/form-data" class="mt-8 grid gap-5 rounded-xl border border-slate-200 bg-white p-6">@csrf
<label class="grid gap-2 text-sm font-semibold">Cover letter<textarea name="cover_letter" rows="8" required class="rounded-lg border-slate-300 px-4 py-3">{{ old('cover_letter') }}</textarea>@error('cover_letter')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
<label class="grid gap-2 text-sm font-semibold">Resume <span class="font-normal text-slate-500">(PDF, DOC, or DOCX; optional)</span><input name="resume" type="file" class="rounded-lg border border-slate-300 px-4 py-3">@error('resume')<span class="text-sm text-red-700">{{ $message }}</span>@enderror</label>
@error('application')<p class="text-sm text-red-700">{{ $message }}</p>@enderror<button class="rounded-lg bg-brand px-5 py-3 font-bold text-white hover:bg-brand-dark">Submit application</button></form></div>
@endsection
