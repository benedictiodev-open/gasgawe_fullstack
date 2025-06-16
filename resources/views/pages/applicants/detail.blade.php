@extends('_layout')

@push('title')
  Applicant Detail
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
    </div>
    {{-- END SEARCH & FILTER --}}
  </div>
@endsection
