<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Services\Job\JobUsersApplyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    protected $jobUsersApplyService;

    public function __construct(JobUsersApplyService $jobUsersApplyService)
    {
        $this->jobUsersApplyService = $jobUsersApplyService;
    }

    public function index()
    {
        $applicants = $this->jobUsersApplyService->getJobUsersApply(Auth::user()->company_id ?? 1);
        return view("pages.applicants.index", compact("applicants"));
    }

    public function show($id)
    {
        $applicant = $this->jobUsersApplyService->getDetailJobUsersApply($id);
        return view("pages.applicants.detail", compact('applicant'));
    }

    public function update($id, Request $request)
    {
        $validate = [];
        $rules = [];
        $attrNames = [];

        switch ($request?->type_update) {
            case 'personal_information':
                $rules = [
                    "employee_count" => 'required|integer',
                    "province_id" => 'required|exists:indonesia_provinces,id',
                    "city_id" => 'required|exists:indonesia_cities,id',
                ];
                $attrNames = [
                    "employee_count" => 'Size',
                    "province_id" => 'Province',
                    "city_id" => 'City',
                ];
                break;

            case 'contacts_information':
                $rules = [
                    "website" => 'sometimes|string',
                    "email" => 'required|email',
                    "phone" => 'required|integer',
                ];
                break;

            default:
                # code...
                break;
        }

        $validate = Validator::make($request->all(), $rules)->setAttributeNames($attrNames);

        // $data = User::with('profileCompany', 'profileCompany.province', 'profileCompany.city')
        //     ->where('type', 'recruiter')->where('id', $id)->first();

        // $profile_company = UserProfileCompany::query()->firstWhere('id', $data->profileCompany->id)->update($validate->getData());

        if ($validate) {
            return redirect()->route('applicants.detail', ['id' => $id])->with('success', 'Successfully to updated information.');
        } else {
            return redirect()->route('applicants.detail', ['id' => $id])->with('errors', 'Failed to updated information.');
        }
    }
}
