@extends('_layout')

@push('title')
  Jobs
@endpush

@section('main')
  <div class="grid grid-cols-12 gap-5">
    {{-- AVATAR --}}
    <div class="col-span-12 flex flex-col justify-center items-center gap-4 mb-5">
      <div class="avatar placeholder relative">
        <div class="bg-info text-info-content w-24 rounded-full">
          <span class="text-6xl">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
        </div>
        {{-- <div class="w-7 h-7 rounded-full bg-base-100 absolute bottom-0 right-1">
          <i class="fa-solid fa-pen text-xs"></i>
        </div> --}}
      </div>
      <div class="text-center">
        <p class="text-lg font-medium">Welcome, {{ Auth::user()->name }}</p>
        <p class="text-gray-400">Manage your personal information and password</p>
      </div>
    </div>
    {{-- END AVATAR --}}

    {{-- MANAGE INFORMATION --}}
    <div class="col-span-6">
      <div class="card bg-base-100 shadow-xl">
        <div class="card-body px-0 py-3">
          <div class="px-4">
            <h2 class="">Manage your profile information</h2>
          </div>
          <form action="{{ route('update_data_user') }}" method="POST">
            @csrf
            <div class="bg-gray-100 px-4 py-5 space-y-3">
              <div>
                <label class="form-control w-full">
                  <div class="label py-0 pb-0.5">
                    <span class="label-text">Full Name</span>
                  </div>
                  <label class="input input-bordered flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    <input name="fullname" type="text" class="grow" placeholder="Full Name" value="{{ Auth::user()->name }}" />
                  </label>
                </label>
              </div>
  
              <div>
                <label class="form-control w-full">
                  <div class="label py-0 pb-0.5">
                    <span class="label-text">Email</span>
                  </div>
                  <label class="input input-bordered flex items-center gap-2">
                    <i class="fa-solid fa-envelope"></i>
                    <input name="email" type="email" class="grow" placeholder="Email" value="{{ Auth::user()->email }}" />
                  </label>
                </label>
              </div>
            </div>
            <div class="card-actions justify-end px-4 mt-2">
              <button class="btn btn-info btn-sm text-white">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- END MANAGE INFORMATION --}}

    {{-- MANAGE PASSWORD --}}
    <div class="col-span-6">
      <div class="card bg-base-100 shadow-xl">
        <div class="card-body px-0 py-3">
          <div class="px-4">
            <h2 class="">Manage your password</h2>
          </div>
          <div class="bg-gray-100 px-4 py-5 space-y-3">
            <div>
              <label class="form-control w-full">
                <div class="label py-0 pb-0.5">
                  <span class="label-text">Current Password</span>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                  <i class="fa-solid fa-key"></i>
                  <input type="password" class="grow" placeholder="Current Password" />
                </label>
              </label>
            </div>

            <div>
              <label class="form-control w-full">
                <div class="label py-0 pb-0.5">
                  <span class="label-text">New Password</span>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                  <i class="fa-solid fa-key"></i>
                  <input type="password" class="grow" placeholder="New Password" />
                </label>
              </label>
            </div>

            <div>
              <label class="form-control w-full">
                <div class="label py-0 pb-0.5">
                  <span class="label-text">Confirm New Password</span>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                  <i class="fa-solid fa-key"></i>
                  <input type="password" class="grow" placeholder="Confirm New Password" />
                </label>
              </label>
            </div>
          </div>
          <div class="card-actions justify-end px-4">
            <button class="btn btn-info btn-sm text-white">Save</button>
          </div>
        </div>
      </div>
    </div>
    {{-- END MANAGE PASSWORD --}}
  </div>
@endsection
