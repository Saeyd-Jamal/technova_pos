<x-front-layout>
    <form action="{{route('dashboard.invoices.store')}}" method="post" class="col-12">
        @csrf
        @include("dashboard.invoices._form")
    </form>
</x-front-layout>