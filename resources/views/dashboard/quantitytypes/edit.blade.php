<x-front-layout>
    <form action="{{route('dashboard.quantitytypes.update', $quantitys->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.quantitytypes._form")
    </form>
</x-front-layout>