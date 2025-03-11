<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionStock - Register</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 p-6 text-white text-center">
                <div class="flex justify-center mb-2">
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="ri-shopping-bag-line text-2xl"></i>
                    </div>
                </div>
                <h1 class="text-2xl font-bold">Ummi Collection</h1>
                <p class="text-pink-100">Warehouse Management System</p>
            </div>

            <!-- Register Form -->
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Create Your Account</h2>
                <!-- Validasi Error -->
                @if ($errors->any())
                    <div id="error-message"
                        class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg flex items-center justify-between">
                        <div>
                            <strong class="font-bold">Error!</strong>
                            <ul class="mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button onclick="closeErrorMessage()" class="ml-4 text-red-700 hover:text-red-900">
                            <i class="ri-close-line"></i> <!-- Icon close dari Remix Icon -->
                        </button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" name="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="Enter your name" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="Enter your password" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                            placeholder="Confirm your password" required>
                    </div>

                    <button type="submit"
                        class="block w-full py-2 px-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity text-center">
                        Register
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>Already have an account? <a href="{{ route('login') }}"
                            class="text-pink-600 hover:text-pink-800 font-medium">Login here</a></p>
                </div>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-500">
            <p>© 2025 FashionStock. All rights reserved.</p>
        </div>
    </div>
</body>
<script>
    // Fungsi untuk menutup pesan error
    function closeErrorMessage() {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.classList.add('opacity-0'); // Animasi fade out
            setTimeout(() => {
                errorMessage.remove(); // Hapus elemen dari DOM setelah animasi selesai
            }, 500); // Sesuaikan dengan durasi animasi
        }
    }

    // Tutup pesan error secara otomatis setelah 5 detik
    document.addEventListener('DOMContentLoaded', function () {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            setTimeout(() => {
                closeErrorMessage();
            }, 2000);
        }
    });
</script>

</html>
