<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\ExpectedSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpectedSalaryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/masterdata/expected-salaries",
     *     tags={"Masterdata"},
     *     summary="Get all expected salary ranges",
     *     description="Retrieve a list of all active expected salary ranges.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Expected salary ranges retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Expected salary ranges retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="< Rp. 3.000.000"),
     *                     @OA\Property(property="description", type="string", example="Salary below 3 million rupiah"),
     *                     @OA\Property(property="is_active", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve expected salary ranges",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve expected salary ranges"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $expectedSalaries = ExpectedSalary::active()->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Expected salary ranges retrieved successfully',
                'data' => $expectedSalaries
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve expected salary ranges',
                'data' => null
            ], 500);
        }
    }

    /**
     * Store a newly created expected salary range.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:expected_salaries,name',
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

            $expectedSalary = ExpectedSalary::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Expected salary range created successfully',
                'data' => $expectedSalary
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create expected salary range',
                'data' => null
            ], 500);
        }
    }
}
