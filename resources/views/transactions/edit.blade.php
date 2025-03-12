@extends('layouts.app')

@section('content')
    <div class="mb-6 mt-10 md:mt-0 pt-5">
        <h2 class="text-2xl font-bold text-gray-800">Edit Transaction</h2>
        <p class="text-gray-600">Update transaction details.</p>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" id="transaction-form">
            @csrf <!-- CSRF token for security -->
            @method('PUT') <!-- Method Spoofing for update -->

            <!-- Description Field -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                    placeholder="Enter transaction description">{{ $transaction->description }}</textarea>
            </div>

            <!-- Type Field -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select id="type" name="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                    required>
                    <option value="">Select type</option>
                    <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>

            <!-- Detail Transaksi Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Transaksi</h3>
                <div id="detail-transaksi">
                    @php $bajuIndex = 0; @endphp
                    @foreach ($transaction->details->groupBy('clothes_id') as $clothesId => $details)
                        <!-- Baris Baju -->
                        <div class="baju-row mb-6 p-4 border border-gray-200 rounded-lg">
                            <div class="mb-4">
                                <label for="clothes_id" class="block text-sm font-medium text-gray-700 mb-2">Clothes</label>
                                <select name="clothes_id[]"
                                    class="clothes-select w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                    required>
                                    <option value="">Select Clothes</option>
                                    @foreach ($clothes as $clothe)
                                        <option value="{{ $clothe->id }}" data-label="{{ $clothe->label }}"
                                            {{ $clothesId == $clothe->id ? 'selected' : '' }}>
                                            {{ $clothe->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Baris Ukuran -->
                            <div class="ukuran-container">
                                @foreach ($details as $index => $detail)
                                    <div class="ukuran-row mb-4 p-4 border border-gray-200 rounded-lg">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <!-- Size Field -->
                                            <div>
                                                <label for="size_id"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                                <select name="size_id[{{ $bajuIndex }}][]"
                                                    class="size-select w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                                    required>
                                                    <option value="">Select Size</option>
                                                    @foreach ($sizes->where('label', $detail->clothes->label) as $size)
                                                        <option value="{{ $size->id }}"
                                                            data-is-custom="{{ $size->is_custom ? 'true' : 'false' }}"
                                                            {{ $detail->size_id == $size->id ? 'selected' : '' }}>
                                                            {{ $size->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Quantity Field -->
                                            <div>
                                                <label for="quantity"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                                <input type="number" name="quantity[{{ $bajuIndex }}][]" min="1"
                                                    value="{{ $detail->quantity }}"
                                                    class="quantity-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 appearance-none"
                                                    placeholder="Enter quantity" required>
                                            </div>
                                        </div>
                                        <!-- Input Custom Size -->
                                        <div class="custom-size-input mt-4" style="{{ $detail->size->is_custom ? 'display:block' : 'display:none' }}">
                                            <label for="custom_size" class="block text-sm font-medium text-gray-700 mb-2">Custom
                                                Size</label>
                                            <input type="text" name="custom_size[{{ $bajuIndex }}][]"
                                                value="{{ $detail->custom_size }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                                                placeholder="Enter custom size">
                                        </div>
                                        <!-- Tombol Hapus Ukuran -->
                                        <div class="mt-2 text-right">
                                            <button type="button" class="text-red-500 hover:text-red-700 remove-ukuran-btn">
                                                <i class="ri-delete-bin-line"></i> Hapus Ukuran
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tombol Tambah Ukuran -->
                            <div class="mt-4">
                                <button type="button"
                                    class="tambah-ukuran px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                                    <i class="ri-add-line"></i> Tambah Ukuran
                                </button>
                            </div>

                            <!-- Tombol Hapus Baju -->
                            <div class="mt-4 text-right">
                                <button type="button" class="text-red-500 hover:text-red-700 remove-baju-btn">
                                    <i class="ri-delete-bin-line"></i> Hapus Baju
                                </button>
                            </div>
                        </div>
                        @php $bajuIndex++; @endphp
                    @endforeach
                </div>

                <!-- Tombol Tambah Baju -->
                <div class="mt-4">
                    <button type="button" id="tambah-baju"
                        class="px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                        <i class="ri-add-line"></i> Tambah Baju
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <!-- Cancel Button -->
                <a href="{{ route('transactions.index') }}"
                    class="px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2">
                    Cancel
                </a>

                <!-- Update Transaction Button -->
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">
                    Update Transaction
                </button>
            </div>
        </form>
    </div>

    <!-- Extra space at bottom for better scrolling experience -->
    <div class="h-10 md:h-20"></div>

    <!-- JavaScript for adding and removing rows -->
    <script>
    // Store all clothes and sizes data from server
    const allClothes = {!! json_encode($clothes) !!};
    const allSizes = {!! json_encode($sizes) !!};
    let rowCounter = {{ count($transaction->details->groupBy('clothes_id')) }};

    // Initialize the page
    document.addEventListener('DOMContentLoaded', () => {
        // Add CSS to hide number input spinners
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                .quantity-input::-webkit-outer-spin-button,
                .quantity-input::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }
                .quantity-input { -moz-appearance: textfield; }
            </style>
        `);

        // Set up event listeners
        setupEventListeners();

        // Disable mousewheel on inputs
        disableMousewheelOnInputs();

        // Add total quantity display
        document.getElementById('tambah-baju').parentNode.insertAdjacentHTML('afterend', `
            <div class="mt-4 p-3 bg-pink-50 rounded-lg border border-pink-200">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-700">Total Quantity:</span>
                    <span id="total-quantity" class="text-xl font-bold text-pink-600">0</span>
                </div>
            </div>
        `);

        // Update total quantity
        updateTotalQuantity();

        // Set up MutationObserver for new elements
        new MutationObserver(mutations => {
            if (mutations.some(m => m.addedNodes.length)) disableMousewheelOnInputs();
        }).observe(document.body, { childList: true, subtree: true });
    });

    // Set up all event listeners
    function setupEventListeners() {
        // Event delegation for dynamic elements
        document.addEventListener('change', e => {
            const target = e.target;
            if (target.classList.contains('clothes-select')) {
                updateAvailableClothes();
                populateSizeDropdown(target);
            } else if (target.classList.contains('size-select')) {
                updateAvailableSizes(target);
                toggleCustomSizeInput(target);
            } else if (target.classList.contains('quantity-input')) {
                updateTotalQuantity();
            }
        });

        // Real-time quantity updates
        document.addEventListener('input', e => {
            if (e.target.classList.contains('quantity-input')) updateTotalQuantity();
        });

        // Add baju button
        document.getElementById('tambah-baju').addEventListener('click', addBajuRow);

        // Event delegation for dynamic buttons
        document.addEventListener('click', e => {
            const target = e.target.closest('.tambah-ukuran, .remove-ukuran-btn, .remove-baju-btn');
            if (!target) return;

            if (target.classList.contains('tambah-ukuran')) {
                addUkuranRow(target);
            } else if (target.classList.contains('remove-ukuran-btn')) {
                removeUkuranRow(target);
            } else if (target.classList.contains('remove-baju-btn')) {
                removeBajuRow(target);
            }
        });

        // Form validation
        document.getElementById('transaction-form').addEventListener('submit', e => {
            if (!validateForm()) {
                e.preventDefault();
                alert('Please check all required fields are filled correctly.');
            }
        });

        // Initial state update
        updateAvailableClothes();
    }

    // Disable mousewheel on number inputs
    function disableMousewheelOnInputs() {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('wheel', e => e.preventDefault(), { passive: false });
            input.addEventListener('keydown', e => {
                if (e.key === 'ArrowUp' || e.key === 'ArrowDown') e.preventDefault();
            });
        });
    }

    // Calculate and update total quantity
    function updateTotalQuantity() {
        const total = Array.from(document.querySelectorAll('.quantity-input'))
            .reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

        const totalDisplay = document.getElementById('total-quantity');
        if (totalDisplay) {
            totalDisplay.textContent = total.toLocaleString();
            totalDisplay.classList.add('text-pink-700');
            setTimeout(() => totalDisplay.classList.remove('text-pink-700'), 300);
        }
    }

    // Update available clothes in dropdowns
    function updateAvailableClothes() {
        const selectedClothes = Array.from(document.querySelectorAll('.clothes-select'))
            .filter(select => select.value)
            .map(select => select.value);

        document.querySelectorAll('.clothes-select').forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Clothes</option>';

            allClothes.forEach(clothe => {
                if (!selectedClothes.includes(clothe.id.toString()) || clothe.id.toString() === currentValue) {
                    select.insertAdjacentHTML('beforeend', `
                        <option value="${clothe.id}" data-label="${clothe.label}">${clothe.name}</option>
                    `);
                }
            });

            select.value = currentValue;
        });
    }

    // Populate size dropdown based on selected clothes
    function populateSizeDropdown(clothesSelect) {
        const clothesId = clothesSelect.value;
        const bajuRow = clothesSelect.closest('.baju-row');
        const clothe = allClothes.find(c => c.id.toString() === clothesId);

        if (!clothe) return;

        const filteredSizes = allSizes.filter(size => size.label === clothe.label);

        bajuRow.querySelectorAll('.size-select').forEach(sizeSelect => {
            const currentValue = sizeSelect.value;
            sizeSelect.innerHTML = '<option value="">Select Size</option>';

            filteredSizes.forEach(size => {
                sizeSelect.insertAdjacentHTML('beforeend', `
                    <option value="${size.id}" data-is-custom="${size.is_custom ? 'true' : 'false'}">${size.name}</option>
                `);
            });

            if (filteredSizes.some(size => size.id.toString() === currentValue)) {
                sizeSelect.value = currentValue;
            }

            updateAvailableSizes(sizeSelect);
            toggleCustomSizeInput(sizeSelect);
        });
    }

    // Update available sizes in a baju row
    function updateAvailableSizes(sizeSelect) {
        const bajuRow = sizeSelect.closest('.baju-row');
        const selectedSizes = Array.from(bajuRow.querySelectorAll('.size-select'))
            .filter(select => select.value)
            .map(select => select.value);

        bajuRow.querySelectorAll('.size-select').forEach(select => {
            const currentValue = select.value;
            Array.from(select.options).forEach(option => {
                option.style.display = (option.value && selectedSizes.includes(option.value) &&
                    option.value !== currentValue) ? 'none' : 'block';
            });
        });
    }

    // Toggle custom size input
    function toggleCustomSizeInput(sizeSelect) {
        const isCustom = sizeSelect.options[sizeSelect.selectedIndex]?.getAttribute('data-is-custom') === 'true';
        const customSizeInput = sizeSelect.closest('.ukuran-row').querySelector('.custom-size-input');

        if (customSizeInput) {
            customSizeInput.style.display = isCustom ? 'block' : 'none';
            const customSizeField = customSizeInput.querySelector('input');
            if (customSizeField) {
                customSizeField.required = isCustom;
            }
        }
    }

    // Add a new baju row
    function addBajuRow() {
        rowCounter++;
        const bajuTemplate = document.querySelector('.baju-row').cloneNode(true);

        // Reset ukuran container
        const ukuranContainer = bajuTemplate.querySelector('.ukuran-container');
        const firstUkuranRow = ukuranContainer.querySelector('.ukuran-row').cloneNode(true);
        ukuranContainer.innerHTML = '';
        ukuranContainer.appendChild(firstUkuranRow);

        // Update field names and reset values
        bajuTemplate.querySelectorAll('select, input').forEach(field => {
            if (field.name && field.name.includes('[')) {
                const baseName = field.name.split('[')[0];
                if (['size_id', 'quantity', 'custom_size'].includes(baseName)) {
                    field.name = `${baseName}[${rowCounter}][]`;
                    field.value = '';
                }
            } else if (field.name === 'clothes_id[]') {
                field.value = '';
            }
        });

        // Reset custom size visibility
        const customSizeInput = firstUkuranRow.querySelector('.custom-size-input');
        if (customSizeInput) {
            customSizeInput.style.display = 'none';
            const customSizeField = customSizeInput.querySelector('input');
            if (customSizeField) {
                customSizeField.value = '';
                customSizeField.name = `custom_size[${rowCounter}][]`;
                customSizeField.required = false;
            }
        }

        // Add to container
        document.getElementById('detail-transaksi').appendChild(bajuTemplate);
        disableMousewheelOnInputs();
        updateAvailableClothes();
        updateTotalQuantity();
    }

    // Add a new ukuran row
    function addUkuranRow(button) {
        const bajuRow = button.closest('.baju-row');
        const ukuranContainer = bajuRow.querySelector('.ukuran-container');
        const bajuIndex = Array.from(document.querySelectorAll('.baju-row')).indexOf(bajuRow);

        const ukuranTemplate = ukuranContainer.querySelector('.ukuran-row').cloneNode(true);

        // Update fields
        ukuranTemplate.querySelectorAll('select, input').forEach(field => {
            if (field.classList.contains('size-select')) {
                field.name = `size_id[${bajuIndex}][]`;
                field.value = '';
            } else if (field.classList.contains('quantity-input')) {
                field.name = `quantity[${bajuIndex}][]`;
                field.value = '';
            } else if (field.name && field.name.includes('custom_size')) {
                field.name = `custom_size[${bajuIndex}][]`;
                field.value = '';
                field.required = false;
            }
        });

        // Reset custom size
        ukuranTemplate.querySelector('.custom-size-input').style.display = 'none';

        ukuranContainer.appendChild(ukuranTemplate);
        disableMousewheelOnInputs();

        // Populate dropdowns if needed
        const clothesSelect = bajuRow.querySelector('.clothes-select');
        if (clothesSelect.value) {
            populateSizeDropdown(clothesSelect);
            updateAvailableSizes(ukuranTemplate.querySelector('.size-select'));
        }

        updateTotalQuantity();
    }

    // Remove ukuran row
    function removeUkuranRow(button) {
        const ukuranRow = button.closest('.ukuran-row');
        const ukuranContainer = ukuranRow.closest('.ukuran-container');

        if (ukuranContainer.querySelectorAll('.ukuran-row').length <= 1) {
            alert('Minimal satu ukuran harus ada untuk setiap baju.');
            return;
        }

        ukuranRow.remove();
        updateAvailableSizes(ukuranContainer.querySelector('.size-select'));
        updateTotalQuantity();
    }

    // Remove baju row
    function removeBajuRow(button) {
        const bajuRow = button.closest('.baju-row');
        const bajuContainer = document.getElementById('detail-transaksi');

        if (bajuContainer.querySelectorAll('.baju-row').length <= 1) {
            alert('Minimal satu baju harus ada.');
            return;
        }

        bajuRow.remove();

        // Reindex baju rows
        document.querySelectorAll('.baju-row').forEach((row, index) => {
            row.querySelectorAll('[name*="["]').forEach(field => {
                const baseName = field.name.split('[')[0];
                field.name = field.name.replace(/\[\d+\]/, `[${index}]`);
            });
        });

        updateAvailableClothes();
        updateTotalQuantity();
    }

    // Validate the form before submission
    function validateForm() {
        let isValid = true;

        document.querySelectorAll('.baju-row').forEach(bajuRow => {
            // Check clothes selection
            if (!bajuRow.querySelector('.clothes-select').value) isValid = false;

            // Check each ukuran row
            bajuRow.querySelectorAll('.ukuran-row').forEach(ukuranRow => {
                const sizeSelect = ukuranRow.querySelector('.size-select');
                const quantityInput = ukuranRow.querySelector('.quantity-input');

                if (!sizeSelect.value || !quantityInput.value || parseInt(quantityInput.value) < 1) {
                    isValid = false;
                }

                const isCustomSize = sizeSelect.options[sizeSelect.selectedIndex]?.getAttribute('data-is-custom') === 'true';
                if (isCustomSize && !ukuranRow.querySelector('input[name^="custom_size"]').value.trim()) {
                    isValid = false;
                }
            });
        });

        return isValid && document.querySelectorAll('.baju-row').length > 0;
    }
    </script>
@endsection
