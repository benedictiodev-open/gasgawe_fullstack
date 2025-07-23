<dialog id="showCreateQuestionModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateQuestionModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Create Question</h3>

    <!-- Question Creation Form -->
    <form action="{{ route('quiz.questions.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <input type="text" name="assessment_category_id" id="assessment_category_id" hidden
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

        <!-- Question Type Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Question Type</span>
          </div>
          <input type="text" name="question_type" placeholder="Enter question type"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('question_type'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('question_type') }}</span>
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

<dialog id="showDeleteQuestionModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this question?</p>

    <form method="POST" :action="`{{ route('quiz.questions.delete', ':id') }}`.replace(':id', deleteQuestionId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteQuestionModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
