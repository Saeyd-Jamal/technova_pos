<x-front-layout>
    <form action="{{route('dashboard.revolvingbalancebills.update',$revolvingbalancebills->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.revolvingbalancebills._form")
    </form>
</x-front-layout>