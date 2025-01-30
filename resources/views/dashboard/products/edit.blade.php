<x-front-layout>
    <form action="{{route('dashboard.products.update',$products->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.products._form")
    </form>
</x-front-layout>