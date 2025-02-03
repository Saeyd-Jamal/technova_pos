<x-front-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pt-4">
                    <h3>تفاصيل المنتج</h3>
                    
                  
                    <div class="mb-4">
                        <strong>اسم المنتج:</strong> {{ $products->name }}
                    </div>

                    <div class="mb-4">
                        <strong>سعر المنتج:</strong> {{ $products->price }}
                    </div>

                 

                    <!-- عرض عدد النكهات -->
                    <div class="mb-4">
                        <strong>عدد النكهات:</strong> {{ $products->flavors->count() }}
                    </div>

                    <!-- عرض أسماء النكهات -->
                    <div class="mb-4">
                        <strong>النكهات:</strong>
                        @if($products->flavors->count() > 0)
                            <ul>
                                @foreach ($products->flavors as $flavor)
                                    <li>{{ $flavor->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            لا توجد نكهات
                        @endif
                    </div>

                    <!-- زر العودة -->
                    <div class="mt-4">
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">عودة إلى قائمة المنتجات</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
