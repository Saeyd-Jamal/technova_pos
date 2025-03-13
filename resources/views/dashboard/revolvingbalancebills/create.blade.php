<x-front-layout>
    <form action="{{route('dashboard.revolvingbalancebills.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.revolvingbalancebills._form")
    </form>
</x-front-layout>


