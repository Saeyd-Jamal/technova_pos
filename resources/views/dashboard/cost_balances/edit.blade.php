<x-front-layout>
    <form action="{{route('dashboard.cost_balances.update',$costbalance->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.cost_balances._form")
    </form>
</x-front-layout>