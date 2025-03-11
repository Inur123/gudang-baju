@extends('layouts.app')

@section('content')
<div class="mb-6 mt-10 md:mt-0 pt-5">
    <h2 class="text-2xl font-bold text-gray-800">List Baju</h2>
    <p class="text-gray-600">Manage your clothing inventory.</p>
    <!-- Tambah Data Button -->
    <div class="mt-4">
        <a href="{{ route('clothes.create') }}"
           class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
            Tambah Data
        </a>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Header -->
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($clothes as $index => $clothe)
                    <tr>
                        <!-- No -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ($clothes->currentPage() - 1) * $clothes->perPage() + $index + 1 }}
                        </td>
                        <!-- Name -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $clothe->name }}</td>
                        <!-- Label -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if ($clothe->label === 'dewasa')
                                <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded-full text-xs">Dewasa</span>
                            @else
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Anak</span>
                            @endif
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex gap-2">
                                <!-- Edit Button -->
                                <a href="{{ route('clothes.edit', $clothe->id) }}" class="p-1 text-blue-500 hover:text-blue-700">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <!-- Delete Button -->
                                <form id="delete-form-{{ $clothe->id }}" action="{{ route('clothes.destroy', $clothe->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $clothe->id }})" class="p-1 text-red-500 hover:text-red-700">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-sm text-gray-600">
            Showing
            {{ ($clothes->currentPage() - 1) * $clothes->perPage() + 1 }}-{{ min($clothes->currentPage() * $clothes->perPage(), $clothes->total()) }}
            of {{ $clothes->total() }} clothes
        </p>
        <div class="flex space-x-2">
            <!-- Previous Button -->
            <a href="{{ $clothes->previousPageUrl() }}"
               class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 {{ $clothes->onFirstPage() ? 'disabled' : '' }}">
                Previous
            </a>

            <!-- Pagination Numbers -->
            @php
                $currentPage = $clothes->currentPage();
                $lastPage = $clothes->lastPage();
                $start = max($currentPage - 2, 1);
                $end = min($start + 4, $lastPage);

                if ($end - $start < 4 && $lastPage > 5) {
                    $start = max($lastPage - 4, 1);
                    $end = $lastPage;
                }
            @endphp

            @if ($start > 1)
                <a href="{{ $clothes->url(1) }}"
                   class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                    1
                </a>
                @if ($start > 2)
                    <span class="px-3 py-1 text-gray-600">...</span>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                <a href="{{ $clothes->url($i) }}"
                   class="px-3 py-1 rounded {{ $currentPage == $i ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white' : 'border border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <span class="px-3 py-1 text-gray-600">...</span>
                @endif
                <a href="{{ $clothes->url($lastPage) }}"
                   class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">
                    {{ $lastPage }}
                </a>
            @endif

            <!-- Next Button -->
            <a href="{{ $clothes->nextPageUrl() }}"
               class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-50 {{ $clothes->hasMorePages() ? '' : 'disabled' }}">
                Next
            </a>
        </div>
    </div>
</div>

<!-- Extra space at bottom for better scrolling experience -->
<div class="h-10 md:h-20"></div>


<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form delete
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
