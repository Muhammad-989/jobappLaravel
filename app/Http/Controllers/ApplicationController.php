<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(JobPosting $job): View
    {
        abort_unless($job->status === 'published', 404);

        return view('applications.create', ['job' => $job]);
    }

    public function store(StoreApplicationRequest $request, JobPosting $job): RedirectResponse
    {
        abort_unless($job->status === 'published', 404);

        if (Application::whereBelongsTo(Auth::user())->whereBelongsTo($job)->exists()) {
            return back()->withErrors(['application' => 'You have already applied for this job.']);
        }

        $job->applications()->create([
            'user_id' => Auth::id(),
            'cover_letter' => $request->string('cover_letter')->toString(),
            'resume_path' => $request->hasFile('resume') ? $request->file('resume')->store('resumes') : null,
        ]);

        return redirect()->route('jobs.show', $job)->with('success', 'Your application was submitted.');
    }
}
