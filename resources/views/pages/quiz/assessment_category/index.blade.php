@extends('_layout')

@push('title')
  Categories
@endpush

@section('main')
  <div x-data="categoryModalHandler()" x-init>
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
                <th>Name</th>
                <th>Weight</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $item)
                <tr class="rounded-xl bg-base-100 mb-2">
                  <th class="first:rounded-l-xl">{{ $item->name }}</th>
                  <td>{{ $item->weight }}</td>
                  <td>{{ $item->description }}</td>
                  <th class="last:rounded-r-xl">
                    <div class="flex flex-row items-center gap-4">
                      <a href="{{ route('quiz.questions.index', $item) }}" rel="noopener noreferrer">
                        <i class="fa-solid fa-circle-info text-lg text-gray-400"></i>
                      </a>
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
            {{ $categories->links() }}
          </div>
        </div>
      </div>
      {{-- END TABLE --}}
    </div>

    {{-- MODAL --}}
    @include('pages.quiz.assessment_category.form')
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

    function categoryModalHandler() {
      return {
        deleteCategoryId: null,

        openCreateModal() {
          const dialog = document.getElementById('showCreateCategoryModal');
          if (dialog) {
            // Clear the form manually if needed
            dialog.querySelector('form').reset();
            dialog.querySelector('form').action = `{{ route('quiz.categories.store') }}`;
            const hiddenMethod = dialog.querySelector('form').querySelector('input[name="_method"]');
            if (hiddenMethod) {
              hiddenMethod.value = 'POST';
            }
            dialog.showModal();
          }
        },

        openEditModal(category) {
          const dialog = document.getElementById('showCreateCategoryModal');
          if (dialog) {
            // Update form action to PUT
            const form = dialog.querySelector('form');
            form.action = `{{ route('quiz.categories.update', ':id') }}`.replace(':id', category.id);

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
            form.querySelector('[name="assessment_id"]').value = category.assessment_id;
            form.querySelector('[name="name"]').value = category.name;
            form.querySelector('[name="weight"]').value = category.weight;
            form.querySelector('[name="description"]').value = category.description;

            dialog.showModal();
          }
        },

        openDeleteModal(id) {
          this.deleteCategoryId = id;
          const dialog = document.getElementById('showDeleteCategoryModal');
          dialog?.showModal();
        }
      }
    }
  </script>
@endpush
