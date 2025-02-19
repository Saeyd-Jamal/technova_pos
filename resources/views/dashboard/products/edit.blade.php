<x-front-layout>
    <form action="{{route('dashboard.products.update',$product->id)}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include("dashboard.products._form")
    </form>
</x-front-layout>