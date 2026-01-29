<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Customers') }}
                </h2>
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                Add New Customer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="table-responsive">
                        <table id="customersTable" class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Code</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">City</th>
                                    <th class="text-left">Province</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="font-semibold text-center">{{ $customer->code }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->city }}</td>
                                        <td>{{ $customer->province }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('customers.show', $customer) }}"
                                                   class="btn btn-info btn-sm">
                                                    View
                                                </a>
                                                <a href="{{ route('customers.edit', $customer) }}"
                                                   class="btn btn-warning btn-sm text-white">
                                                    Edit
                                                </a>
                                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline delete-customer-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
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
            $('#customersTable').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                order: [[0, 'asc']],
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

            // Konfirmasi hapus dengan SweetAlert
            document.querySelectorAll('.delete-customer-form').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (window.Swal) {
                        window.Swal.fire({
                            title: 'Hapus customer?',
                            text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal'
                        }).then(function (result) {
                            if (result.isConfirmed) form.submit();
                        });
                    } else {
                        if (confirm('Hapus customer? Data tidak dapat dikembalikan.')) form.submit();
                    }
                });
            });
        })();
    </script>
    @endpush
</x-app-layout>