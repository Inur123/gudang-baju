<!-- Top Navbar - Fixed at the top of content area -->

<header class="fixed top-0 left-0 right-0 md:left-64 z-40 bg-white border-b border-pink-100 shadow-sm">

    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Mobile Menu Toggle -->
        <button id="hamburgerMenu" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-pink-50">
            <i class="ri-menu-line text-xl"></i>
        </button>

        <!-- Mobile Logo - Centered on mobile -->
        <div class="flex items-center gap-2 md:hidden mx-auto">
            <i class="ri-shopping-bag-line text-pink-500 text-xl"></i>
            <h1 class="text-xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 text-transparent bg-clip-text">
                ummi.collection</h1>
        </div>

        <!-- Page Title - Only visible on desktop -->
        <h2 class="text-lg font-medium text-gray-800 hidden md:block">Dashboard</h2>

        <!-- User Profile with Dropdown -->
        <div class="relative user-dropdown-container">
            <div class="flex items-center gap-2 cursor-pointer" id="userDropdownToggle">
                <div class="relative">
                    <span class="absolute top-0 right-0 h-2 w-2 bg-green-500 rounded-full"></span>
                    <img src="https://ui-avatars.com/api/?name={{ $initials }}&background=f9a8d4&color=fff"
                        alt="User Avatar" class="h-8 w-8 rounded-full border-2 border-pink-200" />

                </div>
                <div class="hidden md:block">
                    <p class="text-sm font-medium">{{ $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
                <i class="ri-arrow-down-s-line text-gray-500"></i>
            </div>

            <!-- Dropdown Menu -->
            <div id="userDropdown" class="user-dropdown bg-white rounded-lg shadow-lg border border-gray-200 w-48 py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                    <i class="ri-user-line mr-2"></i> Profile
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50">
                    <i class="ri-settings-line mr-2"></i> Settings
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <!-- Token CSRF untuk keamanan -->
                    <button type="submit" class="block px-4 py-2 text-sm text-red-600 hover:bg-pink-50">
                        <i class="ri-logout-box-line mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>

<!-- Mobile Navigation - Fixed below header -->
<div class="fixed top-[56px] left-0 right-0 z-30 md:hidden bg-white border-b border-pink-100 shadow-sm">
    <div class="flex overflow-x-auto p-2 gap-2 no-scrollbar">
        <a href="#"
            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium whitespace-nowrap">
            <i class="ri-bar-chart-2-line"></i>
            Dashboard
        </a>
        <a href="#"
            class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-pink-50 transition-colors whitespace-nowrap">
            <i class="ri-archive-line text-pink-500"></i>
            Inventory
        </a>
        <a href="#"
            class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-pink-50 transition-colors whitespace-nowrap">
            <i class="ri-inbox-archive-line text-green-500"></i>
            Incoming
        </a>
        <a href="#"
            class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-pink-50 transition-colors whitespace-nowrap">
            <i class="ri-inbox-unarchive-line text-orange-500"></i>
            Outgoing
        </a>
    </div>
</div>
