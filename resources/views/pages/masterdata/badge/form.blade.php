<dialog id="showCreateBadgeModal" class="modal">
  <div class="modal-box">
    <!-- Close Button -->
    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
      onclick="document.getElementById('showCreateBadgeModal').close();">✕</button>

    <!-- Modal Title -->
    <h3 class="text-lg font-bold">Detail Badge</h3>

    <!-- Badge Creation Form -->
    <form action="{{ route('masterdata.badge.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="space-y-3">
        <!-- Badge Name Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Badge Name</span>
          </div>
          <input type="text" name="name" placeholder="Enter badge name"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('name'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('name') }}</span>
            </div>
          @endif
        </label>

        <!-- Badge Description Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Badge Description</span>
          </div>
          <input type="text" name="description" placeholder="Enter badge description"
            class="input input-bordered w-full input-sm" required />
          @if ($errors->has('description'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('description') }}</span>
            </div>
          @endif
        </label>

        <!-- Badge Image Upload Field -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Badge Image</span>
          </div>

          <input type="file" name="image" accept="image/*"
            class="file-input file-input-bordered w-full file-input-sm file-input-primary" id="badgeImageInput"
            x-ref="fileInput" />

          {{-- Image Preview --}}
          <div class="mt-2" id="badgeImagePreviewWrapper" style="display: none;">
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Existing Badge Image</span>
              </div>
              <div class="flex justify-center">
                <img id="badgeImagePreview" class="w-32 h-32 object-cover rounded border" />
              </div>
          </div>

          @if ($errors->has('image'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('image') }}</span>
            </div>
          @endif
        </label>

        <!-- Badge Type Dropdown -->
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Badge Type</span>
          </div>
          <select name="type" class="select select-bordered select-sm w-full input-sm" required>
            <option value="" disabled selected>Select a Badge Type</option>
            @foreach ($userTypes as $type)
              <option value="{{ $type->value }}">{{ $type->label }}</option>
            @endforeach
          </select>
          @if ($errors->has('type'))
            <div class="label">
              <span class="label-text-alt text-error">{{ $errors->first('type') }}</span>
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

<dialog id="showDeleteBadgeModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p class="py-4">Are you sure you want to delete this badge?</p>

    <form method="POST" :action="`{{ route('masterdata.badge.delete', ':id') }}`.replace(':id', deleteBadgeId)">
      @csrf
      @method('DELETE')

      <div class="modal-action">
        <button type="button" class="btn btn-outline"
          onclick="document.getElementById('showDeleteBadgeModal').close()">Cancel</button>
        <button type="submit" class="btn btn-error">Delete</button>
      </div>
    </form>
  </div>
</dialog>
