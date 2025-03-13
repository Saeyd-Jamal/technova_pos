<x-front-layout>
    <form action="{{route('dashboard.bankbalances.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.bankbalances._form")
    </form>
</x-front-layout>


