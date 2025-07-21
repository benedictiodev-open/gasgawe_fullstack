<?php

namespace App\Services\Masterdata;

use App\Models\ExpectedSalary;
use Illuminate\Http\Request;

class ExpectedSalaryService
{
    public function getAllExpectedSalaries()
    {
        return ExpectedSalary::all();
    }
}
