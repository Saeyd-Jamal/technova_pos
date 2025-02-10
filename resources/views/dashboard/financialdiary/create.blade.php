
<x-front-layout>
    <form action="{{route('dashboard.financialdiaries.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.financialdiary._form")
    </form>
</x-front-layout>