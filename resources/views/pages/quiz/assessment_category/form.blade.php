<dialog id="showCreateCategoryModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateCategoryModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Create Category</h3>

    <!-- Category Creation Form -->
    <form action="{{ route('quiz.categories.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <input type="text" name="assessment_id" id="assessment_id" hidden value="{{ Request::route('id') }}" />

        <!-- Category Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Name</span>
          </div>
          <input type="text" name="name" placeholder="Enter category name"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('name'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
            </div>
          @endif
        </label>

        <!-- Weight Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Weight</span>
          </div>
          <input type="number" min="1" name="weight" placeholder="Enter weight"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('weight'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('weight') }}</span>
            </div>
          @endif
        </label>

        <!-- Description Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Description</span>
          </div>
          <textarea class="textarea textarea-bordered h-24 w-full textarea-sm" name="description" placeholder="Enter description"
            required></textarea>
          @if ($errors->has('description'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('description') }}</span>
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

<dialog id="showDeleteCategoryModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this category?</p>

    <form method="POST" :action="`{{ route('quiz.categories.delete', ':id') }}`.replace(':id', deleteCategoryId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteCategoryModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
