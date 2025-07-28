<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Services\Job\JobCompanyService;
use Illuminate\Http\Request;
use Laravolt\Indonesia\IndonesiaService;

class RecruiterController extends Controller
{
    public function __construct(
        protected JobCompanyService $jobCompanyService,
        protected IndonesiaService $indonesiaService
    ) {
        $this->indonesiaService = $indonesiaService;
        $this->jobCompanyService = $jobCompanyService;
    }

    public function index(Request $request)
    {
        $recruiters =  $this->jobCompanyService->index($request);
        return view('pages.recruiters.index', compact('recruiters'));
    }

    public function detail($id)
    {
        $detail = $this->jobCompanyService->show($id);

        $provinces = $this->indonesiaService->allProvinces();

        return view('pages.recruiters.detail', compact('detail', 'provinces'));
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

        $validate =  $request->validate($rules, [], $attrNames);

        $profile_company = $this->jobCompanyService->update($id, $validate);

        if ($profile_company) {
            return redirect()->route('recruiters.detail', ['id' => $id])->with('success', 'Successfully to updated information.');
        } else {
            return redirect()->route('recruiters.detail', ['id' => $id])->with('errors', 'Failed to updated information.');
        }
    }
}
