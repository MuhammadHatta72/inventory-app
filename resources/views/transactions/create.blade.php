<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <!-- Customer Selection -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="customer_code" class="block text-sm font-medium text-gray-700">Customer *</label>
                                    <select name="customer_code" id="customer_code" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('customer_code') border-red-500 @enderror" 
                                        required>
                                        <option value="">-- Select Customer --</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->code }}" {{ old('customer_code') == $customer->code ? 'selected' : '' }}>
                                                {{ $customer->code }} - {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Transaction Date *</label>
                                    <input type="date" name="transaction_date" id="transaction_date" 
                                        value="{{ old('transaction_date', date('Y-m-d')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('transaction_date') border-red-500 @enderror" 
                                        required>
                                    @error('transaction_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div id="customerInfo" class="mt-4 hidden">
                                <div class="bg-white p-3 rounded border border-gray-300">
                                    <p class="text-sm"><strong>Name:</strong> <span id="customerName"></span></p>
                                    <p class="text-sm"><strong>Address:</strong> <span id="customerAddress"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Products Section -->
                        <div class="mb-6">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="text-lg font-semibold">Products</h3>
                                <button type="button" onclick="addProductRow()" class="btn btn-success btn-sm">
                                    Add New Product
                                </button>
                            </div>

                            <div id="productsContainer">
                                <!-- Product rows will be added here -->
                            </div>

                            @error('products')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Section -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold">Grand Total:</h3>
                                <p class="text-2xl font-bold text-green-600" id="grandTotal">Rp 0</p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Create Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let productIndex = 0;
        const products = @json($products);

        // Customer selection change handler
        document.getElementById('customer_code').addEventListener('change', function() {
            const customerCode = this.value;
            if (customerCode) {
                fetch(`/api/customers/${customerCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('customerName').textContent = data.data.name;
                            document.getElementById('customerAddress').textContent = 
                                `${data.data.full_address}, ${data.data.village}, ${data.data.district}, ${data.data.city}, ${data.data.province} ${data.data.postal_code}`;
                            document.getElementById('customerInfo').classList.remove('hidden');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('customerInfo').classList.add('hidden');
            }
        });

        function addProductRow() {
            const container = document.getElementById('productsContainer');
            const row = document.createElement('div');
            row.className = 'product-row mb-4 p-4 border border-gray-300 rounded-lg';
            row.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Product</label>
                        <select name="products[${productIndex}][product_code]" class="product-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required onchange="updateProductInfo(this, ${productIndex})">
                            <option value="">-- Select Product --</option>
                            ${products.map(p => `<option value="${p.code}" data-price="${p.price}" data-stock="${p.stock}" data-name="${p.name}">${p.code} - ${p.name} (Stock: ${p.stock})</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Qty</label>
                        <input type="number" name="products[${productIndex}][qty]" class="qty-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" min="1" required onchange="calculateRow(${productIndex})">
                        <span class="text-xs text-gray-500 stock-info-${productIndex}"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="products[${productIndex}][price]" class="price-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0" required onchange="calculateRow(${productIndex})">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Disc 1</label>
                        <input type="number" name="products[${productIndex}][discount_1]" class="disc1-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0" value="0" onchange="calculateRow(${productIndex})">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Disc 2</label>
                        <input type="number" name="products[${productIndex}][discount_2]" class="disc2-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0" value="0" onchange="calculateRow(${productIndex})">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Disc 3</label>
                        <input type="number" name="products[${productIndex}][discount_3]" class="disc3-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" step="0.01" min="0" value="0" onchange="calculateRow(${productIndex})">
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-sm font-medium">Net Price: </span>
                        <span class="net-price-${productIndex} font-semibold text-blue-600">Rp 0</span>
                        <span class="text-sm font-medium ml-4">Subtotal: </span>
                        <span class="subtotal-${productIndex} font-semibold text-green-600">Rp 0</span>
                    </div>
                    <button type="button" onclick="removeProductRow(this)" class="btn btn-danger btn-sm">
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(row);
            productIndex++;
        }

        function updateProductInfo(select, index) {
            const option = select.options[select.selectedIndex];
            const price = option.getAttribute('data-price');
            const stock = option.getAttribute('data-stock');
            
            const row = select.closest('.product-row');
            row.querySelector('.price-input').value = price;
            row.querySelector(`.stock-info-${index}`).textContent = `Available: ${stock}`;
            row.querySelector('.qty-input').max = stock;
            
            calculateRow(index);
        }

        function calculateRow(index) {
            const row = document.querySelectorAll('.product-row')[index];
            if (!row) return;
            
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const disc1 = parseFloat(row.querySelector('.disc1-input').value) || 0;
            const disc2 = parseFloat(row.querySelector('.disc2-input').value) || 0;
            const disc3 = parseFloat(row.querySelector('.disc3-input').value) || 0;
            
            const netPrice = price - (disc1 + disc2 + disc3);
            const subtotal = netPrice * qty;
            
            document.querySelector(`.net-price-${index}`).textContent = 'Rp ' + netPrice.toLocaleString('id-ID');
            document.querySelector(`.subtotal-${index}`).textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach((row, index) => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const disc1 = parseFloat(row.querySelector('.disc1-input').value) || 0;
                const disc2 = parseFloat(row.querySelector('.disc2-input').value) || 0;
                const disc3 = parseFloat(row.querySelector('.disc3-input').value) || 0;
                
                const netPrice = price - (disc1 + disc2 + disc3);
                const subtotal = netPrice * qty;
                total += subtotal;
            });
            
            document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function removeProductRow(button) {
            button.closest('.product-row').remove();
            calculateGrandTotal();
        }

        // Add first product row on page load
        addProductRow();
    </script>
    @endpush
</x-app-layout>