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
                        <x-form.input label="الاسم" :value="$categories->name" name="name" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($categories->image) <!-- تأكد من أن المتغير صحيح -->
                        <img src="{{ asset('storage/' . $categories->image) }}" alt="Current Image" height="60">
                        @endif
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="الوصف" :value="$categories->description" name="description" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-active"
                                    value="1" @checked(old('status', $categories->status) == 'active')>
                                <label class="form-check-label" for="status-active">نشط</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive"
                                    value="0" @checked(old('status', $categories->status) == 'archived')>
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