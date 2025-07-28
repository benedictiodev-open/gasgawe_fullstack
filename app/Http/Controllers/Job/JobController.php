<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Services\Job\JobMasterService;
use App\Services\Masterdata\EmployeeTypeService;
use App\Services\Masterdata\ExpectedSalaryService;
use Illuminate\Http\Request;
use Laravolt\Indonesia\IndonesiaService;

class JobController extends Controller
{
    public function __construct(
        private JobMasterService $jobMasterService,
        private IndonesiaService $indonesiaService,
        private EmployeeTypeService $employeeTypeService,
        private ExpectedSalaryService $expectedSalaryService,
    ) {
        $this->jobMasterService = $jobMasterService;
        $this->indonesiaService = $indonesiaService;
        $this->employeeTypeService = $employeeTypeService;
        $this->expectedSalaryService = $expectedSalaryService;
    }

    public function index(Request $request)
    {
        $jobs = $this->jobMasterService->index($request->query());

        return view('pages.jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = $this->jobMasterService->show($id);
        $provinces = $this->indonesiaService->allProvinces();
        $employee_types = $this->employeeTypeService->getAllEmployeeTypes();
        $expected_salaries = $this->expectedSalaryService->getAllExpectedSalaries();

        return view('pages.jobs.detail', compact('job', 'provinces', 'employee_types', 'expected_salaries'));
    }

    public function update($id, Request $request)
    {
        $validate = [];
        $rules = [];
        $attrNames = [];

        switch ($request?->type_update) {
            case 'job_information':
                $rules = [
                    "company_name" => 'required|integer',
                    "province_id" => 'required|exists:indonesia_provinces,id',
                    "city_id" => 'required|exists:indonesia_cities,id',
                    "created_by" => 'sometimes|datetime',
                    "created_at" => 'sometimes|datetime',
                    "employment_type_id" => 'sometimes|exists:employment_types,id',
                    "position" => 'sometimes|exists:users,id',
                    "expected_salary_id" => 'sometimes|exists:expected_salaries,id',
                ];
                $attrNames = [
                    "company_name" => 'Company',
                    "province_id" => 'Province',
                    "city_id" => 'City',
                    "created_by" => 'Posted By',
                    "created_at" => 'Posted Date',
                    "employment_type_id" => 'Job Type',
                    "position" => 'Position',
                    "expected_salary_id" => 'Salary',
                ];
                break;

            case 'job_description':
                $rules = [
                    "description" => 'required|string'
                ];
                $attrNames = [
                    "description" => 'Job Description'
                ];
                break;

            case 'job_qualification':
                $rules = [
                    "qualification" => 'required|string'
                ];
                $attrNames = [
                    "qualification" => 'Qualification and Requirements'
                ];
                break;

            default:
                # code...
                break;
        }

        $validate = $request->validate($rules, [], $attrNames);

        $job = $this->jobMasterService->update($id, $validate);

        if ($job) {
            return redirect()->route('jobs.detail', ['id' => $id])->with('success', 'Successfully to updated information.');
        } else {
            return redirect()->route('jobs.detail', ['id' => $id])->with('errors', 'Failed to updated information.');
        }
    }
}
