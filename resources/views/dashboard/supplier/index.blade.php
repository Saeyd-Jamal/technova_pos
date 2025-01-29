<x-front-layout>
<div class="card">

<div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">جدول الموردين</h5>
            <div class="d-flex align-items-center">
                @can('create', 'App\\Models\Supplier')
                    <a class="btn btn-success" href="{{route('dashboard.supplier.create')}}">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                @endcan
            </div>
        </div>

    <div class="container mt-5">
        <h2 class="mb-4">Suppliers</h2>
        <table id="supplierTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم الضريبة</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                    <th>العنوان</th>
                    <th>الفئة المالية</th>
                    <th>الحالة</th>
                    <th>تعديل</th>
                   <th>حذف</th>

                </tr>
            </thead>
        </table>
    </div>
</div>

    @push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#supplierTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('dashboard.supplier.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'num_tax', name: 'num_tax' },
                    { data: 'email', name: 'email' },
                    { data: 'phone_number', name: 'phone_number' },
                    { data: 'address', name: 'address' },
                    { data: 'financial_category', name: 'financial_category' },
                    { data: 'status', name: 'status' },
                    { data: 'edit', name: 'edit', orderable: false, searchable: false },
                    { data: 'delete', name: 'delete', orderable: false, searchable: false },
                ]
            });
        });
    </script>
    @endpush
</x-front-layout>

