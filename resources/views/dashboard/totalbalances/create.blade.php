<x-front-layout>
    <form action="{{route('dashboard.totalbalances.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.totalbalances._form")
    </form>
</x-front-layout>


