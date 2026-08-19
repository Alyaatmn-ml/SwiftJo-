<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware(AdminMiddleware::class)->only(['create', 'store', 'edit', 'update', 'destroy', 'adminCandidates']);
    }

    public function index(Request $request)
    {
        $query = Job::query()->where('deadline', '>=', now()->toDateString());

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('required_skills', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $jobs = $query->latest()->paginate(6)->appends($request->query());

        $recommendedJobs = collect();
        $user = auth()->user();

        if ($user && method_exists($user, 'isCandidate') && $user->isCandidate()) {
            $userSkills = array_filter(array_map('trim', explode(',', strtolower($user->skills ?? ''))));
            $userTitleKeywords = array_filter(array_map('trim', explode(' ', strtolower($user->job_title ?? ''))));
            $userBioKeywords = array_filter(array_map('trim', explode(' ', strtolower($user->profile_description ?? ''))));

            if (!empty($userSkills) || !empty($userTitleKeywords) || !empty($userBioKeywords)) {
                $recommendedJobs = Job::where('deadline', '>=', now()->toDateString())->get()->filter(function ($job) use ($userSkills, $userTitleKeywords, $userBioKeywords) {
                    $jobSkills = strtolower($job->required_skills ?? '');
                    $jobTitle  = strtolower($job->title ?? '');
                    $jobDesc   = strtolower($job->description ?? '');
                    $jobCat    = strtolower($job->category ?? '');

                    foreach ($userSkills as $skill) {
                        if ($skill !== '' && (str_contains($jobSkills, $skill) || str_contains($jobTitle, $skill))) {
                            return true;
                        }
                    }

                    foreach ($userTitleKeywords as $kw) {
                        if (strlen($kw) > 2 && (str_contains($jobTitle, $kw) || str_contains($jobCat, $kw))) {
                            return true;
                        }
                    }

                    foreach ($userBioKeywords as $kw) {
                        if (strlen($kw) > 3 && (str_contains($jobTitle, $kw) || str_contains($jobSkills, $kw))) {
                            return true;
                        }
                    }

                    return false;
                })->take(3);
            }
        }

        return view('jobs.index', compact('jobs', 'recommendedJobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'required_skills' => 'required|string',
            'category'        => 'required|string',
            'location'        => 'required|string',
            'work_type'       => 'required|in:Remote,On-site,Hybrid',
            'salary'          => 'required|numeric',
            'deadline'        => 'required|date|after_or_equal:today',
        ]);

        Job::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job published successfully.');
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'required_skills' => 'required|string',
            'category'        => 'required|string',
            'location'        => 'required|string',
            'work_type'       => 'required|in:Remote,On-site,Hybrid',
            'salary'          => 'required|numeric',
            'deadline'        => 'required|date',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully.');
    }

    public function adminCandidates()
    {
        $candidates = User::where('role', 'candidate')->latest()->get();
        return view('admin.candidates', compact('candidates'));
    }
}