<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JobMaster;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $applicant = User::where('type', 'applicant')->count();
        $recruiter = User::where('type', 'recruiter')->count();
        $job = JobMaster::count();
        $job_active = JobMaster::where('status', 'active')->count();

        return view('pages.dashboard.index', [
            'applicant' => $applicant,
            'recruiter' => $recruiter,
            'job' => $job,
            'job_active' => $job_active,
        ]);
    }
}
