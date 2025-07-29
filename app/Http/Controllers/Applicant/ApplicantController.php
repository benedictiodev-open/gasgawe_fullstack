<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Services\Job\JobUsersApplyService;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    protected $jobUsersApplyService;

    public function __construct(JobUsersApplyService $jobUsersApplyService)
    {
        $this->jobUsersApplyService = $jobUsersApplyService;
    }

    public function index(Request $request)
    {
        $applicants = $this->jobUsersApplyService->index($request->query());
        return view("pages.applicants.index", ['applicants' => $applicants]);
    }

    public function show($id)
    {
        $applicant = $this->jobUsersApplyService->show($id);
        return view("pages.applicants.detail", compact('applicant'));
    }

    public function update($id, Request $request)
    {
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

        $validate = $request->validate($rules, [], $attrNames);

        $update = $this->jobUsersApplyService->update($id, $validate);

        if ($update) {
            return redirect()->route('applicants.detail', ['id' => $id])->with('success', 'Successfully to updated information.');
        } else {
            return redirect()->route('applicants.detail', ['id' => $id])->with('errors', 'Failed to updated information.');
        }
    }
}
