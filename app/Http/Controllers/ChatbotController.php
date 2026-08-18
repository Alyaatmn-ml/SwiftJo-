<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $query = strtolower(trim($request->input('message', '')));
        
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return response()->json(['reply' => 'Please log in to talk to the AI Assistant.']);
        }

        $isCandidate = method_exists($user, 'isCandidate') ? $user->isCandidate() : ($user->role === 'candidate');
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : ($user->role === 'admin');

        // CANDIDATE BOT INTENTS
        if ($isCandidate) {
            if (str_contains($query, 'best jobs') || str_contains($query, 'match my skills')) {
                $skills = array_filter(array_map('trim', explode(',', strtolower($user->skills ?? ''))));
                if (empty($skills)) {
                    return response()->json(['reply' => 'Please update your profile skills so I can recommend matching jobs!']);
                }

                $jobs = Job::where('deadline', '>=', now()->toDateString())->get()->filter(function ($j) use ($skills) {
                    $req = strtolower($j->required_skills);
                    foreach ($skills as $s) {
                        if ($s !== '' && str_contains($req, $s)) return true;
                    }
                    return false;
                });

                if ($jobs->isEmpty()) {
                    return response()->json(['reply' => 'No matching jobs found for your skills at the moment. Check back soon!']);
                }

                $titles = $jobs->pluck('title')->implode(', ');
                return response()->json(['reply' => "Based on your skills ({$user->skills}), here are the best matching jobs: " . $titles]);
            }

            if (str_contains($query, 'skills should i learn') || str_contains($query, 'skills to learn')) {
                $allSkills = Job::pluck('required_skills')->implode(', ');
                return response()->json(['reply' => "In-demand skills currently requested by employers on this platform: " . ($allSkills ?: 'General Web Development, Python, PHP, Laravel')]);
            }
        }

        // ADMIN BOT INTENTS
        if ($isAdmin) {
            if (str_contains($query, 'how many candidates') || str_contains($query, 'registered')) {
                $count = User::where('role', 'candidate')->count();
                return response()->json(['reply' => "Total registered candidates: {$count}"]);
            }

            if (str_contains($query, 'most applications')) {
                $job = Job::withCount('applications')->orderBy('applications_count', 'desc')->first();
                if (!$job) {
                    return response()->json(['reply' => 'No jobs or applications found.']);
                }
                return response()->json(['reply' => "The job with the most applications is '{$job->title}' with {$job->applications_count} application(s)."]);
            }

            if (str_contains($query, 'list all available jobs') || str_contains($query, 'available jobs')) {
                $jobs = Job::where('deadline', '>=', now()->toDateString())->pluck('title')->implode(', ');
                return response()->json(['reply' => "Available Jobs: " . ($jobs ?: 'No active listings.')]);
            }

            if (str_contains($query, 'programming')) {
                $jobs = Job::where('category', 'like', '%programming%')
                    ->orWhere('title', 'like', '%developer%')
                    ->orWhere('title', 'like', '%programmer%')
                    ->pluck('title')->implode(', ');
                return response()->json(['reply' => "Jobs in Programming: " . ($jobs ?: 'None found.')]);
            }
        }

        return response()->json(['reply' => "I am your AI Assistant. Try asking about matching jobs, candidate stats, or required skills!"]);
    }
}