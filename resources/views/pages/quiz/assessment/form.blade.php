<dialog id="showCreateQuizModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateQuizModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Create Quiz</h3>

    <!-- Quiz Creation Form -->
    <form action="{{ route('quiz.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <!-- Quiz Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Name</span>
          </div>
          <input type="text" name="name" placeholder="Enter quiz name"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('name'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
            </div>
          @endif
        </label>

        <!-- Role Dropdown -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Role</span>
          </div>
          <select name="role" class="select select-bordered select-sm w-full input-sm" required>
            <option value="" disabled selected>Select a Role</option>
            <option value="applicant">Applicant</option>
            <option value="recruiter">Recruiter</option>
          </select>
          @if ($errors->has('role'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('role') }}</span>
            </div>
          @endif
        </label>

        <!-- Estimated Duration Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Estimated Duration</span>
          </div>
          <input type="number" min="1" name="estimated_duration" placeholder="Enter estimated duration (minute)"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('estimated_duration'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('estimated_duration') }}</span>
            </div>
          @endif
        </label>

        <!-- Scoring System Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Scoring System</span>
          </div>
          <input type="text" name="scoring_system" placeholder="Enter scoring system"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('scoring_system'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('scoring_system') }}</span>
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

<dialog id="showDeleteQuizModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this quiz?</p>

    <form method="POST" :action="`{{ route('quiz.delete', ':id') }}`.replace(':id', deleteQuizId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteQuizModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
