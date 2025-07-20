<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfileCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\IndonesiaService;

use function PHPSTORM_META\type;

class RecruiterController extends Controller
{
    public function __construct(private IndonesiaService $indonesiaService)
    {
        $this->indonesiaService = $indonesiaService;
    }

    public function index()
    {
        $list = User::with('profileCompany', 'profileCompany.industryType')
            ->where('type', 'recruiter')->get();

        return view('pages.recruiters.index', ['recruiters' => $list]);
    }

    public function detail($id)
    {
        $data = User::with('profileCompany', 'profileCompany.province', 'profileCompany.city')
            ->where('type', 'recruiter')->where('id', $id)->first();

        $provinces = $this->indonesiaService->allProvinces();

        return view('pages.recruiters.detail', ['detail' => $data, 'provinces' => $provinces]);
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

        $data = User::with('profileCompany', 'profileCompany.province', 'profileCompany.city')
            ->where('type', 'recruiter')->where('id', $id)->first();

        $profile_company = UserProfileCompany::query()->firstWhere('id', $data->profileCompany->id)->update($validate->getData());

        if ($profile_company) {
            return redirect()->route('recruiters.detail', ['id' => $id])->with('success', 'Successfully to updated information.');
        } else {
            return redirect()->route('recruiters.detail', ['id' => $id])->with('errors', 'Failed to updated information.');
        }
    }
}
