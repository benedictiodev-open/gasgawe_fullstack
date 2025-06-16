<div class="navbar bg-base-100 shadow-md">
  <div class="flex-1 sm:flex-none items-center">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <li><a>Item 1</a></li>
        <li>
          <a>Parent</a>
          <ul class="p-2">
            <li><a>Submenu 1</a></li>
            <li><a>Submenu 2</a></li>
          </ul>
        </li>
        <li><a>Item 3</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost text-xl">gasgawe!</a>
  </div>
  <div class="flex-none items-center hidden sm:flex-1 sm:inline-block">
    <ul class="menu menu-horizontal px-1 gap-2">
      <li><a href="{{ route('dashboard') }}"
          class="{{ str_contains(Request::route()->getName(), 'dashboard') ? 'active' : '' }}">Dashboard</a>
      </li>
      <li><a href="{{ route('applicants') }}"
          class="{{ str_contains(Request::route()->getName(), 'applicants') ? 'active' : '' }}">Applicants</a>
      </li>
      <li><a href="{{ route('recruiters') }}"
          class="{{ str_contains(Request::route()->getName(), 'recruiters') ? 'active' : '' }}">Recruiters</a>
      </li>
      <li><a href="{{ route('jobs') }}"
          class="{{ str_contains(Request::route()->getName(), 'jobs') ? 'active' : '' }}">Jobs</a>
      </li>
    </ul>
  </div>
  <div class="flex-none items-center flex gap-x-2.5">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <i class="fa-solid fa-bell text-lg"></i>
      </div>
      <div tabindex="0" class="card card-compact dropdown-content bg-base-100 z-[1] mt-4 w-52 shadow rounded-lg">
        <div class="card-body">
          <span>Jobs</span>
        </div>
      </div>
    </div>

    <div class="dropdown dropdown-end drop-shadow-lg z-10">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img alt="Tailwind CSS Navbar component"
            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
        </div>
      </div>
      <ul tabindex="0" class="menu menu-md dropdown-content bg-base-100 rounded-lg z-[1] mt-4 shadow p-0">
        <div class="flex flex-row items-center justify-between gap-1 p-3 bg-base-200 rounded-t-lg">
          <div class="btn btn-ghost btn-circle avatar">
            <div class="w-8 rounded-full">
              <img alt="Tailwind CSS Navbar component"
                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
            </div>
          </div>
          <div class="flex flex-col gap-1 justify-center">
            <span class="text-sm">Stevani Permana</span>
            <span class="text-xs">stevanipermana@gmail.com</span>
          </div>
        </div>
        <li class="mx-0.5">
          <a class="flex flex-row items-center gap-2">
            <i class="w-fit h-fit fa-solid fa-arrow-right-arrow-left"></i>
            <span class="text-sm">Ganti Akun</span>
          </a>
        </li>
        <li class="mx-0.5">
          <a class="flex flex-row items-center gap-2">
            <i class="w-fit h-fit fa-solid fa-arrow-right-from-bracket"></i>
            <span class="text-sm">Logout</span>
          </a>
        </li>
        <li class="mx-0.5">
          <a class="flex flex-row items-center gap-2">
            <i class="w-fit h-fit fa-solid fa-gear"></i>
            <span class="text-sm">Setting</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
