<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Customer Code -->
                            <div class="mb-4">
                                <label for="code" class="block text-sm font-medium text-gray-700">Customer Code *</label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('code') border-red-500 @enderror" 
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Alphanumeric only, no special characters</p>
                                @error('code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Customer Name -->
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Customer Name *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror" 
                                    required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Full Address -->
                        <div class="mb-4">
                            <label for="full_address" class="block text-sm font-medium text-gray-700">Full Address *</label>
                            <textarea name="full_address" id="full_address" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('full_address') border-red-500 @enderror" 
                                required>{{ old('full_address') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Street address, building number, etc.</p>
                            @error('full_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Province -->
                            <div class="mb-4">
                                <label for="province" class="block text-sm font-medium text-gray-700">Province *</label>
                                <input type="text" name="province" id="province" value="{{ old('province') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('province') border-red-500 @enderror" 
                                    placeholder="e.g., DKI Jakarta" required>
                                @error('province')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="mb-4">
                                <label for="city" class="block text-sm font-medium text-gray-700">City *</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('city') border-red-500 @enderror" 
                                    placeholder="e.g., Jakarta Selatan" required>
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div class="mb-4">
                                <label for="district" class="block text-sm font-medium text-gray-700">District (Kecamatan) *</label>
                                <input type="text" name="district" id="district" value="{{ old('district') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('district') border-red-500 @enderror" 
                                    placeholder="e.g., Setiabudi" required>
                                @error('district')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Village -->
                            <div class="mb-4">
                                <label for="village" class="block text-sm font-medium text-gray-700">Village (Kelurahan) *</label>
                                <input type="text" name="village" id="village" value="{{ old('village') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('village') border-red-500 @enderror" 
                                    placeholder="e.g., Kuningan Timur" required>
                                @error('village')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="mb-4">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code *</label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('postal_code') border-red-500 @enderror" 
                                    placeholder="e.g., 12950" pattern="[0-9]{5}" minlength="5" maxlength="5" inputmode="numeric" required>
                                <p class="text-xs text-gray-500 mt-1">Must be exactly 5 digits (numbers only)</p>
                                @error('postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-6">
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Save Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>