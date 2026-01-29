<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Details') }}
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                    Edit Customer
                </a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Customer Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Customer Code</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $customer->code }}</p>
                        </div>

                        <!-- Customer Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Customer Name</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $customer->name }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Address Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500">Full Address</label>
                            <p class="mt-1 text-gray-900">{{ $customer->full_address }}</p>
                        </div>

                        <!-- Village -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Village (Kelurahan)</label>
                            <p class="mt-1 text-gray-900">{{ $customer->village }}</p>
                        </div>

                        <!-- District -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">District (Kecamatan)</label>
                            <p class="mt-1 text-gray-900">{{ $customer->district }}</p>
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">City</label>
                            <p class="mt-1 text-gray-900">{{ $customer->city }}</p>
                        </div>

                        <!-- Province -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Province</label>
                            <p class="mt-1 text-gray-900">{{ $customer->province }}</p>
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Postal Code</label>
                            <p class="mt-1 text-gray-900">{{ $customer->postal_code }}</p>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Created At -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Created At</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('d M Y H:i') }}</p>
                            </div>

                            <!-- Updated At -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $customer->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Complete Address Display -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Complete Address</label>
                        <p class="text-gray-900">{{ $customer->full_address_formatted }}</p>
                    </div>

                    <!-- Transaction History -->
                    @if($customer->hasTransactions())
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction History</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">
                                <strong>Note:</strong> This customer has existing transactions and cannot be deleted.
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-8 d-flex justify-content-end gap-2">
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                            Edit Customer
                        </a>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                            Back to List
                        </a>
                        @if(!$customer->hasTransactions())
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                Delete Customer
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>