@extends('_layout')

@push('title')
  Recruiters Detail
@endpush

@section('main')
  <div class="grid grid-cols-12 gap-5">
    {{-- NAME --}}
    <div class="col-span-12 flex flex-row items-center gap-2">
      <div class="card bg-base-100 shadow-xl w-full">
        <div class="card-body p-5 flex flex-row justify-between">
          <div class="flex flex-row items-center gap-5">
            <div class="avatar">
              <div class="avatar placeholder">
                <div class="text-white rounded-md h-16 w-16">
                  @if ($detail->profileCompany?->file_profile_image)
                    <img src="{{ asset('storage/' . $detail->profileCompany->file_profile_image) }}"
                      alt="Company Picture" />
                  @else
                    <div class=" h-16 w-16 bg-info flex justify-center items-center text-white text-3xl font-bold">
                      {{ strtoupper(substr($detail->profileCompany?->company_name ?? $detail->email, 0, 1)) }}
                    </div>
                  @endif
                </div>
              </div>
            </div>

            <div>
              <h2 class="card-title">{{ $detail->profileCompany?->company_name ?? '-' }}</h2>
              <p class="text-gray-400 text-sm">Joined {{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y') }}
              </p>
            </div>
          </div>

          <div>
            <div class="badge badge-success rounded-md p-3 text-white font-normal">Active</div>
          </div>
        </div>
      </div>
    </div>
    {{-- END NAME --}}

    <div class="col-span-9 space-y-3">
      {{-- PERSONAL INFORMATION --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <div class="flex flex-row items-center justify-between">
            <h2 class="card-title">Personal Information</h2>

            {{-- <button type="button" id="editInformationBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button> --}}
          </div>

          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Company</td>
                <th class="text-left pl-5">{{ $detail->profileCompany?->company_name ?? '-' }}</th>
              </tr>
              <tr>
                <td>Location</td>
                <th class="text-left pl-5">{{ $detail->profileCompany?->city?->name ?? '-' }},
                  {{ $detail->profileCompany?->province?->name ?? '-' }}</th>
              </tr>
              <tr>
                <td>Size</td>
                <th class="text-left pl-5">{{ $detail->profileCompany?->employee_count ?? 0 }} Employees</th>
              </tr>
              <tr>
                <td>Account Status</td>
                <th class="text-left pl-5">Active</th>
              </tr>
              <tr>
                <td>Verification Status</td>
                <th class="text-left pl-5 text-success">
                  <i class="fa-solid fa-circle-check mr-0.5"></i>
                  Verified
                </th>
              </tr>
              <tr>
                <td>Registration Date</td>
                <th class="text-left pl-5">{{ \Carbon\Carbon::parse($detail->created_at)->format('d M Y') }}</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END PERSONAL INFORMATION --}}

      {{-- CONTACT INFORMATION --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <div class="flex flex-row items-center justify-between">
            <h2 class="card-title">Contact Information</h2>
            {{-- <button type="button" id="contactInformationBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button> --}}
          </div>
          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Website</td>
                <th class="text-left pl-5">-</th>
              </tr>
              <tr>
                <td>Email</td>
                <th class="text-left pl-5">{{ $detail->email }}</th>
              </tr>
              <tr>
                <td>Phone</td>
                <th class="text-left pl-5">-</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END CONTACT INFORMATION --}}

      {{-- VERIFICATION STATUS --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Verification Status</h2>
          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td><i class="fa-solid fa-circle-check text-2xl text-success"></i></td>
                <td class="text-left pl-4">
                  <div>
                    <p class="text-lg text-gray-400">Company</p>
                    <p class="text-sm text-success">Verified</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td><i class="fa-solid fa-envelope-circle-check text-2xl text-success"></i></td>
                <td class="text-left pl-4">
                  <div>
                    <p class="text-lg text-gray-400">Email</p>
                    <p class="text-sm text-success">Verified</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td><i class="fa-solid fa-building text-2xl text-success"></i></td>
                <td class="text-left pl-4">
                  <div>
                    <p class="text-lg text-gray-400">Domain</p>
                    <p class="text-sm text-success">Verified</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td><i class="fa-solid fa-folder-closed text-2xl text-success"></i></td>
                <td class="text-left pl-4">
                  <div>
                    <p class="text-lg text-gray-400">Job Approval</p>
                    <p class="text-sm text-success">Verified</p>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END VERIFICATION STATUS --}}

      {{-- ACCOUNT ACTIONS --}}
      {{-- <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Account Actions</h2>
          <div class="flex flex-col gap-3">
            <button type="button"
              class="btn btn-ghost text-error text-base px-0 min-h-fit h-fit hover:bg-transparent w-fit">
              <i class="fa-solid fa-trash-can mr-1"></i>
              Remove Verification
            </button>
            <button type="button"
              class="btn btn-ghost text-error text-base px-0 min-h-fit h-fit hover:bg-transparent w-fit">
              <i class="fa-solid fa-ban mr-1"></i>
              Deactive Account
            </button>
          </div>
        </div>
      </div> --}}
      {{-- END ACCOUNT ACTIONS --}}

    </div>

    <div class="col-span-3">
      {{-- VIDEO --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Questionnaire Results</h2>
          <div class="w-full">
            <div class="flex flex-row justify-between items-center w-full">
              <p class="text-sm">Work Life Balance</p>
              <p class="text-xs text-gray-400 text-end">4.5 / 5</p>
            </div>
            <progress class="progress progress-info w-full" value="90" max="100"></progress>
          </div>
          <div class="w-full">
            <div class="flex flex-row justify-between items-center w-full">
              <p class="text-sm">Innovation</p>
              <p class="text-xs text-gray-400 text-end">5 / 5</p>
            </div>
            <progress class="progress progress-info w-full" value="100" max="100"></progress>
          </div>
          <div class="w-full">
            <div class="flex flex-row justify-between items-center w-full">
              <p class="text-sm">Inclusivity</p>
              <p class="text-xs text-gray-400 text-end">4 / 5</p>
            </div>
            <progress class="progress progress-info w-full" value="80" max="100"></progress>
          </div>
        </div>
      </div>
      {{-- END VIDEO --}}
    </div>

    <dialog id="showPersonalInformationModal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Personal Information</h3>
        <form action="{{ route('recruiters.update', $detail) }}" method="post">
          @csrf
          @method('PUT')
          <div class="space-y-3">
            <input type="hidden" value="personal_information" name="type_update" />
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Size</span>
              </div>
              <input type="number" name="employee_count" placeholder="size of employees"
                class="input input-bordered w-full input-sm"
                value="{{ old('employee_count', $detail->profileCompany?->employee_count ?? 0) }}" required />
              @if ($errors->has('employee_count'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('employee_count') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Province</span>
              </div>
              <select class="select select-bordered select-sm w-full" name="province_id" id="province_id" required>
                <option disabled selected>~ Select Province ~</option>
                @foreach ($provinces as $province)
                  <option value="{{ $province->id }}"
                    {{ $province->id == old('province', $detail->profileCompany?->province_id) ? 'selected' : '' }}>
                    {{ $province->name }}
                  </option>
                @endforeach
              </select>
              @if ($errors->has('province_id'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('province_id') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">City</span>
              </div>
              <select class="select select-bordered select-sm w-full" name="city_id" id="city_id" required>
                <option disabled selected>~ Select City ~</option>
              </select>
              @if ($errors->has('city_id'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('city_id') }}</span>
                </div>
              @endif
            </label>
            <div class="flex gap-3 items-center">
              <button class="btn btn-sm btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </dialog>

    <dialog id="showContactInformationModal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Contact Information</h3>
        <form action="{{ route('recruiters.update', $detail) }}" method="post">
          @csrf
          @method('PUT')
          <input type="hidden" value="contact_information" name="type_update" />
          <div class="space-y-3">
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Size</span>
              </div>
              <input type="text" name="website" placeholder="Website" class="input input-bordered w-full input-sm"
                value="{{ old('website', $detail->profileCompany?->website ?? '') }}" required />
              @if ($errors->has('website'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('website') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Email</span>
              </div>
              <input type="email" name="email" placeholder="Email" class="input input-bordered w-full input-sm"
                value="{{ old('email', $detail->email ?? '') }}" required />
              @if ($errors->has('email'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('email') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Phone</span>
              </div>
              <input type="tel" name="phone" placeholder="Phone" class="input input-bordered w-full input-sm"
                value="{{ old('phone', $detail->profileCompany?->phone ?? '') }}" required />
              @if ($errors->has('phone'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('phone') }}</span>
                </div>
              @endif
            </label>

            <div class="flex gap-3 items-center">
              <button class="btn btn-sm btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </dialog>
  </div>
@endsection

@push('script')
  <script>
    document.getElementById('editInformationBtn').addEventListener('click', async function(event) {
      const url = @json(route('city', ['id' => '_id']));
      const province_id = @json($detail->profileCompany?->province_id);
      const res = await fetch(url.replace("_id", province_id));
      const {
        data
      } = await res.json();
      const city = document.getElementById('city_id');
      city.options.length = 0;
      city.append(new Option('~ Select City ~', "", true, true))

      const city_id = @json($detail->profileCompany?->city_id);
      data.forEach(item => {
        city.append(new Option(item.name, item.id, item.id == city_id, item.id == city_id))
      });
      document.getElementById('showPersonalInformationModal').showModal();
    });

    document.getElementById('province_id').addEventListener('change', async function(event) {
      if (event.target.value) {
        const url = @json(route('city', ['id' => '_id']));
        const res = await fetch(url.replace("_id", event.target.value));
        const {
          data
        } = await res.json();
        const city = document.getElementById('city_id');
        city.options.length = 0;
        city.append(new Option('~ Select City ~', "", true, true))
        data.forEach(item => {
          city.append(new Option(item.name, item.id, false, false))
        });
      }
    });

    document.getElementById('contactInformationBtn').addEventListener('click', function(event) {
      document.getElementById('showContactInformationModal').showModal();
    });
  </script>
@endpush
