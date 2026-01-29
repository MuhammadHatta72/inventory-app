<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transactions') }}
            </h2>
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
                                    <th>Invoice Number</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <a href="{{ route('transactions.show', $transaction) }}" class="text-primary text-decoration-none">
                                                {{ $transaction->invoice_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div>{{ $transaction->customer_name }}</div>
                                            <small class="text-muted">{{ $transaction->customer_code }}</small>
                                        </td>
                                        <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td class="text-end fw-semibold text-success">
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </td>
                                        <td>
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
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable with search and pagination
            if (typeof DataTable !== 'undefined') {
                new DataTable('#transactionsTable', {
                    language: {
                        url: '//cdn.datatables.net/plug-ins/2.1.0/i18n/id.json',
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ data per halaman',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                        infoFiltered: '(disaring dari _MAX_ total data)',
                        paginate: {
                            first: 'Pertama',
                            last: 'Terakhir',
                            next: 'Selanjutnya',
                            previous: 'Sebelumnya'
                        }
                    },
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                    order: [[2, 'desc']], // Sort by date descending
                    columnDefs: [
                        { orderable: false, targets: [4] } // Disable sorting on Actions column
                    ],
                    responsive: true,
                    search: {
                        return: true
                    }
                });
            } else {
                console.error('DataTable is not loaded. Please check if DataTables is properly imported.');
            }
        });
    </script>
@endpush