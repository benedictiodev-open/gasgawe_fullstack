@extends('_layout')

@push('title')
  Jobs Detail
@endpush

@section('main')
  <div class="grid grid-cols-12 gap-5">
    {{-- NAME --}}
    <div class="col-span-12 flex flex-row items-center gap-2">
      <div class="card bg-base-100 shadow-xl w-full">
        <div class="card-body p-5 flex flex-row justify-between">
          <div>
            <h2 class="card-title">Senior Software Engineer</h2>
            <p class="text-gray-400 text-sm">Tech Innovation Inc.</p>
          </div>

          <div>
            <div class="badge badge-success rounded-md p-3 text-white font-normal">Active</div>
          </div>
        </div>
      </div>
    </div>
    {{-- END NAME --}}

    <div class="col-span-9 space-y-3">
      {{-- JOB INFORMATION --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <div class="flex flex-row items-center justify-between">
            <h2 class="card-title">Job Information</h2>
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
                <td>Posted By</td>
                <th class="text-left pl-5">HR Manager</th>
              </tr>
              <tr>
                <td>Post Date</td>
                <th class="text-left pl-5">16 Juni 2025</th>
              </tr>
              <tr>
                <td>Deadline</td>
                <th class="text-left pl-5">16 November 2025</th>
              </tr>
              <tr>
                <td>Job Type</td>
                <th class="text-left pl-5">Full-Time</th>
              </tr>
              <tr>
                <td>Position</td>
                <th class="text-left pl-5">Senior Software Engineer</th>
              </tr>
              <tr>
                <td>Salary</td>
                <th class="text-left pl-5">Rp 20.000.000 - Rp 30.000.000</th>
              </tr>
            </table>
          </div>
        </div>
      </div>
      {{-- END JOB INFORMATION --}}

      {{-- JOB DESCRIPTION --}}
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
            <p class="text-justify text-gray-400">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempora, totam
              ipsa repellat excepturi et quos sint laudantium? Nam sit ducimus quidem illum impedit aspernatur autem at
              voluptate, in dolore veniam quo fugiat nemo sunt est assumenda eius eos quasi? Iste debitis tempora eum
              illum, consectetur soluta quos est quia minus omnis minima unde nesciunt, maxime possimus provident sunt
              ipsam vel sequi officia. Officia consequuntur tempore corporis est voluptates ut obcaecati quisquam neque a,
              sunt fugit. Cum praesentium expedita est eos provident dolore voluptates animi fugiat. Commodi quidem
              incidunt consequatur culpa mollitia sed blanditiis expedita quo odio possimus beatae aliquam quaerat ut
              officia itaque eveniet odit adipisci labore, iusto, porro aperiam dolores dicta animi! Consectetur
              exercitationem tenetur nostrum cupiditate molestiae, est veniam quibusdam perferendis ab, fugiat quas
              veritatis animi delectus, enim laboriosam. Quod similique iste nulla ratione dolorem molestias numquam,
              iusto aspernatur voluptatibus ex, quidem saepe? Magni error reiciendis suscipit ex, officia ea fuga id
              praesentium dicta consequuntur, architecto sequi autem recusandae quas iste, at qui blanditiis fugiat
              similique ut! Quibusdam, quisquam nam. Nemo necessitatibus dolorem ad nesciunt nam sit alias, vel, ipsum
              corporis neque quaerat molestiae sequi a. Reiciendis, eum reprehenderit. Ullam illo unde, mollitia minima
              dolorum dolorem. Natus, alias!</p>
          </div>
        </div>
      </div>
      {{-- END JOB DESCRIPTION --}}

      {{-- QUALIFICATIONS AND REQUIREMENTS --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Qualifications and Requirements</h2>
          <div>
            <p class="text-lg text-gray-400 align-middle">
              <i class="fa-solid fa-circle-check text-success mr-2"></i>
              Minimum 3 years of experience in software engineer
            </p>
            <p class="text-lg text-gray-400 align-middle">
              <i class="fa-solid fa-circle-check text-success mr-2"></i>
              Strong profiency in Go and Ruby on Rails
            </p>
            <p class="text-lg text-gray-400 align-middle">
              <i class="fa-solid fa-circle-check text-success mr-2"></i>
              Experience with state management
            </p>
            <p class="text-lg text-gray-400 align-middle">
              <i class="fa-solid fa-circle-check text-success mr-2"></i>
              Familiarity with RESTful APIs and JSON parsing
            </p>
            <p class="text-lg text-gray-400 align-middle">
              <i class="fa-solid fa-circle-check text-success mr-2"></i>
              Understanding the web developer and mobile development cycle
            </p>
          </div>
        </div>
      </div>
      {{-- END QUALIFICATIONS AND REQUIREMENTS --}}

      {{-- JOB ACTIONS --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Job Actions</h2>

          <button type="button"
            class="btn btn-ghost text-error text-base px-0 min-h-fit h-fit hover:bg-transparent w-fit">
            <i class="fa-solid fa-ban mr-1"></i>
            Close Job
          </button>
        </div>
      </div>
      {{-- END JOB ACTIONS --}}

    </div>

    <div class="col-span-3">
      {{-- APPLICANTS INFORMATION --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <h2 class="card-title">Applicants Information</h2>
          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Total Applicants</td>
                <th class="text-left pl-5">120</th>
              </tr>
              <tr>
                <td>ID</td>
                <th class="text-left pl-5">1</th>
              </tr>
            </table>
          </div>
        </div>
        {{-- END APPLICANTS INFORMATION --}}
      </div>
    </div>
  @endsection
