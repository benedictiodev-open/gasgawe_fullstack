<dialog id="showCreateSkillModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateSkillModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Create Skill</h3>

    <!-- Skill Creation Form -->
    <form action="{{ route('masterdata.skills.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <!-- Skill Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Skill Name</span>
          </div>
          <input type="text" name="name" placeholder="Enter skill name"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('name'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
            </div>
          @endif
        </label>

        <!-- Skill Group Dropdown -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Skill Group</span>
          </div>
          <select name="skill_group_id" class="select select-bordered select-sm w-full input-sm" required>
            <option value="" disabled selected>Select a Skill Group</option>
            @foreach ($skillGroups as $group)
              <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
          </select>
          @if ($errors->has('skill_group_id'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('skill_group_id') }}</span>
            </div>
          @endif
        </label>

        <!-- Submit Button -->
        <div class="flex gap-3 pt-8 items-center justify-end">
          <button type="submit" class="btn btn-sm btn-primary">Save</button>
        </div>

      </div>
    </form>
  </div>
</dialog>

<dialog id="showDeleteSkillModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this skill?</p>

    <form method="POST" :action="`{{ route('masterdata.skills.delete', ':id') }}`.replace(':id', deleteSkillId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteSkillModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
