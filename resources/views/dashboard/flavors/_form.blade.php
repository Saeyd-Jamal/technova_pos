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
                        <x-form.input label="الاسم" :value="$flavors->name" name="name" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="image">الصورة</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($flavors->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $flavors->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="'product_id" class="form-label">المنتجات</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ($products as $product)
                            <option value="{{$product->id}}" @selected($flavors->product_id == $product->id)>{{$product->name}}</option>
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