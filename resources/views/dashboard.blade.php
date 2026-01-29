<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Welcome message --}}
            <div class="mb-8">
                <h3 class="text-2xl font-semibold text-gray-800">
                    Welcome to {{ auth()->user()->name ?? 'Inventory System' }}
                </h3>
                <p class="mt-1 text-gray-600">Overview statistic system of your inventory</p>
            </div>

            {{-- Statistics cards --}}
            <div class="flex gap-4 w-full mb-4">
                {{-- Total Products --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2 lg:w-1/4">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md bg-blue-100 p-3">
                                <svg class="h-8 w-8 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path d="M20 7h-.7c.229-.467.349-.98.351-1.5a3.5 3.5 0 0 0-3.5-3.5c-1.717 0-3.215 1.2-4.331 2.481C10.4 2.842 8.949 2 7.5 2A3.5 3.5 0 0 0 4 5.5c.003.52.123 1.033.351 1.5H4a2 2 0 0 0-2 2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2Zm-9.942 0H7.5a1.5 1.5 0 0 1 0-3c.9 0 2 .754 3.092 2.122-.219.337-.392.635-.534.878Zm6.1 0h-3.742c.933-1.368 2.371-3 3.739-3a1.5 1.5 0 0 1 0 3h.003ZM13 14h-2v8h2v-8Zm-4 0H4v6a2 2 0 0 0 2 2h3v-8Zm6 0v8h3a2 2 0 0 0 2-2v-6h-5Z"/>
</svg>

                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Produk</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-500">Lihat produk →</a>
                    </div>
                </div>

                {{-- Total Customers --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2 lg:w-1/4">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md bg-green-100 p-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Customer</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_customers']) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('customers.index') }}" class="mt-4 inline-block text-sm font-medium text-green-600 hover:text-green-500">Lihat customer →</a>
                    </div>
                </div>

                {{-- Total Transactions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2 lg:w-1/4">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md bg-amber-100 p-3">
                                <svg class="h-8 w-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_transactions']) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="mt-4 inline-block text-sm font-medium text-amber-600 hover:text-amber-500">Lihat transaksi →</a>
                    </div>
                </div>

                {{-- Total Revenue --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2 lg:w-1/4">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 rounded-md bg-emerald-100 p-3">
                                <svg class="h-8 w-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                                <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="mt-4 inline-block text-sm font-medium text-emerald-600 hover:text-emerald-500">Lihat transaksi →</a>
                    </div>
                </div>
            </div>

            {{-- Recent transactions & low stock --}}
            <div class="flex gap-4 w-full mb-4">
                {{-- Recent transactions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terbaru</h4>
                        @if($recentTransactions->isEmpty())
                            <p class="text-gray-500 text-sm">Belum ada transaksi.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($recentTransactions as $tx)
                                    <li class="py-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $tx->invoice_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $tx->customer_name }} · {{ $tx->transaction_date->format('d M Y') }}</p>
                                        </div>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($tx->total, 0, ',', '.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('transactions.index') }}" class="mt-4 inline-block text-sm font-medium text-gray-600 hover:text-gray-900">Lihat semua →</a>
                        @endif
                    </div>
                </div>

                {{-- Low stock products --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full md:w-1/2">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Produk Stok Rendah (≤ 10)</h4>
                        @if($lowStockProducts->isEmpty())
                            <p class="text-gray-500 text-sm">Tidak ada produk dengan stok rendah.</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($lowStockProducts as $product)
                                    <li class="py-3 flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $product->code }}</p>
                                        </div>
                                        <span class="badge bg-danger">{{ $product->stock }} stok</span>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-sm font-medium text-gray-600 hover:text-gray-900">Kelola produk →</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
