<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Job $job)
    {
        $user = auth()->user();

        $existing = JobApplication::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            if ($existing->status === 'cancelled') {
                $existing->update(['status' => 'applied']);
                return back()->with('success', 'Application submitted successfully.');
            }
            return back()->with('error', 'You have already applied for this job.');
        }

        JobApplication::create([
            'job_id'  => $job->id,
            'user_id' => $user->id,
            'status'  => 'applied',
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function destroy(Job $job)
    {
        $user = auth()->user();

        $application = JobApplication::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $application->update(['status' => 'cancelled']);

        return back()->with('success', 'Application cancelled successfully.');
    }

    public function index()
    {
        $user = auth()->user();

        if (!method_exists($user, 'isAdmin') || !$user->isAdmin()) {
            abort(403, 'Admin access required.');
        }

        $applications = JobApplication::with(['job', 'user'])
            ->where('status', 'applied')
            ->latest()
            ->get();

        return view('admin.applications', compact('applications'));
    }
}