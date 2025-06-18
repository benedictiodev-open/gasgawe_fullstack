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
                <img src="https://img.daisyui.com/images/profile/demo/2@94.webp" alt="Avatar Tailwind CSS Component" />
              </div>
            </div>

            <div>
              <h2 class="card-title">John Doe</h2>
              <p class="text-gray-400 text-sm">Joined 16 April 2025</p>
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
            <button type="button" class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button>
          </div>

          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Full Name</td>
                <th class="text-left pl-5">John Doe</th>
              </tr>
              <tr>
                <td>Location</td>
                <th class="text-left pl-5">Jakarta, Indonesia</th>
              </tr>
              <tr>
                <td>Account</td>
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
                <th class="text-left pl-5">16 Juni 2025</th>
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
                <th class="text-left pl-5">johndoe@gmail.com</th>
              </tr>
              <tr>
                <td>Phone</td>
                <th class="text-left pl-5">+6281298128</th>
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
              <p class="font-medium">150 Experiences Points</p>
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
      <div class="card bg-base-100 w-full shadow-xl">
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
      </div>
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
  </div>
@endsection
