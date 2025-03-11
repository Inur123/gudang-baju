@extends('layouts.app')

@section('content')
<div class="mb-6 mt-10 md:mt-0 pt-5">

    <h2 class="text-2xl font-bold text-gray-800 ">Warehouse Dashboard</h2>
    <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
</div>

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Total Baju</p>
          <p class="text-2xl font-bold text-gray-800">{{ $totalClothes }}</p>
        </div>
        <div class="h-12 w-12 bg-pink-100 rounded-lg flex items-center justify-center">
          <i class="ri-t-shirt-line text-pink-500 text-xl"></i>
        </div>
      </div>
      <div class="mt-2 flex items-center text-xs text-green-600">
        <i class="ri-arrow-up-line mr-1"></i>
        <span>+12% from last month</span>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Incoming Today</p>
          <p class="text-2xl font-bold text-gray-800">42</p>
        </div>
        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
          <i class="ri-inbox-archive-line text-green-500 text-xl"></i>
        </div>
      </div>
      <div class="mt-2 flex items-center text-xs text-green-600">
        <i class="ri-arrow-up-line mr-1"></i>
        <span>+5% from yesterday</span>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Outgoing Today</p>
          <p class="text-2xl font-bold text-gray-800">38</p>
        </div>
        <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center">
          <i class="ri-inbox-unarchive-line text-orange-500 text-xl"></i>
        </div>
      </div>
      <div class="mt-2 flex items-center text-xs text-orange-600">
        <i class="ri-arrow-up-line mr-1"></i>
        <span>+8% from yesterday</span>
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Low Stock Items</p>
          <p class="text-2xl font-bold text-gray-800">12</p>
        </div>
        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center">
          <i class="ri-archive-line text-purple-500 text-xl"></i>
        </div>
      </div>
      <div class="mt-2 flex items-center text-xs text-red-600">
        <i class="ri-error-warning-line mr-1"></i>
        <span>Action needed</span>
      </div>
    </div>
  </div>

  <!-- Forms Section -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Incoming Items Form -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
      <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="ri-inbox-archive-line text-green-500"></i>
        Add Incoming Items
      </h3>
      <form id="incomingForm">
        <div id="clothesItemsContainer">
          <!-- First clothing item (template) -->
          <div class="clothes-item mb-6 pb-6 border-b border-pink-100">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Clothes Name</label>
              <select class="clothes-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                <option value="">Select Clothes</option>
                <option value="1" data-type="adult">Summer Dress (SD001) - Adult</option>
                <option value="2" data-type="adult">Casual Shirt (CS002) - Adult</option>
                <option value="3" data-type="adult">Formal Pants (FP003) - Adult</option>
                <option value="4" data-type="adult">Winter Jacket (WJ004) - Adult</option>
                <option value="5" data-type="children">Kids T-Shirt (KT001) - Children</option>
                <option value="6" data-type="children">Kids Jeans (KJ002) - Children</option>
                <option value="7" data-type="children">Kids Dress (KD003) - Children</option>
              </select>
            </div>

            <!-- Size quantities container (initially hidden) -->
            <div class="size-quantities hidden">
              <div class="bg-pink-50 p-4 rounded-lg mb-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Size Quantities</h4>

                <!-- Adult sizes (shown/hidden based on selection) -->
                <div class="adult-sizes grid grid-cols-2 md:grid-cols-3 gap-3 mb-3">
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size S</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size M</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size L</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size XL</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size XXL</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                </div>

                <!-- Children sizes (shown/hidden based on selection) -->
                <div class="children-sizes grid grid-cols-2 md:grid-cols-3 gap-3 mb-3 hidden">
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 2th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 4th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 6th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 8th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 10th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 12th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                </div>

                <!-- Custom Size Option -->
                <div class="mt-3">
                  <label class="block text-xs font-medium text-gray-700 mb-1">Custom Size</label>
                  <div class="flex items-center gap-2">
                    <input type="checkbox" class="custom-size-toggle form-checkbox h-4 w-4 text-pink-500 rounded focus:ring-pink-500">
                    <input
                      type="number"
                      class="custom-size-quantity w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                      placeholder="0"
                      disabled
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Another Clothing Button -->
        <div class="mb-4">
          <button
            type="button"
            id="addClothingBtn"
            class="w-full py-2 px-4 bg-white border border-pink-300 text-pink-600 font-medium rounded-lg hover:bg-pink-50 transition-colors"
          >
            <i class="ri-add-line mr-1"></i> Add Another Clothing
          </button>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
          <textarea
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
            rows="2"
            placeholder="Additional information about the items"
          ></textarea>
        </div>
        <button
          type="submit"
          class="w-full py-2 px-4 bg-gradient-to-r from-green-500 to-teal-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity"
        >
          Add Incoming Items
        </button>
      </form>
    </div>

    <!-- Outgoing Items Form -->
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
      <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <i class="ri-inbox-unarchive-line text-orange-500"></i>
        Add Outgoing Items
      </h3>
      <form id="outgoingForm">
        <div id="outClothesItemsContainer">
          <!-- First clothing item (template) -->
          <div class="clothes-item mb-6 pb-6 border-b border-pink-100">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Clothes Name</label>
              <select class="clothes-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500">
                <option value="">Select Clothes</option>
                <option value="1" data-type="adult">Summer Dress (SD001) - Adult</option>
                <option value="2" data-type="adult">Casual Shirt (CS002) - Adult</option>
                <option value="3" data-type="adult">Formal Pants (FP003) - Adult</option>
                <option value="4" data-type="adult">Winter Jacket (WJ004) - Adult</option>
                <option value="5" data-type="children">Kids T-Shirt (KT001) - Children</option>
                <option value="6" data-type="children">Kids Jeans (KJ002) - Children</option>
                <option value="7" data-type="children">Kids Dress (KD003) - Children</option>
              </select>
            </div>

            <!-- Size quantities container (initially hidden) -->
            <div class="size-quantities hidden">
              <div class="bg-pink-50 p-4 rounded-lg mb-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Size Quantities</h4>

                <!-- Adult sizes (shown/hidden based on selection) -->
                <div class="adult-sizes grid grid-cols-2 md:grid-cols-3 gap-3 mb-3">
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size S</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size M</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size L</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size XL</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size XXL</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                </div>

                <!-- Children sizes (shown/hidden based on selection) -->
                <div class="children-sizes grid grid-cols-2 md:grid-cols-3 gap-3 mb-3 hidden">
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 2th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 4th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 6th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 8th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 10th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                  <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Size 12th</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                  </div>
                </div>

                <!-- Custom Size Option -->
                <div class="mt-3">
                  <label class="block text-xs font-medium text-gray-700 mb-1">Custom Size</label>
                  <div class="flex items-center gap-2">
                    <input type="checkbox" class="custom-size-toggle form-checkbox h-4 w-4 text-pink-500 rounded focus:ring-pink-500">
                    <input
                      type="number"
                      class="custom-size-quantity w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                      placeholder="0"
                      disabled
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Another Clothing Button -->
        <div class="mb-4">
          <button
            type="button"
            id="outAddClothingBtn"
            class="w-full py-2 px-4 bg-white border border-pink-300 text-pink-600 font-medium rounded-lg hover:bg-pink-50 transition-colors"
          >
            <i class="ri-add-line mr-1"></i> Add Another Clothing
          </button>
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
          <textarea
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
            rows="2"
            placeholder="Additional information about the items"
          ></textarea>
        </div>
        <button
          type="submit"
          class="w-full py-2 px-4 bg-gradient-to-r from-orange-500 to-red-600 text-white font-medium rounded-lg hover:opacity-90 transition-opacity"
        >
          Add Outgoing Items
        </button>
      </form>
    </div>
  </div>

  <!-- Recent Transactions -->
  <div class="mt-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Transactions</h3>
    <div class="bg-white rounded-xl shadow-sm border border-pink-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clothes</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-03-12</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Summer Dress (SD001)</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">M</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">New stock arrival</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-03-11</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Casual Shirt (CS002)</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">L</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Out</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Store delivery</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-03-10</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Kids T-Shirt (KT001)</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">6th</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Out</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">School order</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2025-03-09</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Formal Pants (FP003)</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">XL</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Restock</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Extra space at bottom for better scrolling experience -->
  <div class="h-10 md:h-20"></div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Incoming form handling
      const clothesItemsContainer = document.getElementById('clothesItemsContainer');
      const addClothingBtn = document.getElementById('addClothingBtn');

      // Initialize event listeners for the first clothing item
      initializeClothesItem(clothesItemsContainer.querySelector('.clothes-item'));

      // Add another clothing item
      addClothingBtn.addEventListener('click', function() {
        const newItem = clothesItemsContainer.querySelector('.clothes-item').cloneNode(true);

        // Reset form values
        newItem.querySelectorAll('input').forEach(input => {
          input.value = '';
          if (input.type === 'checkbox') {
            input.checked = false;
          }
        });
        newItem.querySelector('select').value = '';
        newItem.querySelector('.size-quantities').classList.add('hidden');
        newItem.querySelector('.adult-sizes').classList.remove('hidden');
        newItem.querySelector('.children-sizes').classList.add('hidden');

        // Add remove button for additional items
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-item text-red-500 text-sm mt-2 flex items-center';
        removeBtn.innerHTML = '<i class="ri-delete-bin-line mr-1"></i> Remove Item';
        removeBtn.addEventListener('click', function() {
          newItem.remove();
        });

        newItem.appendChild(removeBtn);

        // Initialize event listeners for the new item
        initializeClothesItem(newItem);

        // Add to container
        clothesItemsContainer.appendChild(newItem);
      });

      // Outgoing form handling
      const outClothesItemsContainer = document.getElementById('outClothesItemsContainer');
      const outAddClothingBtn = document.getElementById('outAddClothingBtn');

      // Initialize event listeners for the first clothing item
      initializeClothesItem(outClothesItemsContainer.querySelector('.clothes-item'));

      // Add another clothing item
      outAddClothingBtn.addEventListener('click', function() {
        const newItem = outClothesItemsContainer.querySelector('.clothes-item').cloneNode(true);

        // Reset form values
        newItem.querySelectorAll('input').forEach(input => {
          input.value = '';
          if (input.type === 'checkbox') {
            input.checked = false;
          }
        });
        newItem.querySelector('select').value = '';
        newItem.querySelector('.size-quantities').classList.add('hidden');
        newItem.querySelector('.adult-sizes').classList.remove('hidden');
        newItem.querySelector('.children-sizes').classList.add('hidden');

        // Add remove button for additional items
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-item text-red-500 text-sm mt-2 flex items-center';
        removeBtn.innerHTML = '<i class="ri-delete-bin-line mr-1"></i> Remove Item';
        removeBtn.addEventListener('click', function() {
          newItem.remove();
        });

        newItem.appendChild(removeBtn);

        // Initialize event listeners for the new item
        initializeClothesItem(newItem);

        // Add to container
        outClothesItemsContainer.appendChild(newItem);
      });

      // Function to initialize event listeners for a clothing item
      function initializeClothesItem(itemElement) {
        const clothesSelect = itemElement.querySelector('.clothes-select');
        const sizeQuantities = itemElement.querySelector('.size-quantities');
        const adultSizes = itemElement.querySelector('.adult-sizes');
        const childrenSizes = itemElement.querySelector('.children-sizes');
        const customSizeToggle = itemElement.querySelector('.custom-size-toggle');
        const customSizeQuantity = itemElement.querySelector('.custom-size-quantity');

        // Show size quantities when a clothing item is selected
        clothesSelect.addEventListener('change', function() {
          if (this.value) {
            sizeQuantities.classList.remove('hidden');

            // Check if adult or children clothing
            const clothingType = this.options[this.selectedIndex].getAttribute('data-type');

            if (clothingType === 'adult') {
              adultSizes.classList.remove('hidden');
              childrenSizes.classList.add('hidden');
            } else if (clothingType === 'children') {
              adultSizes.classList.add('hidden');
              childrenSizes.classList.remove('hidden');
            }
          } else {
            sizeQuantities.classList.add('hidden');
          }
        });

        // Toggle custom size quantity field
        customSizeToggle.addEventListener('change', function() {
          customSizeQuantity.disabled = !this.checked;
          if (!this.checked) {
            customSizeQuantity.value = '';
          }
        });
      }
    });
  </script>
<script>

</script>
@endsection
