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

    public function top_chart(Request $request) {
        $result = [];

        if ($request->type == 'applicant') {
            $applicant = User::where('type', 'applicant')->with('profileApplicant')->limit(9)->get();
            foreach($applicant as $user) {
                array_push($result, (object) [
                    'name' => $user->profileApplicant->first_name . ' ' . $user->profileApplicant->last_name,
                    'image' => $user->profileApplicant->file_profile_image,
                    'description' => 'Level 1',
                ]);
            }
        } else if ($request->type == 'recruiter') {
            $recruiter = User::where('type', 'recruiter')->with('profileCompany')->limit(9)->get();
            foreach($recruiter as $user) {
                array_push($result, (object) [
                    'name' => $user->profileCompany->company_name,
                    'image' => $user->profileCompany->file_profile_image,
                    'description' => 'Level 1',
                ]);
            }
        } else if ($request->type == 'job') {
            $job = JobMaster::with(['user', 'user.profileCompany'])->limit(9)->get();
            foreach($job as $user) {
                array_push($result, (object) [
                    'name' => $user->position,
                    'image' => $user->image,
                    'description' => $user->user->profileCompany->company_name,
                ]);
            }
        }

        return response()->json([
            'data' => $result,
        ]);
    }
}
