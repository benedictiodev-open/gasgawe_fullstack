<dialog id="showCreateEmploymentTypeModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateEmploymentTypeModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Detail Employment Type</h3>

    <!-- Employment Type Creation Form -->
    <form action="{{ route('masterdata.employmentType.store') }}" method="POST">
      @csrf
      <div class="space-y-3">
        <!-- Employment Type Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Employment Type Name</span>
          </div>
          <input type="text" name="name" placeholder="Enter employment type name"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('name'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
            </div>
          @endif
        </label>

        <!-- EmploymentType Description Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Employment Type Description</span>
          </div>
          <input type="text" name="description" placeholder="Enter employment type description"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('description'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('description') }}</span>
            </div>
          @endif
        </label>

        <!-- Status Field as Radio Buttons -->
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text">Status</span>
          </label>
          <div class="flex items-center gap-4">
            <label class="label cursor-pointer gap-2">
              <input type="radio" name="is_active" value="1" class="radio radio-primary" checked />
              <span class="label-text">Active</span>
            </label>
            <label class="label cursor-pointer gap-2">
              <input type="radio" name="is_active" value="0" class="radio radio-secondary" />
              <span class="label-text">Inactive</span>
            </label>
          </div>
          @if ($errors->has('is_active'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('is_active') }}</span>
            </div>
          @endif
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3 pt-8 items-center justify-end">
          <button type="submit" class="btn btn-sm btn-primary">Save</button>
        </div>

      </div>
    </form>
  </div>
</dialog>

<dialog id="showDeleteEmploymentTypeModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this employmentType?</p>

    <form method="POST"
      :action="`{{ route('masterdata.employmentType.delete', ':id') }}`.replace(':id', deleteEmploymentTypeId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteEmploymentTypeModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
