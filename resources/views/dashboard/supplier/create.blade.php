<x-front-layout>
    <form action="{{route('dashboard.supplier.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.supplier._form")
    </form>
</x-front-layout>