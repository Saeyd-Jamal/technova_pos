<x-front-layout>
    <form action="{{route('dashboard.sizes.update',$sizes->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.sizes._form")
    </form>
</x-front-layout>