<x-front-layout>
    <form action="{{route('dashboard.products.store')}}" method="post" class="col-12" enctype="multipart/form-data">
        @csrf
        @include("dashboard.products._form")
    </form>

   
<script>
    let flavorIndex = {{ count($products->flavors) }}; // Initialize index based on existing flavors

    // Function to add a new flavor input
    function addFlavor() {
        const flavorGroup = document.createElement('div');
        flavorGroup.classList.add('flavor-group');
        flavorGroup.id = 'flavor-' + flavorIndex;

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'flavors[' + flavorIndex + ']';
        input.classList.add('form-control', 'mb-2');
        input.placeholder = 'أدخل نكهة';

        const button = document.createElement('button');
        button.type = 'button';
        button.classList.add('btn', 'btn-danger');
        button.textContent = 'حذف';
        button.onclick = function() {
            removeFlavor(flavorIndex);
        };

        flavorGroup.appendChild(input);
        flavorGroup.appendChild(button);

        document.getElementById('flavors').appendChild(flavorGroup);
        flavorIndex++;
    }

    // Function to remove a flavor input
    function removeFlavor(index) {
        const flavorGroup = document.getElementById('flavor-' + index);
        flavorGroup.remove();
    }
</script>



</x-front-layout>