<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create System Admin
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Create Candidates with skills
        $candidate1 = User::create([
            'name' => 'Salma Developer',
            'email' => 'salma@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'candidate',
            'age' => 22,
            'job_title' => 'Full-Stack Developer',
            'phone_number' => '+1234567890',
            'skills' => 'PHP, Laravel, JavaScript, MySQL, Tailwind',
            'profile_description' => 'Passionate web developer building modern applications.',
        ]);

        $candidate2 = User::create([
            'name' => 'Sara Data Scientist',
            'email' => 'sara@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'candidate',
            'age' => 24,
            'job_title' => 'Data Scientist',
            'phone_number' => '+1987654321',
            'skills' => 'Python, Machine Learning, SQL, Data Science',
            'profile_description' => 'Specialized in predictive modeling and analytics.',
        ]);

        // 3. Create Job Openings
        $job1 = Job::create([
            'title' => 'Senior Laravel Engineer',
            'description' => 'We are seeking an experienced Laravel engineer to lead our backend architecture, optimize database queries, and manage API integrations.',
            'required_skills' => 'PHP, Laravel, MySQL, REST API',
            'category' => 'Programming',
            'location' => 'Remote',
            'work_type' => 'Remote',
            'salary' => 95000.00,
            'deadline' => now()->addDays(30),
        ]);

        $job2 = Job::create([
            'title' => 'Machine Learning Engineer',
            'description' => 'Build high-performance predictive models and NLP systems for customer analytics and recommendation engines.',
            'required_skills' => 'Python, Machine Learning, SQL',
            'category' => 'Data Science',
            'location' => 'New York, NY',
            'work_type' => 'Hybrid',
            'salary' => 110000.00,
            'deadline' => now()->addDays(45),
        ]);

        $job3 = Job::create([
            'title' => 'Full-Stack Web Developer',
            'description' => 'Join our dynamic startup team to craft responsive user interfaces and robust Laravel backends.',
            'required_skills' => 'PHP, Laravel, JavaScript, Tailwind, MySQL',
            'category' => 'Programming',
            'location' => 'On-site',
            'work_type' => 'On-site',
            'salary' => 85000.00,
            'deadline' => now()->addDays(20),
        ]);

        $job4 = Job::create([
            'title' => 'Frontend UI/UX Developer',
            'description' => 'Design and implement clean, user-centric interfaces with React and Tailwind CSS.',
            'required_skills' => 'React, JavaScript, Tailwind, CSS',
            'category' => 'Design & Web',
            'location' => 'Remote',
            'work_type' => 'Remote',
            'salary' => 78000.00,
            'deadline' => now()->addDays(15),
        ]);

        // 4. Create Job Applications
        JobApplication::create([
            'job_id' => $job1->id,
            'user_id' => $candidate1->id,
            'status' => 'applied',
        ]);

        JobApplication::create([
            'job_id' => $job3->id,
            'user_id' => $candidate1->id,
            'status' => 'applied',
        ]);

        JobApplication::create([
            'job_id' => $job2->id,
            'user_id' => $candidate2->id,
            'status' => 'applied',
        ]);
    }
}