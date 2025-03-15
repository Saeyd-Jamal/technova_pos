<x-front-layout>
    <form action="{{route('dashboard.cost_balances.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.cost_balances._form")
    </form>
</x-front-layout>


