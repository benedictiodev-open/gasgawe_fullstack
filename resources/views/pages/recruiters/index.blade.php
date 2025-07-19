@extends('_layout')

@push('title')
  Recruiters
@endpush

@section('main')
  <div class="grid grid-cols-12 items-center gap-5">
    {{-- SEARCH & FILTER --}}
    <div class="col-span-12 flex flex-row items-center gap-2">
      <div class="flex-1">
        <label class="input input-bordered flex items-center gap-2">
          <input type="text" class="grow" placeholder="Search" />
          <i class="fa-solid fa-magnifying-glass"></i>
        </label>
      </div>
      <div class="flex-none">
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
              <th>All Recruiters</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Industry</th>
              <th>Size</th>
              <th>Verified</th>
              <th>Email</th>
              <th>Domain</th>
              <th>Job Approval</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($recruiters as $key => $item)
              <tr class="rounded-xl bg-base-100 mb-2">
                <td class="first:rounded-l-xl">
                  <div class="flex items-center gap-3">
                    <div class="avatar">
                      <div class="rounded-full h-12 w-12">
                        @if ($item->profileCompany->file_profile_image)
                          <img src="{{ asset($item->profileCompany->file_profile_image) }}"
                            alt="Company Picture" />
                        @else
                          <div class="h-12 w-12 bg-info flex justify-center items-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($item->profileCompany->company_name, 0, 1)) }}
                          </div>
                        @endif
                      </div>
                    </div>
                    <div>
                      <p class="font-bold">{{ $item->profileCompany->company_name }}</p>
                      <p class="text-sm opacity-50">Registered {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                    </div>
                  </div>
                </td>
                <td>{{ $item->email }}</td>
                <td>!!!</td>
                <td>{{ $item->profileCompany->industryType?->name ?? '-' }}</td>
                <td>{{ $item->profileCompany->employee_count ?? 0 }}</td>
                <td class="text-center"><i
                    class="fa-solid fa-circle-check text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center"><i
                    class="fa-solid fa-envelope-circle-check text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center"><i
                    class="fa-solid fa-building text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center"><i
                    class="fa-solid fa-folder-closed text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <th>
                  <div
                    class="badge {{ $key % 2 == 0 ? 'badge-success' : 'bg-gray-400' }} rounded-md p-3 text-white font-normal">
                    Active</div>
                </th>
                <th class="last:rounded-r-xl">
                  <div class="flex flex-row items-center gap-2">
                    <a href="{{ route('recruiters.detail', ['id' => $item->id]) }}" rel="noopener noreferrer">
                      <i class="fa-solid fa-pen text-lg text-info"></i>
                    </a>
                    <i class="fa-solid fa-ban text-lg text-error"></i>
                    <i class="fa-solid fa-trash-can text-lg text-error"></i>
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
