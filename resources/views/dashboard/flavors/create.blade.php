<x-front-layout>
    <form action="{{route('dashboard.flavors.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.flavors._form")
    </form>
</x-front-layout>