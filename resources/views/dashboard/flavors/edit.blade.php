<x-front-layout>
    <form action="{{route('dashboard.flavors.update', $flavors->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.flavors._form")
    </form>
</x-front-layout>