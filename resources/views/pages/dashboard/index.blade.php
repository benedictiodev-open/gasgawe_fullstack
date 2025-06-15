@extends('_layout')

@push('title')
  Dashboard
@endpush

@section('main')
  <div class="grid grid-cols-12 items-center gap-8">
    {{-- CARD --}}
    <div class="col-span-12 grid grid-cols-5 items-center gap-4">
      <div class="col-span-1 card bg-primary text-primary-content">
        <div class="card-body flex flex-col items-center justify-center gap-1">
          <div class="skeleton h-12 w-12"></div>
          <p>Welcome to Your Admin Dashboard</p>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-between gap-1">
          <i class="fa-solid fa-user-plus text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">1245</h2>
            <p class="">Applicants</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-between gap-1">
          <i class="fa-solid fa-user-tie text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">1245</h2>
            <p class="">Recruiters</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-between gap-1">
          <i class="fa-solid fa-suitcase text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">1245</h2>
            <p class="">Job Posted</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-between gap-1">
          <i class="fa-solid fa-user-plus text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">1245</h2>
            <p class="">Applicant</p>
          </div>
        </div>
      </div>
    </div>
    {{-- END CARD --}}

    {{-- ACTIVITY --}}
    <div class="col-span-12 space-y-2">
      <div class="flex flex-row items-center justify-between ">
        <div>
          <h2 class="font-bold text-lg">Activity Overview</h2>
          <p class="text-sm text-gray-400">Last 7 Days Statistics</p>
        </div>
        <div>
          <select class="select select-bordered rounded-full">
            <option disabled>Select Range</option>
            <option selected>Last 7 Days</option>
          </select>
        </div>
      </div>
      <div class="card bg-base-100 h-96"></div>
    </div>
    {{-- END ACTIVITY --}}

    {{-- TOP CHART --}}
    <div class="col-span-12 space-y-4">
      <h2 class="font-bold text-lg">Top Charts</h2>
      <div class="flex flex-row items-center gap-2">
        <button class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-primary text-primary-content">Top
          Applicants</button>
        <button class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-base-100">Top Recruiters</button>
        <button class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-base-100">Top Jobs</button>
      </div>
      <div class="grid grid-cols-3 gap-4">
        @foreach (range(1, 9) as $item)
          <div class="col-span-1 flex flex-row items-center gap-2">
            <p>{{ $item }}</p>
            <div class="h-14 w-14 bg-base-100 rounded-md">
            </div>
            <div>
              <p class="font-medium">Stevani Permana</p>
              <p class="text-sm text-gray-500">Level 100</p>
            </div>
          </div>
        @endforeach

      </div>
    </div>
    {{-- END TOP CHART --}}
  </div>
@endsection
