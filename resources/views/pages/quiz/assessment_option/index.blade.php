@extends('_layout')

@push('title')
  Options
@endpush

@section('main')
  <div x-data="optionModalHandler()" x-init>
    <div class="grid grid-cols-12 items-center gap-5">
      {{-- SEARCH & FILTER --}}
      <div class="col-span-12 flex flex-row items-center gap-2">
        <div class="flex-1">
          <div x-data="searchForm()">
            <form @submit.prevent="submitForm">
              <label class="input input-bordered flex items-center gap-2">
                <input type="text" class="grow" placeholder="Search" x-model="query" @keydown.enter="submitForm"
                  :value="query" aria-label="Search" />
                <div class="flex space-x-4">
                  <template x-if="query">
                    <div class="cursor-pointer ml-2" @click="clearSearch">
                      <i class="fa-solid fa-times-circle"></i>
                    </div>
                  </template>
                  <div class="cursor-pointer" @click="submitForm">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </div>
                </div>
              </label>
            </form>
          </div>
        </div>
        <div class="flex-none">
          <!-- Trigger button -->
          <button class="btn btn-primary text-base-300 font-bold p-3 rounded-lg w-36" @click="openCreateModal">
            <p class="text-center">Create</p>
          </button>
        </div>
      </div>
      {{-- END SEARCH & FILTER --}}

      {{-- TABLE --}}
      <div class="col-span-12">
        <div class="overflow-x-auto">
          <table class="table border-separate border-spacing-y-2">
            <thead>
              <tr>
                <th>Text</th>
                <th>Score</th>
                <th>Score Conversion</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($options as $item)
                <tr class="rounded-xl bg-base-100 mb-2">
                  <th class="first:rounded-l-xl">{{ $item->text }}</th>
                  <td>{{ $item->score_value }}</td>
                  <td>{{ $item->score_conversion }}</td>
                  <th class="last:rounded-r-xl">
                    <div class="flex flex-row items-center gap-4">
                      <button class="cursor-pointer" @click="openEditModal({{ $item }})">
                        <i class="fa-solid fa-pen text-lg text-info"></i>
                      </button>
                      <button class="cursor-pointer" @click="openDeleteModal({{ $item->id }})">
                        <i class="fa-solid fa-trash text-lg text-error"></i>
                      </button>
                    </div>
                  </th>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="flex justify-end">
            {{ $options->links() }}
          </div>
        </div>
      </div>
      {{-- END TABLE --}}
    </div>

    {{-- MODAL --}}
    @include('pages.quiz.assessment_option.form')
  </div>
@endsection


@push('script')
  <script>
    function searchForm() {
      return {
        query: '',

        init() {
          const urlParams = new URLSearchParams(window.location.search);
          this.query = urlParams.get('search') || '';
        },

        submitForm() {
          if (this.query) {
            window.location.href = window.location.pathname + '?search=' + this.query;
          } else {
            window.location.href = window.location.pathname;
          }
        },

        clearSearch() {
          window.history.pushState({}, '', window.location.pathname);
          this.query = '';
        }
      };
    }

    function optionModalHandler() {
      return {
        deleteOptionId: null,

        openCreateModal() {
          const dialog = document.getElementById('showCreateOptionModal');
          if (dialog) {
            // Clear the form manually if needed
            dialog.querySelector('form').reset();
            dialog.querySelector('form').action = `{{ route('quiz.options.store') }}`;
            const hiddenMethod = dialog.querySelector('form').querySelector('input[name="_method"]');
            if (hiddenMethod) {
              hiddenMethod.value = 'POST'
            }
            dialog.showModal();
          }
        },

        openEditModal(option) {
          const dialog = document.getElementById('showCreateOptionModal');
          if (dialog) {
            // Update form action to PUT
            const form = dialog.querySelector('form');
            form.action = `{{ route('quiz.options.update', ':id') }}`.replace(':id', option.id);

            // Add method spoofing input for PUT
            const hiddenMethod = form.querySelector('input[name="_method"]');
            if (!hiddenMethod) {
              const methodInput = document.createElement('input');
              methodInput.type = 'hidden';
              methodInput.name = '_method';
              methodInput.value = 'PUT';
              form.appendChild(methodInput);
            } else {
              hiddenMethod.value = 'PUT';
            }

            // Set values
            form.querySelector('[name="assessment_question_id"]').value = option.assessment_question_id;
            form.querySelector('[name="text"]').value = option.text;
            form.querySelector('[name="score_value"]').value = option.score_value;
            form.querySelector('[name="score_conversion"]').value = option.score_conversion;

            dialog.showModal();
          }
        },

        openDeleteModal(id) {
          this.deleteOptionId = id;
          const dialog = document.getElementById('showDeleteOptionModal');
          dialog?.showModal();
        }
      }
    }
  </script>
@endpush
