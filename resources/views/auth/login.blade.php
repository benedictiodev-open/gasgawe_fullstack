<x-guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}" class="space-y-3">
    @csrf

    <!-- Email Address -->
    <div>
      <x-text-input label="Email" id="email" type="email" name="email" value="{{ old('email') }}" required
        autofocus autocomplete="email" error="{{ $errors->has('email') ? $errors->first('email') : false }}" />
    </div>

    <!-- Password -->
    <div class="">
      <x-text-input label="Password" id="password" type="password" name="password" required
        autocomplete="current-password" error="{{ $errors->has('password') ? $errors->first('password') : false }}" />
    </div>

    <!-- Remember Me -->
    {{-- <div class="block ">
      <label for="remember_me" class="inline-flex items-center">
        <input id="remember_me" type="checkbox"
          class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
      </label>
    </div> --}}

    <div class="flex items-center justify-end ">
      {{-- @if (Route::has('password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
      @endif --}}

      <x-primary-button class="ms-3 bg-info mt-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
