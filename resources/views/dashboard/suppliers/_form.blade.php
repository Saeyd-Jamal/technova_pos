<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- Account -->
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-6">
                        <x-form.input label="الاسم" :value="$suppliers->name" name="name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input type="number" label="رقم الضريبة" :value="$suppliers->num_tax" name="num_tax" placeholder="ادخل رقم الضريبة" required />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input type="email" label="البريد الالكتروني" :value="$suppliers->email" name="email"
                            placeholder="example@gmail.com" />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="رقم الهاتف	" :value="$suppliers->phone_number" name="phone_number" required autofocus />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="العنوان" :value="$suppliers->address" name="address" required autofocus />
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="financial_category" value="cash"
                            @checked(old('financial_category', $suppliers->financial_category) == 'cash')>
                        <label class="form-check-label">
                            cash
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="financial_category" value="clouds"
                            @checked(old('financial_category', $suppliers->financial_category) == 'clouds')>
                        <label class="form-check-label">
                            clouds
                        </label>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="status" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-active"
                                    value="1" @checked(old('status', $suppliers->status) == 1)>
                                <label class="form-check-label" for="status-active">نشط</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status-inactive"
                                    value="0" @checked(old('status', $suppliers->status) == 0)>
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
