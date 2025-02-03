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
                    <h3>{{ isset($btn_label) ? "تعديل منتج " . $products->name : "اضافة منتج" }}</h3>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الاسم" :value="$products->name" name="name" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="السعر" :value="$products->price" name="price" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="image">الصورة</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($products->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $products->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الوصف" :value="$products->description" name="description" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="الصنف" :value="$products->category_id" name="category_id" :options="$categories" />
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-active" value="1" @checked(old('status', $products->status) == 'active' || old('status', $products->status) == null)>
                                <label class="form-check-label" for="status-active">نشط</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive" value="0" @checked(old('status', $products->status) == 'archived')>
                                <label class="form-check-label" for="status-inactive">غير نشط</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <!-- <div class="row">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3>النكهات</h3>
                        <button type="button" class="btn btn-primary" id="add-flavor">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="row">
                        
                    </div>
                    <div class="row" id="flavors">
                        <div class="row" id="flavor-0">
                            
                        </div>
                    </div>
                </div> -->

                <div class="mb-4 col-md-6">
                    <label for="flavors">النكهات:</label>
                    <div id="flavors">
                        @foreach($products->flavors as $index => $flavor)
                            <div class="flavor-group" id="flavor-{{ $index }}">
                                <input type="text" name="flavors[{{ $index }}]" class="form-control mb-2" value="{{ old('flavors.' . $index, $flavor->name) }}" placeholder="أدخل نكهة" />
                                <button type="button" class="btn btn-danger" onclick="removeFlavor({{ $index }})">حذف</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addFlavor()">إضافة نكهة</button>
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


