<x-front-layout>
    <form action="{{route('dashboard.quantitytypes.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.quantitytypes._form")
    </form>
</x-front-layout>