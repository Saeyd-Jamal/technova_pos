<x-front-layout>
    <form action="{{route('dashboard.sizes.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.sizes._form")
    </form>
</x-front-layout>