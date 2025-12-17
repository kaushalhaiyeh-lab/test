<?php

namespace App\Http\Controllers;

use App\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('jobs.index', compact('jobs'));
    }

    public function show(int $id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.show', compact('job'));
    }
}
