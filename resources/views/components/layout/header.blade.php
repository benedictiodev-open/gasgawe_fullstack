<nav class="w-full bg-white shadow-sm">
  <div class="max-w-screen-2xl mx-auto flex items-center justify-between px-4 py-3 rounded">
    <!-- Logo & Menu -->
    <div class="flex items-center gap-4">
      <img src="{{ asset('gasgawe-horizontal-logo.png') }}" alt="Logo" class="h-6" />

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
            <li>
              <a href="{{ route('masterdata.education.index') }}"
                class="block px-4 py-2 hover:bg-gray-100">Education</a>
            </li>
            <li>
              <a href="{{ route('masterdata.experience.index') }}"
                class="block px-4 py-2 hover:bg-gray-100">Experience</a>
            </li>
            <li>
              <a href="{{ route('masterdata.expectedSalary.index') }}"
                class="block px-4 py-2 hover:bg-gray-100">Expected Salary</a>
            </li>
            <li>
              <a href="{{ route('masterdata.employmentType.index') }}"
                class="block px-4 py-2 hover:bg-gray-100">Employment Type</a>
            </li>
            <li>
              <a href="{{ route('masterdata.industryType.index') }}" class="block px-4 py-2 hover:bg-gray-100">Industry
                Type</a>
            </li>
          </ul>
        </li>

      </ul>
    </div>

    <!-- Right Side Icons -->
    <div class="flex items-center gap-4">
      <!-- Notification -->
      <div class="relative">
        {{-- <button class="relative text-gray-600 hover:text-primary">
          <i class="fa-solid fa-bell text-lg"></i>
        </button> --}}
      </div>

      <!-- Profile Dropdown -->
      <div class="relative group">
        <button
          class="w-8 h-8 bg-primary text-white font-semibold rounded-full text-sm flex items-center justify-center">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </button>

        <!-- Dropdown -->
        <div class="absolute right-0 mt-0.5 w-56 bg-white rounded-lg shadow-xl hidden group-hover:block z-50">
          <div class="flex items-center gap-3 px-4 py-3 border-b">
            <div class="w-8 h-8 rounded-full overflow-hidden">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
              <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
          </div>
          <ul class="py-2 text-sm">
            <li>
              <a href="{{ route('accounts') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                <i class="fa-solid fa-gear w-4"></i> Setting
              </a>
            </li>
            <li>
              <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-gray-100 w-full">
                  <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
