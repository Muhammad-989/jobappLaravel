<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\StoreJobPostingRequest;
use App\Models\Application;
use App\Models\Category;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployerController extends Controller
{
    public function dashboard(): View
    {
        $company = Auth::user()->company;

        return view('employer.dashboard', [
            'company' => $company,
            'jobs' => $company?->jobPostings()->withCount('applications')->latest()->get() ?? collect(),
        ]);
    }

    public function storeCompany(StoreCompanyRequest $request): RedirectResponse
    {
        Auth::user()->company()->create($request->validated());

        return back()->with('success', 'Company profile saved.');
    }

    public function createJob(): View
    {
        abort_unless(Auth::user()->company, 403);

        return view('employer.jobs.create', ['categories' => Category::query()->orderBy('name')->get()]);
    }

    public function storeJob(StoreJobPostingRequest $request): RedirectResponse
    {
        $company = Auth::user()->company;
        abort_unless($company, 403);

        $company->jobPostings()->create([...$request->validated(), 'status' => 'published', 'published_at' => now()]);

        return redirect()->route('employer.dashboard')->with('success', 'Job published.');
    }

    public function applications(JobPosting $job): View
    {
        abort_unless($job->company_id === Auth::user()->company?->id, 403);

        return view('employer.applications.index', [
            'job' => $job,
            'applications' => $job->applications()->with('user')->latest()->get(),
        ]);
    }

    public function updateApplication(Request $request, Application $application): RedirectResponse
    {
        abort_unless($application->jobPosting->company_id === Auth::user()->company?->id, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:submitted,reviewing,interview,accepted,rejected'],
        ]);

        $application->update($validated);

        return back()->with('success', 'Application status updated.');
    }
}
