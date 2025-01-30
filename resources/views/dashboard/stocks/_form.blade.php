@if ($errors->any())
<div class="alert alert-danger">
    <h3> Ooops Error</h3>
    <ul>
        @foreach ($errors->all() as $error )
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input type="number" label="الكمية" :value="$stocks->quantity" name="quantity" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="product_id" class="form-label">المنتجات</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}" @selected($stocks->product_id == $product->id)>{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="flavor_id" class="form-label">النكهات</label>
                        <select id="flavor_id" name="flavor_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ($flavors as $flavor)
                            <option value="{{$flavor->id}}" @selected($stocks->flavor_id == $flavor->id)>{{$flavor->name}}</option>
                            @endforeach
                        </select>
                    </div>

                   

                    <div class="mb-4 col-md-6">
                        <label for="size_id" class="form-label">الاحجام</label>
                        <select id="size_id" name="size_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ($sizes as $size)
                            <option value="{{$size->id}}" @selected($stocks->size_id == $size->id)>{{$size->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="quantity_type_id" class="form-label">الكميات</label>
                        <select id="quantity_type_id" name="quantity_type_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ( $quantitys as $quantity)
                            <option value="{{$quantity->id}}" @selected($stocks->quantity_id == $quantity->id)>{{$quantity->name}}</option>
                            @endforeach
                        </select>
                    </div>

                   



                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-3">
                        {{ $btn_label ?? 'أضف' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>