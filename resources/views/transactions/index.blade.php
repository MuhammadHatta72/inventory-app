<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Transactions') }}
                </h2>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                Create New Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="table-responsive">
                        <table id="transactionsTable" class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-left">Invoice Number</th>
                                    <th class="text-left">Customer</th>
                                    <th class="text-left">Date</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <a href="{{ route('transactions.show', $transaction) }}" class="text-primary text-decoration-none font-semibold">
                                                {{ $transaction->invoice_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>{{ $transaction->customer_name }}</div>
                                            <small class="text-muted">{{ $transaction->customer_code }}</small>
                                        </td>
                                        <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td class="text-center fw-semibold text-success">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('transactions.show', $transaction) }}"
                                               class="btn btn-info btn-sm">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            $('#transactionsTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[2, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [4] }
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        })();
    </script>
    @endpush
</x-app-layout>