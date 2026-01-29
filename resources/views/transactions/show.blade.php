<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaction Details') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Transaction Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $transaction->invoice_number }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $transaction->transaction_date->format('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Amount</p>
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                        <!-- Customer Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Customer Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-700">Code: <span class="font-normal">{{ $transaction->customer_code }}</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Name: <span class="font-normal">{{ $transaction->customer_name }}</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Address:</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $transaction->customer_address }}</p>
                            </div>
                        </div>

                        <!-- Transaction Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Transaction Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-700">Invoice Number: <span class="font-normal">{{ $transaction->invoice_number }}</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Transaction Date: <span class="font-normal">{{ $transaction->transaction_date->format('d M Y') }}</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Created At: <span class="font-normal">{{ $transaction->created_at->format('d M Y H:i') }}</span></p>
                                <p class="text-sm font-medium text-gray-700 mt-2">Items: <span class="font-normal">{{ $transaction->details->count() }} items</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Disc 1</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Disc 2</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Disc 3</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Net Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->details as $index => $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->product_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->product_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">{{ $detail->qty }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">Rp {{ number_format($detail->discount_1, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">Rp {{ number_format($detail->discount_2, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-500">Rp {{ number_format($detail->discount_3, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-blue-600">Rp {{ number_format($detail->net_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-right text-sm font-bold text-gray-900">GRAND TOTAL:</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600">
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 d-flex justify-content-end gap-2">
                <a href="{{ route('transactions.invoice-pdf', $transaction) }}" target="_blank" class="btn btn-primary btn-sm">
                    Print / Download Invoice (PDF)
                </a>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>