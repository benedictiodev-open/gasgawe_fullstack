<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('style')
  <title>Gas Gawe | @stack('title', 'Dashboard')</title>
</head>

<body class="bg-base-300 min-h-screen">
  <x-layout.header />
  <main class="container py-5">
    @yield('main')
  </main>
</body>
@stack('script')

</html>
