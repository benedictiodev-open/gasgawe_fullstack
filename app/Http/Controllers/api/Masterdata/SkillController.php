<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Services\Masterdata\SkillService;
use App\Traits\ResponseTrait;

class SkillController extends Controller
{
    use ResponseTrait;

    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    /**
     * Display a listing of the resource.
     */
    public function skill()
    {
        try {
            $data = $this->skillService->getSkill();

            return $this->successResponse($data, 'Skill retrieved successfully');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
