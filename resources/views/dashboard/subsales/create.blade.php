<x-front-layout>
    <form action="{{route('dashboard.subsales.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.subsales._form")
    </form>
</x-front-layout>


