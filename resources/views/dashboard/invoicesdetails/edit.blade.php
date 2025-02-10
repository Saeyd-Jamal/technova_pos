<x-front-layout>
    <form action="{{route('dashboard.financialdiaries.update',$financialdiaries->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.stocks._form")
    </form>
</x-front-layout>