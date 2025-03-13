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
                        <x-form.input label="الشهر" :value="$previousbalances->month" name="month" required autofocus />
                    </div>


                   


                    <div class="mb-4 col-md-6">
                        <x-form.input label="المبلغ" :value="$previousbalances->amount"  name="amount" required  />
                    </div>
                   

                    <div class="mb-4 col-md-6">
                        <label for="type" class="form-label">الحالة</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-active"
                                    value="1" @checked(old('type', $previousbalances->type) == 'withdrawal')>
                                <label class="form-check-label" for="type-active">انسحاب</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="type-inactive"
                                    value="0" @checked(old('type', $previousbalances->type) == 'deposit')>
                                <label class="form-check-label" for="type-inactive">إيداع</label>
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