<x-front-layout>
    <form action="{{route('dashboard.products.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.products._form")
    </form>
</x-front-layout>