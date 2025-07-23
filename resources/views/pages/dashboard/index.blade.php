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
          <div class="h-14 w-14 p-1 flex items-center justify-center bg-white rounded-full">
            <img src="{{ asset('gasgawe-logo.png') }}" alt="">
          </div>
          <div class="text-center">Welcome to Your Admin Dashboard</div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-center gap-1">
          <i class="fa-solid fa-user-plus text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">{{ $applicant }}</h2>
            <p class="">Applicants</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-center gap-1">
          <i class="fa-solid fa-user-tie text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">{{ $recruiter }}</h2>
            <p class="">Recruiters</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-center gap-1">
          <i class="fa-solid fa-suitcase text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">{{ $job }}</h2>
            <p class="">Job Posted</p>
          </div>
        </div>
      </div>

      <div class="col-span-1 card bg-base-100 h-full">
        <div class="card-body flex flex-col items-center justify-center gap-1">
          <i class="fa-solid fa-suitcase text-3xl"></i>
          <div class="flex flex-col items-center justify-center">
            <h2 class="card-title">{{ $job_active }}</h2>
            <p class="">Job Active</p>
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
      <div class="card bg-base-100 h-56"></div>
    </div>
    {{-- END ACTIVITY --}}

    {{-- TOP CHART --}}
    <div class="col-span-12 space-y-4">
      <h2 class="font-bold text-lg">Top Charts</h2>
      <div class="flex flex-row items-center gap-2">
        <button id="button_top_chart-applicant" onclick="change_top_chart('applicant')" class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-primary text-primary-content">Top
          Applicants</button>
        <button id="button_top_chart-recruiter" onclick="change_top_chart('recruiter')" class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-base-100">Top Recruiters</button>
        <button id="button_top_chart-job" onclick="change_top_chart('job')" class="btn btn-ghost rounded-full px-6 border border-gray-200 bg-base-100">Top Jobs</button>
      </div>
      <div class="grid grid-cols-3 gap-4" id="top_chart_body"></div>
    </div>
    {{-- END TOP CHART --}}
  </div>
@endsection

@push('script')
  <script>
    let selected_now = 'applicant';
    $(document).ready(function() {
      get_top_chart_dashboard(selected_now);
    });

    const change_top_chart = (selected) => {
      if (selected_now != selected) {
        $(`#button_top_chart-${selected_now}`).removeClass('bg-primary text-primary-content').addClass('bg-base-100');
        $(`#button_top_chart-${selected}`).addClass('bg-primary text-primary-content');
        get_top_chart_dashboard(selected);
        selected_now = selected;
      }
    };

    const get_top_chart_dashboard = (type) => {
      let url = '{{ route("top_chart_dashboard") }}' + `?type=${type}`
      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
          let top_chart_body = '';
          response.data.forEach((item, index) => {
            let image = `
              <div class="h-14 w-14 flex items-center justify-center bg-base-100 rounded-md font-bold text-lg">
                ${item.name.charAt(0).toUpperCase()}
              </div>
            `;

            top_chart_body += `
              <div class="col-span-1 flex flex-row items-center gap-2">
                <p>${index + 1}</p>
                ${image}
                <div>
                  <p class="font-medium">${item.name}</p>
                  <p class="text-sm text-gray-500">${item.description}</p>
                </div>
              </div>
            `;
          });
          $('#top_chart_body').html(top_chart_body);
        },
        error: function(xhr, status, error) {
          console.error('Terjadi kesalahan:', error);
        }
      });
    };
  </script>
@endpush