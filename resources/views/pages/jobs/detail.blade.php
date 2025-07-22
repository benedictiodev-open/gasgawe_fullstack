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
            <h2 class="card-title">{{ $job->position }}</h2>
            <p class="text-gray-400 text-sm">{{ $job->getCompanyNameAttribute() }}</p>
          </div>

          <div>
            <div
              class="badge {{ $job->status == 'active' ? 'badge-success' : ($job->status == 'pending' ? 'bg-gray-400' : 'bg-error') }} rounded-md p-3 text-white font-normal capitalize">
              {{ $job->status }}</div>
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
            <button type="button" id="editJobInformationBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button>
          </div>

          <div>
            <table class="border-spacing-y-3 border-separate">
              <tr>
                <td>Company</td>
                <th class="text-left pl-5">{{ $job->getCompanyNameAttribute() }}</th>
              </tr>
              <tr>
                <td>Location</td>
                <th class="text-left pl-5">{{ $job->getFullLocationAttribute() }}</th>
              </tr>
              <tr>
                <td>Posted By</td>
                <th class="text-left pl-5">{{ '!!!' }}</th>
              </tr>
              <tr>
                <td>Post Date</td>
                <th class="text-left pl-5">{{ Carbon\Carbon::parse($job->created_at)->format('d F Y') }}</th>
              </tr>
              <tr>
                <td>Deadline</td>
                <th class="text-left pl-5">{{ '!!!' }}</th>
              </tr>
              <tr>
                <td>Job Type</td>
                <th class="text-left pl-5">{{ $job->employmentType->name }}</th>
              </tr>
              <tr>
                <td>Position</td>
                <th class="text-left pl-5">{{ $job->position }}</th>
              </tr>
              <tr>
                <td>Salary</td>
                <th class="text-left pl-5">{{ $job->expectedSalary->name }}</th>
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
            <h2 class="card-title">Job Description</h2>
            <button type="button" id="editJobDescriptionBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button>
          </div>
          <div class="text-gray-400 whitespace-pre-line prose">
            {{ $job->description }}
          </div>
        </div>
      </div>
      {{-- END JOB DESCRIPTION --}}

      {{-- QUALIFICATIONS AND REQUIREMENTS --}}
      <div class="card bg-base-100 w-full shadow-xl">
        <div class="card-body p-5">
          <div class="flex flex-row items-center justify-between">
            <h2 class="card-title">Qualifications and Requirements</h2>
            <button type="button" id="editJobQualificationBtn"
              class="btn btn-sm text-gray-400 bg-base-100 space-x-0.5 shadow-lg">
              <i class="fa-solid fa-pen"></i>
              <span>Edit Information</span>
              <i class="fa-solid fa-caret-down"></i>
            </button>
          </div>
          <div class="text-gray-400 whitespace-pre-line prose">
            {{ $job->qualification }}
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
                <th class="text-left pl-5">{{ $job->apply->count() }}</th>
              </tr>
              <tr>
                <td>ID</td>
                <th class="text-left pl-5">{{ $job->id }}</th>
              </tr>
            </table>
          </div>
        </div>
        {{-- END APPLICANTS INFORMATION --}}
      </div>
    </div>

    <dialog id="showJobInformationModal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Job Information</h3>
        <form action="{{ route('jobs.update', $job) }}" method="post">
          @csrf
          @method('PUT')
          <input type="hidden" value="job_information" name="type_update" />
          <div class="space-y-3">
            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Company</span>
              </div>
              <input type="text" name="company_name" placeholder="Company Name"
                class="input input-bordered w-full input-sm"
                value="{{ old('company_name', $job->getCompanyNameAttribute() ?? '') }}" required />
              @if ($errors->has('company_name'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('company_name') }}</span>
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
                    {{ $province->id == old('province', $job->province_id) ? 'selected' : '' }}>
                    {{ $province->name }}
                  </option>
                @endforeach
              </select>
              @if ($errors->has('province'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('province') }}</span>
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
              @if ($errors->has('city'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('city') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Posted By</span>
              </div>
              <input type="text" name="posted_by" placeholder="Posted By"
                class="input input-bordered w-full input-sm" value="{{ old('posted_by', '') }}" required />
              @if ($errors->has('posted_by'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('posted_by') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Posted Date</span>
              </div>
              <input type="datetime-local" name="created_at" placeholder="Posted Date"
                class="input input-bordered w-full input-sm" value="{{ old('created_at', $job->created_at) }}"
                required />
              @if ($errors->has('created_at'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('created_at') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Deadline</span>
              </div>
              <input type="datetime-local" name="deadlined_at" placeholder="Deadline"
                class="input input-bordered w-full input-sm"
                value="{{ old('deadlined_at', $job?->deadlined_at ?? '') }}" required />
              @if ($errors->has('deadlined_at'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('deadlined_at') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Job Type</span>
              </div>
              <select class="select select-bordered select-sm w-full" name="employee_type_id" id="employee_type_id"
                required>
                <option disabled selected>~ Select Job Type ~</option>
                @foreach ($employee_types as $employee_type)
                  <option value="{{ $employee_type->id }}"
                    {{ $employee_type->id == old('employee_type_id', $job->employee_type_id) ? 'selected' : '' }}>
                    {{ $employee_type->name }}
                  </option>
                @endforeach
              </select>
              @if ($errors->has('employee_type_id'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('province') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Position</span>
              </div>
              <input type="text" name="position" placeholder="Position"
                class="input input-bordered w-full input-sm" value="{{ old('position', $job->position ?? '') }}"
                required />
              @if ($errors->has('position'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('position') }}</span>
                </div>
              @endif
            </label>

            <label class="form-control w-full">
              <div class="label">
                <span class="label-text">Salary</span>
              </div>
              <select class="select select-bordered select-sm w-full" name="expected_salary_id" id="expected_salary_id"
                required>
                <option disabled selected>~ Select Salary ~</option>
                @foreach ($expected_salaries as $expected_salary)
                  <option value="{{ $expected_salary->id }}"
                    {{ $expected_salary->id == old('expected_salary_id', $job->expected_salary_id) ? 'selected' : '' }}>
                    {{ $expected_salary->name }}
                  </option>
                @endforeach
              </select>
              @if ($errors->has('expected_salary_id'))
                <div class="label">
                  <span class="label-text-alt">{{ $errors->first('province') }}</span>
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

    <dialog id="showJobDescriptionModal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Job Description</h3>
        <form action="{{ route('jobs.update', $job) }}" method="post">
          @csrf
          @method('PUT')
          <input type="hidden" value="job_description" name="type_update" />
          <div class="space-y-3">


            <label class="form-control w-full">
              <textarea class="textarea textarea-bordered h-24 w-full textarea-sm" placeholder="Job Description" name="description"
                id="description">{{ $job->description }}</textarea>
              @if ($errors->has('description'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('description') }}</span>
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

    <dialog id="showJobQualificationModal" class="modal">
      <div class="modal-box">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold">Job Qualifications and Requirements</h3>
        <form action="{{ route('jobs.update', $job) }}" method="post">
          @csrf
          @method('PUT')
          <input type="hidden" value="job_qualification" name="type_update" />
          <div class="space-y-3">


            <label class="form-control w-full">
              <textarea class="textarea textarea-bordered h-24 w-full textarea-sm" placeholder="Job Qualifications and Requirements"
                name="qualification" id="qualification">{{ $job->qualification }}</textarea>
              @if ($errors->has('qualification'))
                <div class="label">
                  <span class="label-text-alt text-error">{{ $errors->first('qualification') }}</span>
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
    document.getElementById('editJobInformationBtn').addEventListener('click', async function(event) {
      const url = @json(route('city', ['id' => '_id']));
      const province_id = @json($job->province_id);
      const res = await fetch(url.replace("_id", province_id));
      const {
        data
      } = await res.json();

      const city = document.getElementById('city_id');
      city.options.length = 0;
      city.append(new Option('~ Select City ~', "", true, true))

      const city_id = @json($job->city_id);
      data.forEach(item => {
        city.append(new Option(item.name, item.id, item.id == city_id, item.id == city_id))
      });
      document.getElementById('showJobInformationModal').showModal();
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

    document.getElementById('editJobDescriptionBtn').addEventListener('click', function(event) {
      document.getElementById('showJobDescriptionModal').showModal();
    });

    document.getElementById('editJobQualificationBtn').addEventListener('click', function(event) {
      document.getElementById('showJobQualificationModal').showModal();
    });
  </script>
@endpush
