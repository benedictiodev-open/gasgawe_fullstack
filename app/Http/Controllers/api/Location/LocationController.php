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
     * @OA\Get(
     *     path="/masterdata/province",
     *     tags={"Masterdata"},
     *     summary="Get all provinces",
     *     description="Retrieve a list of all provinces in Indonesia.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Provinces retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="string", example="11"),
     *                     @OA\Property(property="name", type="string", example="ACEH"),
     *                     @OA\Property(property="meta", type="object")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function allProvinces()
    {
        return response()->json([
            "message" => "success",
            "data" => $this->indonesiaService->allProvinces()
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/masterdata/cities/{id}",
     *     tags={"Masterdata"},
     *     summary="Get cities by province ID",
     *     description="Retrieve a list of cities for a specific province.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Province ID",
     *         @OA\Schema(type="string", example="11")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cities retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="string", example="1101"),
     *                     @OA\Property(property="province_id", type="string", example="11"),
     *                     @OA\Property(property="name", type="string", example="KABUPATEN SIMEULUE"),
     *                     @OA\Property(property="meta", type="object")
     *                 )
     *             )
     *         )
     *     )
     * )
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
