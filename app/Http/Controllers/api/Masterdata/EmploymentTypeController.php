<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmploymentTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/masterdata/employment-types",
     *     tags={"Masterdata"},
     *     summary="Get all employment types",
     *     description="Retrieve a list of all active employment types.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Employment types retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Employment types retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Fulltime"),
     *                     @OA\Property(property="description", type="string", example="Full-time employment with regular working hours"),
     *                     @OA\Property(property="is_active", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve employment types",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve employment types"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $employmentTypes = EmploymentType::active()->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Employment types retrieved successfully',
                'data' => $employmentTypes
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve employment types',
                'data' => null
            ], 500);
        }
    }

    /**
     * Store a newly created employment type.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:employment_types,name',
                'description' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'data' => null
                ], 422);
            }

            $employmentType = EmploymentType::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Employment type created successfully',
                'data' => $employmentType
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create employment type',
                'data' => null
            ], 500);
        }
    }
}
