<x-front-layout>
    <form action="{{route('dashboard.supplier.update',$suppliers->id)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.supplier._form")
    </form>
</x-front-layout>