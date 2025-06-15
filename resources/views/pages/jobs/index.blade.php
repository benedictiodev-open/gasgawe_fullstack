@extends('_layout')

@push('title')
  Jobs
@endpush

@section('main')
  <div class="grid grid-cols-12 items-center gap-5">
    {{-- SEARCH & FILTER --}}
    <div class="col-span-12 flex flex-row items-center gap-2 static">
      <div class="flex-1">
        <label class="input input-bordered flex items-center gap-2">
          <input type="text" class="grow" placeholder="Search" />
          <i class="fa-solid fa-magnifying-glass"></i>
        </label>
      </div>
      <div class="flex-none static">
        <div class="dropdown dropdown-end">
          <div tabindex="1" role="button" class="btn"><i class="fa-solid fa-filter"></i> Filter <i
              class="fa-solid fa-caret-down"></i> </div>
          <ul tabindex="1" class="dropdown-content menu bg-base-100 rounded-lg w-52 z-[1] p-0 shadow mt-2">
            <div class="bg-base-200 p-3 rounded-t-lg">
              <p class="text-center">Choose Filter</p>
            </div>
            <div>
              <div class="form-control">
                <label class="label cursor-pointer justify-normal gap-2">
                  <input type="checkbox" name="location" class="checkbox checkbox-sm" />
                  <span class="label-text text-sm">Location</span>
                </label>
              </div>
              <div class="form-control">
                <label class="label cursor-pointer justify-normal gap-2">
                  <input type="checkbox" name="level" class="checkbox checkbox-sm" />
                  <span class="label-text text-sm">Level</span>
                </label>
              </div>
              <div class="form-control">
                <label class="label cursor-pointer justify-normal gap-2">
                  <input type="checkbox" name="badges" class="checkbox checkbox-sm" />
                  <span class="label-text text-sm">Badges</span>
                </label>
              </div>
              <div class="form-control">
                <label class="label cursor-pointer justify-normal gap-2">
                  <input type="checkbox" name="status" class="checkbox checkbox-sm" />
                  <span class="label-text text-sm">Status</span>
                </label>
              </div>
            </div>
            <div class="bg-base-200 p-3 rounded-t-lg">
              <input type="text" class="input input-bordered input-sm w-full" placeholder="Search" />
            </div>
            <div class="flex flex-row justify-between items-center p-2">
              <button class="btn btn-sm btn-outline">Reset</button>
              <button class="btn btn-sm btn-primary">Apply</button>
            </div>
          </ul>
        </div>
      </div>
    </div>
    {{-- END SEARCH & FILTER --}}

    {{-- FILTER --}}
    <div class="col-span-12">
      <div class="overflow-x-auto">
        <table class="table border-separate border-spacing-y-2">
          <!-- head -->
          <thead>
            <tr>
              <th>Job Title</th>
              <th>Company</th>
              <th>Posted By</th>
              <th>Location</th>
              <th>Posted Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach (range(1, 4) as $item)
              <tr class="rounded-xl bg-base-100 mb-2">
                <th class="first:rounded-l-xl">
                  Full-Stack Developer {{ $item }}
                </th>
                <td>Tech Solution Inc.</td>
                <td>HR Manager</td>
                <td>Jakarta, Indonesia</td>
                <td>2025-06-15</td>
                <th>
                  <div
                    class="badge {{ $item == 1 ? 'badge-success' : ($item == 2 ? 'bg-gray-400' : 'bg-error') }} rounded-md p-3 text-white font-normal">
                    {{ $item == 1 ? 'Active' : ($item == 2 ? 'Pending' : 'Closed') }}
                  </div>
                </th>
                <th class="last:rounded-r-xl">
                  <div class="flex flex-row items-center gap-2">
                    <i class="fa-solid fa-pen text-lg text-info"></i>
                    <i class="fa-solid fa-ban text-lg text-error"></i>
                    <i class="fa-solid fa-ellipsis text-lg text-gray-400"></i>
                  </div>
                </th>
              </tr>
            @endforeach
        </table>
      </div>
    </div>
    {{-- END FILTER --}}
  </div>
@endsection
