@extends('_layout')

@push('title')
  Applicant Detail
@endpush

@section('main')
  <div class="grid grid-cols-12 gap-5">
    {{-- NAME --}}
    <div class="col-span-12 flex flex-row items-center gap-2">
      <div class="card bg-base-100 shadow-xl w-full">
        <div class="card-body p-5 flex flex-row justify-between">
          <div class="flex flex-row items-center gap-5">
            <div class="avatar">
              <div class="rounded-md h-16 w-16">
                {{-- @dd($applicant) --}}
                @if ($applicant->profileApplicant?->file_profile_image)
                    <img src="{{ asset('storage/' . $applicant->profileApplicant->file_profile_image) }}"
                      alt="Profile Image" />
                  @else
                    <div class=" h-16 w-16 bg-info flex justify-center items-center text-white text-3xl font-bold">
                      {{ strtoupper(substr($applicant->profileApplicant?->first_name ?? $applicant->email, 0, 1)) }}
                    </div>
                  @endif
              </div>
            </div>

            <div>
              <h2 class="card-title">{{ $applicant->profileApplicant?->getFullNameAttribute() ?? $applicant->email }}</h2>
              <p class="text-gray-400 text-sm">Joined {{ $applicant->created_at->format('d F Y') }}</p>
            </div>
          </div>

          <div>
            <div class="badge {{ $applicant->profileApplicant?->is_active ? 'badge-success' : 'badge-error' }} rounded-md p-3 text-white font-normal">{{ $applicant->profileApplicant?->is_active ? 'Active' : 'Inactive' }}</div>
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
            {{-- <button type="button" id="personalInformationBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button> --}}
          </div>

          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Full Name</td>
                <th class="text-left pl-5">{{ $applicant->profileApplicant?->getFullNameAttribute() ?? $applicant->email }}</th>
              </tr>
              <tr>
                <td>Location</td>
                <th class="text-left pl-5">{{ $applicant->profileApplicant?->getFullLocationAttribute() ?? '-' }}</th>
              </tr>
              <tr>
                <td>Account</td>
                <th class="text-left pl-5">{{ $applicant->profileApplicant?->is_active ? 'Active' : 'Inactive' }}</th>
              </tr>
              <tr>
                <td>Verification Status</td>
                <th class="text-left pl-5 {{ $applicant->profileApplicant?->is_verified ? 'text-success' : 'text-error' }}">
                  <i class="fa-solid {{ $applicant->profileApplicant?->is_verified ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-0.5"></i>
                  {{ $applicant->profileApplicant?->is_verified ? 'Verified' : 'Not Verified' }}
                </th>
              </tr>
              <tr>
                <td>Registration Date</td>
                <th class="text-left pl-5">{{ $applicant->created_at->format('d F Y') }}</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END PERSONAL INFORMATION --}}

      {{-- CONTACT INFORMATION --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Contact Information</h2>

          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Email</td>
                <th class="text-left pl-5">{{ $applicant->email }}</th>
              </tr>
              <tr>
                <td>Phone</td>
                <th class="text-left pl-5">{{ $applicant->profileApplicant?->phone_number ?? '-' }}</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END CONTACT INFORMATION --}}

      {{-- EXPERIENCE AND SKILLS --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Experience and Skills</h2>

          <div class="flex flex-row items-center gap-4">
            <div class="avatar placeholder">
              <div class="bg-info text-white w-12 rounded-full">
                <span>XP</span>
              </div>
            </div>
            <div>
              <p class="font-medium">{{ $applicant->exp }} Experiences Points</p>
              <p class="text-sm font-medium">Based on skill assessment and job performance</p>
            </div>
          </div>
        </div>
      </div>
      {{-- END EXPERIENCE AND SKILLS --}}

      {{-- BADGES AND ACHIEVMENT --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Badges and Achievment</h2>

          <div class="flex flex-row items-center gap-4">
            <div class="badge badge-info rounded-md p-3 text-white font-normal align-bottom h-20">Active</div>
            <div class="badge badge-info rounded-md p-3 text-white font-normal align-bottom h-20">Expert</div>
          </div>
        </div>
      </div>
      {{-- END BADGES AND ACHIEVMENT --}}

      {{-- ACCOUNT ACTIONS --}}
      {{-- <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Account Actions</h2>
          <div class="flex flex-col gap-3">
            <button type="button" id="verified_account"
              class="btn btn-ghost {{ $applicant->profileApplicant->is_verified ? 'text-error' : 'text-success' }} text-base px-0 min-h-fit h-fit hover:bg-transparent w-fit">
              <i class="fa-solid {{ $applicant->profileApplicant->is_verified ? 'fa-trash-can' : 'fa-circle-check' }} mr-1"></i>
                {{ $applicant->profileApplicant->is_verified ? 'Remove Verification' : 'Verification' }}
            </button>
            <button type="button" id="acctive_account"
              class="btn btn-ghost {{ $applicant->profileApplicant->is_active ? 'text-error' : 'text-success' }} text-base px-0 min-h-fit h-fit hover:bg-transparent w-fit">
              <i class="fa-solid {{ $applicant->profileApplicant->is_active ? 'fa-ban' : 'fa-circle-check' }} mr-1"></i>
              {{ $applicant->profileApplicant->is_active ? 'Deactive Account' : 'Active Account' }}
            </button>
          </div>
        </div>
      </div> --}}
      {{-- END ACCOUNT ACTIONS --}}

    </div>

    <div class="col-span-3">
      {{-- VIDEO --}}
      <div class="card bg-black text-neutral-content w-full h-2/3">
        <div class="card-body items-center justify-center">
          <i class="fa-solid fa-play text-lg text-base-100"></i>
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
        <form action="{{ route('applicants.update', $applicant) }}" method="post">
          @csrf
          @method('PUT')
          <div class="space-y-3">
            <input type="hidden" value="personal_information" name="type_update" />
            {{-- <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Size</span>
              </div>
              <input type="number" name="employee_count" placeholder="size of employees"
                class="input input-bordered w-full input-sm" value="{{ old('employee_count', $applicant->id ?? 0) }}"
                required />
              @if ($errors->has('employee_count'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('employee_count') }}</span>
                </div>
              @endif
            </label> --}}
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
    // document.getElementById('personalInformationBtn').addEventListener('click', function(event) {
    //   document.getElementById('showPersonalInformationModal').showModal();
    // });
  </script>
@endpush
