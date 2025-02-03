<x-front-layout>
    @push('styles')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    @endpush

    <!-- Invoice List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="invoice-list-table table border-top table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>الصورة</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>الصنف</th>
                        <th class="cell-fit">الحدث</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script>
        const urlIndex = '{{ route('dashboard.products.index') }}';
        const urlCreate = '{{ route('dashboard.products.create') }}';
        const urlView = "{{ route('dashboard.products.show', ':id') }}";
        const urlEdit = "{{ route('dashboard.products.edit', ':id') }}";
        const urlDestroy = `{{ route('dashboard.products.destroy', ':id') }}`;
        const token = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('js/pages/products.js') }}"></script>
    @endpush
</x-front-layout>
