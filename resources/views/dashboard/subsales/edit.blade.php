<x-front-layout>
    <form action="{{route('dashboard.subsales.update',$subsales->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.subsales._form")
    </form>
</x-front-layout>