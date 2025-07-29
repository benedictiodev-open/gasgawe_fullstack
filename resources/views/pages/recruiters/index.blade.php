@extends('_layout')

@push('title')
  Recruiters
@endpush

@section('main')
  <div class="grid grid-cols-12 items-center gap-5">
    {{-- SEARCH & FILTER --}}
    <div class="col-span-12 flex flex-row items-center gap-2" x-data="searchForm()">
      <div class="flex-1">
        <div>
          <form @submit.prevent="submitForm">
            <label class="input input-bordered flex items-center gap-2">
              <input type="text" class="grow" placeholder="Search" x-model="query" @keydown.enter="submitForm"
                :value="query" aria-label="Search" />
              <div class="flex space-x-4">
                <template x-if="query">
                  <div class="cursor-pointer ml-2" @click="clearSearch">
                    <i class="fa-solid fa-times-circle"></i>
                  </div>
                </template>
                <div class="cursor-pointer" @click="submitForm">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
              </div>
            </label>
          </form>
        </div>
      </div>
      <div class="flex-none">
        <div class="dropdown dropdown-end">
          <div tabindex="1" role="button" class="btn"><i class="fa-solid fa-filter"></i> Filter <i
              class="fa-solid fa-caret-down"></i> </div>
          <ul tabindex="1" class="dropdown-content menu bg-base-100 rounded-lg w-52 z-[1] p-0 shadow mt-2">
            <div class="bg-base-200 p-3 rounded-t-lg">
              <p class="text-center">Choose Filter</p>
            </div>
            <form @submit.prevent="submitFilter">
              <div>
                <div class="form-control">
                  <label class="label cursor-pointer justify-normal gap-2">
                    <input type="checkbox" value="location" class="checkbox checkbox-sm" x-model="queryFilterSelections"
                      name="filterBy[]" />
                    <span class="label-text text-sm">Location</span>
                  </label>
                </div>
                {{-- <div class="form-control">
                  <label class="label cursor-pointer justify-normal gap-2">
                    <input type="checkbox" value="status" class="checkbox checkbox-sm" x-model="queryFilterSelections"
                      name="filterBy[]" />
                    <span class="label-text text-sm">Status</span>
                  </label>
                </div> --}}
              </div>
              <div class="bg-base-200 p-3 rounded-t-lg">
                <input type="text" class="input input-bordered input-sm w-full" placeholder="Search"
                  x-model="queryFilterText" />
              </div>
              <div class="flex flex-row justify-between items-center p-2">
                <button class="btn btn-sm btn-outline" type="reset">Reset</button>
                <button class="btn btn-sm btn-primary" type="submit">Apply</button>
              </div>
            </form>
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
                <td class="first:rounded-l-xl text-nowrap">
                  <div class="flex items-center gap-3">
                    <div class="avatar">
                      <div class="rounded-full h-12 w-12">
                        @if ($item->profileCompany?->file_profile_image)
                          <img src="{{ asset('storage/' . $item->profileCompany->file_profile_image) }}"
                            alt="Company Picture" class="object-cover w-full h-full" />
                        @else
                          <div class="h-12 w-12 bg-info flex justify-center items-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($item->profileCompany?->company_name ?? $item->email, 0, 1)) }}
                          </div>
                        @endif
                      </div>
                    </div>
                    <div>
                      <p class="font-bold">{{ $item->profileCompany?->company_name ?? '-' }}</p>
                      <p class="text-sm opacity-50">Registered
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                    </div>
                  </div>
                </td>
                <td class="text-nowrap">{{ $item->email }}</td>
                <td class="text-nowrap">-</td>
                <td class="text-nowrap">{{ $item->profileCompany?->industryType?->name ?? '-' }}</td>
                <td class="text-nowrap">{{ $item->profileCompany?->employee_count ?? 0 }}</td>
                <td class="text-center text-nowrap"><i
                    class="fa-solid fa-circle-check text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center text-nowrap"><i
                    class="fa-solid fa-envelope-circle-check text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center text-nowrap"><i
                    class="fa-solid fa-building text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <td class="text-center text-nowrap"><i
                    class="fa-solid fa-folder-closed text-lg {{ $key % 2 == 0 ? 'text-success' : 'text-gray-400' }}"></i>
                </td>
                <th>
                  <div
                    class="badge {{ $key % 2 == 0 ? 'badge-success' : 'bg-gray-400' }} rounded-md p-3 text-white font-normal text-nowrap">
                    Active</div>
                </th>
                <th class="last:rounded-r-xl">
                  <div class="flex flex-row items-center gap-2">
                    <a href="{{ route('recruiters.detail', ['id' => $item->id]) }}" rel="noopener noreferrer">
                      <i class="fa-solid fa-circle-info text-lg text-gray-400"></i>
                    </a>
                    {{-- <i class="fa-solid fa-ban text-lg text-error"></i>
                    <i class="fa-solid fa-trash-can text-lg text-error"></i> --}}
                  </div>
                </th>
              </tr>
            @endforeach
        </table>
      </div>
      {{ $recruiters->links() }}
    </div>
    {{-- END FILTER --}}
  </div>
@endsection


@push('script')
  <script>
    function searchForm() {
      return {
        query: '',
        queryFilterSelections: [],
        queryFilterText: '',

        init() {
          const urlParams = new URLSearchParams(window.location.search);
          this.query = urlParams.get('search') || '';
          this.queryFilterSelections = urlParams.getAll('filterBy[]') || [];
          this.queryFilterText = urlParams.get('filter') || '';
        },

        submitForm() {
          const url = new URL(window.location.pathname, window.location.origin);
          if (this.query || this.queryFilterSelections.length > 0 || this.queryFilterText) {
            if (this.query) {
              url.searchParams.set('search', this.query)
            }
            if (this.queryFilterSelections.length > 0) {
              this.queryFilterSelections.forEach(item => {
                url.searchParams.append('filterBy[]', item)
              });
            }
            if (this.queryFilterText != '') {
              url.searchParams.set('filter', this.queryFilterText)
            }

            window.location.href = url.href;
          } else {
            window.location.href = url;
          }
        },

        submitFilter() {
          const url = new URL(window.location.pathname, window.location.origin);
          if (this.query || this.queryFilterSelections.length > 0 || this.queryFilterText) {
            if (this.query) {
              url.searchParams.set('search', this.query)
            }
            if (this.queryFilterSelections.length > 0) {
              this.queryFilterSelections.forEach(item => {
                url.searchParams.append('filterBy[]', item);
              });
            }
            if (this.queryFilterText != '') {
              url.searchParams.set('filter', this.queryFilterText)
            }

            window.location.href = url.href;
          } else {
            window.location.href = url;
          }
        },

        clearSearch() {
          window.history.pushState({}, '', window.location.pathname);
          this.query = '';
        }
      };
    }
  </script>
@endpush
