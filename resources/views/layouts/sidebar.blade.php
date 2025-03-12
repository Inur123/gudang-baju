<!-- Sidebar - Fixed on the left -->
<aside class="fixed top-0 left-0 bottom-0 w-64 bg-white border-r border-pink-100 overflow-y-auto z-50 hidden md:block">
    <!-- Logo at the top of sidebar -->
    <div class="p-4 border-b border-pink-100">
        <div class="flex items-center gap-2">
            <i class="ri-shopping-bag-line text-pink-500 text-xl"></i>
            <h1 class="text-xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 text-transparent bg-clip-text">
                ummi.collection</h1>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="p-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                {{ Request::is('dashboard*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-bar-chart-2-line"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('clothes.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                    {{ Request::is('clothes', 'clothes/*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-t-shirt-line"></i>
                    Baju
                </a>
            </li>
            <li>
                <a href="{{ route('sizes.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                    {{ Request::is('sizes*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-ruler-line"></i>
                    Sizes
                </a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                    {{ Request::is('transactions*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-history-line"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('reports.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                    {{ Request::is('reports') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-line-chart-line"></i>
                    Reports
                </a>
            </li>
        </ul>
    </nav>
</aside>

<!-- Mobile Sidebar - Only visible on mobile -->
<aside id="mobileSidebar"
    class="fixed top-0 left-0 bottom-0 w-64 bg-white border-r border-pink-100 overflow-y-auto z-50 md:hidden">
    <!-- Logo and Close Button at the top of sidebar -->
    <div class="p-4 border-b border-pink-100 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <i class="ri-shopping-bag-line text-pink-500 text-xl"></i>
            <h1 class="text-xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 text-transparent bg-clip-text">
                FashionStock</h1>
        </div>
        <!-- Close Button -->
        <button id="closeSidebar" class="p-2 rounded-lg text-gray-700 hover:bg-pink-50">
            <i class="ri-close-line text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="p-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300
                {{ Request::is('dashboard*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 hover:bg-pink-50' }}">
                    <i class="ri-bar-chart-2-line"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('clothes.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300
                {{ Request::is('clothes', 'clothes/*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 bg-transparent hover:bg-pink-50' }}">
                    <i class="ri-t-shirt-line"></i>
                    Baju
                </a>
            </li>
            <li>
                <a href="{{ route('sizes.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300
                    {{ Request::is('sizes*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 bg-transparent hover:bg-pink-50' }}">
                    <i class="ri-ruler-line"></i>
                    Sizes
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300
                    {{ Request::is('transactions*') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 bg-transparent hover:bg-pink-50' }}">
                    <i class="ri-history-line"></i>
                    Transactions
                </a>
            </li>
            <li>
                <a href="{{ route('reports.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-300
                    {{ Request::is('reports') ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium shadow-lg scale-105' : 'text-gray-700 bg-transparent hover:bg-pink-50' }}">
                    <i class="ri-line-chart-line"></i>
                    Reports
                </a>
            </li>
        </ul>
    </nav>
</aside>
