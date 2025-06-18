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
                <div class="bg-info text-white rounded-md h-16 w-16">
                  <span class="text-4xl">T</span>
                </div>
              </div>
            </div>

            <div>
              <h2 class="card-title">Tech Inovation Inc.</h2>
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
                <td>Company</td>
                <th class="text-left pl-5">Tech Inovation Inc.</th>
              </tr>
              <tr>
                <td>Location</td>
                <th class="text-left pl-5">Jakarta, Indonesia</th>
              </tr>
              <tr>
                <td>Size</td>
                <th class="text-left pl-5">50-200 Employees</th>
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
          <div class="flex flex-row items-center justify-between">
            <h2 class="card-title">Contact Information</h2>
            <button type="button" class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button>
          </div>
          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Website</td>
                <th class="text-left pl-5">https://techinovationinc.com</th>
              </tr>
              <tr>
                <td>Email</td>
                <th class="text-left pl-5">hr@techinovationinc.com</th>
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
  </div>
@endsection
