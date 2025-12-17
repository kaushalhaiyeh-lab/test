<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Job;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing', [
            'services' => Service::latest()->take(3)->get(),
            'jobs' => Job::latest()->take(5)->get(),
        ]);
    }
}
