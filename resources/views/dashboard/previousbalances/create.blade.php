<x-front-layout>
    <form action="{{route('dashboard.previousbalances.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.previousbalances._form")
    </form>
</x-front-layout>


