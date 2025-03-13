<x-front-layout>
    <form action="{{route('dashboard.totalbalances.update',$totalbalances->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.totalbalances._form")
    </form>
</x-front-layout>