<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ummi.collection - Warehouse Dashboard</title>
  @vite('resources/css/app.css')
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
    }

    /* User dropdown */
    .user-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      margin-top: 0.5rem;
      z-index: 50;
    }

    .user-dropdown.active {
      display: block;
    }

    /* Sidebar Animation */
    #mobileSidebar {
      transform: translateX(-100%);
      transition: transform 0.3s ease-in-out;
    }

    #mobileSidebar.active {
      transform: translateX(0);
    }

    /* Overlay for mobile sidebar */
    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 40;
    }

    #overlay.active {
      display: block;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-50">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="overlay"></div>

    <!-- Include Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="md:ml-64">
      <!-- Include Navbar -->
      @include('layouts.navbar')

      <!-- Main Content -->
      <main class="pt-[56px] md:pt-[56px] p-4 md:p-6">
        @yield('content') <!-- Konten utama akan diisi di sini -->
      </main>
    </div>

    <!-- JavaScript for Hamburger Menu, Close Button, and User Dropdown Toggle -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const hamburgerMenu = document.getElementById('hamburgerMenu');
        const closeSidebar = document.getElementById('closeSidebar');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('overlay');

        // Toggle mobile sidebar
        hamburgerMenu.addEventListener('click', function() {
          mobileSidebar.classList.toggle('active');
          overlay.classList.toggle('active');
        });

        // Close sidebar when clicking the close button
        closeSidebar.addEventListener('click', function() {
          mobileSidebar.classList.remove('active');
          overlay.classList.remove('active');
        });

        // Close sidebar when clicking outside
        overlay.addEventListener('click', function() {
          mobileSidebar.classList.remove('active');
          overlay.classList.remove('active');
        });

        // User dropdown toggle
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdown = document.getElementById('userDropdown');

        userDropdownToggle.addEventListener('click', function() {
          userDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
          if (!userDropdownToggle.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.remove('active');
          }
        });
      });
    </script>
  </body>
  </html>
