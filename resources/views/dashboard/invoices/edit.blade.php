<x-front-layout>
    <form action="{{route('dashboard.invoices.update',$invoice->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.invoices._form")
    </form>
</x-front-layout>
