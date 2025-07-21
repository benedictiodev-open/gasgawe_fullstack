<?php

namespace App\Repositories\Masterdata;

use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class SkillRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQuerySkill(array $request = [])
  {
    $query = DB::table('skills')
      ->join('skill_groups', 'skills.skill_group_id', '=', 'skill_groups.id')
      ->select(
        'skills.id',
        'skills.name',
        DB::raw('skill_groups.id AS skill_group_id'),
        DB::raw('skill_groups.name AS skill_group_name')
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('skills.name', 'like', '%' . $search . '%')
          ->orWhere('skill_groups.name', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllSkills()
  {
    return $this->getQuerySkill()->get();
  }

  public function getPaginatedSkills($request, $perPage = 10)
  {
    return $this->getQuerySkill($request)->paginate($perPage);
  }

  private function getQuerySkillGroup(array $request = [])
  {
    $query = DB::table('skill_groups')
      ->select(
        'skill_groups.id',
        'skill_groups.name',
      );

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('skill_groups.name', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }
  public function getAllSkillGroups()
  {
    return $this->getQuerySkillGroup()->get();
  }

  public function getPaginatedSkillGroups($request, $perPage = 10)
  {
    return $this->getQuerySkillGroup($request)->paginate($perPage);
  }

  public function store(array $data): Skill
  {
    return Skill::create($data);
  }

  public function update(int $id, array $data): Skill
  {
    $skill = Skill::findOrFail($id);
    $skill->update($data);
    return $skill;
  }

  public function delete(int $id): bool
  {
    $skill = Skill::findOrFail($id);
    return $skill->delete();
  }
}
