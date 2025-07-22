<?php

namespace App\Services\Masterdata;

use App\Models\EmploymentType;
use Illuminate\Http\Request;

class EmployeeTypeService
{
    public function getAllEmployeeTypes()
    {
        return EmploymentType::all();
    }
}
