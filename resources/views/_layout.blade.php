<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('style')
  <title>Gas Gawe | @stack('title', 'Dashboard')</title>
</head>

<body class=" min-h-screen bg-[#e9f4fa]">
  <x-layout.header />
  <main class="container py-5">
    @yield('main')
  </main>
  <x-layout.toast />
</body>
{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
@stack('script')

</html>
