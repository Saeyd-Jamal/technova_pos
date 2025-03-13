<x-front-layout>
    <form action="{{route('dashboard.bankbalances.update',$bankbalances->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.bankbalances._form")
    </form>
</x-front-layout>