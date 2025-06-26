<?php

namespace App\Http\Controllers\api\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravolt\Indonesia\IndonesiaService;

class LocationController extends Controller
{
    public function __construct(private IndonesiaService $indonesiaService)
    {
        $this->indonesiaService = $indonesiaService;
    }

    /**
     * Display a listing of provinces.
     */
    public function allProvinces()
    {
        return response()->json([
            "message" => "success",
            "data" => $this->indonesiaService->allProvinces()
        ], 200);
    }

    /**
     * Display a listing of cities by province.
     * @param id string province id
     */
    public function getCitiesByProvinceId($id)
    {
        $data = json_decode($this->indonesiaService->findProvince($id, ['cities']));
        return response()->json([
            "message" => "success",
            "data" => $data->cities
        ], 200);
    }

    /**
     * Display a listing of dusctricts by city.
     * @param id string city id
     */
    public function getDistrictsByCityId($id)
    {
        $data = json_decode($this->indonesiaService->findCity($id, ['districts']));
        return response()->json([
            "message" => "success",
            "data" => $data->districts
        ], 200);
    }

    /**
     * Display a listing of villages by district.
     * @param id string village id
     */
    public function getVillagesbyDistrictId($id)
    {
        $data = json_decode($this->indonesiaService->findDistrict($id, ['villages']));
        return response()->json([
            "message" => "success",
            "data" => $data->villages
        ], 200);
    }
}
