<?php

namespace App\Repositories\Masterdata;

use Illuminate\Support\Facades\DB;

class SkillRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  public function getSkill()
  {
    return DB::table('skills')
      ->join('skill_groups', 'skills.skill_group_id', '=', 'skill_groups.id')
      ->select(
        'skills.id',
        'skills.name',
        DB::raw('skill_groups.name AS skill_group_name')
      )
      ->get();
  }
}
