@if (session('success') || session('failed'))
  <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-6 right-6 z-50 w-full max-w-sm">
    <div
      class="alert shadow-lg rounded-lg bg-white border-2 p-4 pl-5 pr-6 flex items-start space-x-3
                {{ session('success') ? 'border-green-500' : 'border-red-500' }}">
      <div class="flex-1">
        <h3 class="text-sm font-semibold {{ session('success') ? 'text-green-600' : 'text-red-600' }}">
          {{ session('success') ? 'Success!' : 'Failed!' }}
        </h3>
        <p class="text-sm text-gray-700 mt-1">
          {{ session('success') ?? session('failed') }}
        </p>
      </div>
      <button @click="show = false" class="text-gray-400 hover:text-gray-600 text-lg leading-none">
        &times;
      </button>
    </div>
  </div>
@endif
