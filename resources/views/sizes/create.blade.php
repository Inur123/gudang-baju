@extends('layouts.app')

@section('content')
    <div class="mb-6 mt-10 md:mt-0 pt-5">
        <h2 class="text-2xl font-bold text-gray-800">Create New Size</h2>
        <p class="text-gray-600">Add new size to your inventory.</p>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
        <form action="{{ route('sizes.store') }}" method="POST"> <!-- Action untuk menyimpan data -->
            @csrf <!-- CSRF token untuk keamanan -->

            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                    placeholder="Enter size name" required> <!-- Input untuk nama size -->
            </div>

            <!-- Label Field -->
            <div class="mb-6">
                <label for="label" class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                <select id="label" name="label"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                    <option value="">Select label</option>
                    <option value="dewasa">Dewasa</option>
                    <option value="anak">Anak</option>
                </select> <!-- Dropdown untuk memilih label -->
            </div>

            <!-- Is Custom Field -->
            <div class="mb-6">
                <label for="is_custom" class="block text-sm font-medium text-gray-700 mb-2">Is Custom</label>
                <input type="checkbox" id="is_custom" name="is_custom" value="1"
                    class="rounded border-gray-300 text-pink-500 focus:ring-pink-500"> <!-- Checkbox untuk is_custom -->
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <!-- Cancel Button -->
                <a href="{{ route('sizes.index') }}"
                   class="px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                    Cancel
                </a>

                <!-- Create Size Button -->
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                    Create Size
                </button>
            </div>
        </form>
    </div>

    <!-- Extra space at bottom for better scrolling experience -->
    <div class="h-10 md:h-20"></div>
@endsection
