<x-front-layout>
    <form action="{{route('dashboard.stocks.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.stocks._form")
    </form>
</x-front-layout>