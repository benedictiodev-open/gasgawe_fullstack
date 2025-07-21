<nav class="w-full bg-white shadow-sm">
  <div class="max-w-screen-2xl mx-auto flex items-center justify-between px-4 py-3 rounded">
    <!-- Logo & Menu -->
    <div class="flex items-center gap-4">
      <img src="/logo.svg" alt="Logo" class="h-6" />
      <span class="text-lg font-bold text-primary">gasgawe!</span>

      <!-- Desktop Nav -->
      <ul class="hidden sm:flex gap-6 ml-8 text-sm font-medium items-center">
        <li>
          <a href="{{ route('dashboard') }}"
            class="border-b-2 pb-4 {{ str_contains(Request::route()->getName(), 'dashboard') ? 'border-primary text-primary' : 'border-transparent text-gray-800 hover:text-primary' }}">
            Dashboard
          </a>
        </li>
        <li>
          <a href="{{ route('applicants') }}"
            class="border-b-2 pb-4 {{ str_contains(Request::route()->getName(), 'applicants') ? 'border-primary text-primary' : 'border-transparent text-gray-800 hover:text-primary' }}">
            Applicants
          </a>
        </li>
        <li>
          <a href="{{ route('recruiters') }}"
            class="border-b-2 pb-4 {{ str_contains(Request::route()->getName(), 'recruiters') ? 'border-primary text-primary' : 'border-transparent text-gray-800 hover:text-primary' }}">
            Recruiters
          </a>
        </li>
        <li>
          <a href="{{ route('jobs') }}"
            class="border-b-2 pb-4 {{ str_contains(Request::route()->getName(), 'jobs') ? 'border-primary text-primary' : 'border-transparent text-gray-800 hover:text-primary' }}">
            Jobs
          </a>
        </li>

        <!-- Dropdown for Masterdata -->
        <li class="relative" x-data="{ open: false }">
          <button @click="open = !open" @click.away="open = false"
            class="flex items-center gap-1 {{ str_contains(Request::route()->getName(), 'masterdata') ? 'border-primary text-primary' : 'border-transparent text-gray-800 hover:text-primary' }}">
            Masterdata
            <svg class="w-4 h-4 mt-0.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
              stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown -->
          <ul x-show="open" x-transition
            class="absolute left-0 top-8 mt-2 w-48 bg-white rounded-md shadow-md z-50 py-2 text-sm">
            <li>
              <a href="{{ route('masterdata.skills.index') }}" class="block px-4 py-2 hover:bg-gray-100">Skills
              </a>
            </li>
            {{-- 
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Education</a>
            </li>
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Languages</a>
            </li>
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Industry</a>
            </li>
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Positions</a>
            </li>
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Companies</a>
            </li>
            <li>
              <a class="block px-4 py-2 hover:bg-gray-100">Locations</a>
            </li>
            --}}
          </ul>
        </li>

      </ul>
    </div>

    <!-- Right Side Icons -->
    <div class="flex items-center gap-4">
      <!-- Notification -->
      <div class="relative">
        <button class="relative text-gray-600 hover:text-primary">
          <i class="fa-solid fa-bell text-lg"></i>
        </button>
      </div>

      <!-- Profile Dropdown -->
      <div class="relative group">
        <button
          class="w-8 h-8 bg-primary text-white font-semibold rounded-full text-sm flex items-center justify-center">
          S
        </button>

        <!-- Dropdown -->
        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg hidden group-hover:block z-50">
          <div class="flex items-center gap-3 px-4 py-3 border-b">
            <div class="w-8 h-8 rounded-full overflow-hidden">
              <img src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" alt="avatar"
                class="w-full h-full object-cover" />
            </div>
            <div>
              <p class="text-sm font-medium">Stevani Permana</p>
              <p class="text-xs text-gray-500">stevanipermana@gmail.com</p>
            </div>
          </div>
          <ul class="py-2 text-sm">
            <li>
              <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fa-solid fa-arrow-right-arrow-left w-4"></i> Ganti Akun
              </a>
            </li>
            <li>
              <a href="#" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fa-solid fa-gear w-4"></i> Setting
              </a>
            </li>
            <li>
              <a href="#" class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-gray-100">
                <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
