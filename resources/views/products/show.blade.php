<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Product Code</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $product->code }}</p>
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Product Name</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Price</label>
                            <p class="mt-1 text-lg font-semibold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Stock</label>
                            <p class="mt-1 text-lg font-semibold {{ $product->stock <= 10 ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $product->stock }} units
                                @if($product->stock <= 10)
                                    <span class="text-xs text-red-500">(Low Stock!)</span>
                                @endif
                            </p>
                        </div>

                        <!-- Created At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created At</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    @if($product->hasTransactions())
                    <div class="mt-8 mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction History</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">
                                <strong>Note:</strong> This product has been used in transactions and cannot be deleted.
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 d-flex justify-content-end gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">
                            Edit Product
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                            Back to List
                        </a>
                        @if(!$product->hasTransactions())
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete Product
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>