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
                        <x-form.input label="الاسم" :value="$products->name" name="name" required autofocus />
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
                        <label for="category_id" class="form-label">القسم</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}" @selected($products->category_id == $category->id)>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-active"
                                    value="1" @checked(old('status', $products->status) == 'active')>
                                <label class="form-check-label" for="status-active">نشط</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive"
                                    value="0" @checked(old('status', $products->status) == 'archived')>
                                <label class="form-check-label" for="status-inactive">غير نشط</label>
                            </div>
                        </div>
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