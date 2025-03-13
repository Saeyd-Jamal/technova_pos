<x-front-layout>
    <form action="{{route('dashboard.previousbalances.update',$previousbalances->id)}}" method="post" class="col-12">
        @csrf
        @method('put')
        @include("dashboard.previousbalances._form")
    </form>
</x-front-layout>