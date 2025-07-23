<dialog id="showCreateOptionModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateOptionModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Create Option</h3>

    <!-- Option Creation Form -->
    <form action="{{ route('quiz.options.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <input type="text" name="assessment_question_id" id="assessment_question_id" hidden
          value="{{ Request::route('id') }}" />

        <!-- Text Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Text</span>
          </div>
          <textarea class="textarea textarea-bordered h-24 w-full textarea-sm" name="text" placeholder="Enter text" required></textarea>
          @if ($errors->has('text'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('text') }}</span>
            </div>
          @endif
        </label>

        <!-- Score Value Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Score</span>
          </div>
          <input type="number" name="score_value" placeholder="Enter score" min="0"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('score_value'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('score_value') }}</span>
            </div>
          @endif
        </label>

        <!-- Score Conversion Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Score Conversion</span>
          </div>
          <input type="number" name="score_conversion" placeholder="Enter score conversion" min="0"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('score_conversion'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('score_conversion') }}</span>
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

<dialog id="showDeleteOptionModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this option?</p>

    <form method="POST" :action="`{{ route('quiz.options.delete', ':id') }}`.replace(':id', deleteOptionId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteOptionModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
