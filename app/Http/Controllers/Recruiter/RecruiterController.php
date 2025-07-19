<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    public function index() {
        $list = User::with('profileCompany', 'profileCompany.industryType')
            ->where('type', 'recruiter')->get();

        return view('pages.recruiters.index', ['recruiters' => $list]);
    }

    public function detail($id) {
        $data = User::with('profileCompany', 'profileCompany.province', 'profileCompany.city')
            ->where('type', 'recruiter')->where('id', $id)->first();

        return view('pages.recruiters.detail', ['detail' => $data]);
    }
}
