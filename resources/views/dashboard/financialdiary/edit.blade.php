<x-front-layout>
    <form action="{{route('dashboard.financialdiaries.update',$financialdiary->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.financialdiary._form")
    </form>
</x-front-layout>
