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
                        <x-form.input label="Representative Name" :value="$invoices->representative_name" name="representative_name" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="Invoice Date" :value="$invoices->invoice_date" name="invoice_date" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="Receiver Name" :value="$invoices->receiver_name" name="receiver_name" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Invoice Number" :value="$invoices->invoice_number" name="invoice_number" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Total Before Tax " :value="$invoices->total_before_tax" name="total_before_tax" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Total Tax" :value="$invoices->total_tax" name="total_tax" required  />


                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Total After Tax" :value="$invoices->total_after_tax" name="total_after_tax" required  />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="Extra Discount" :value="$invoices->extra_discount" name="extra_discount" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Total Discount" :value="$invoices->total_discount" name="total_discount" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="Final Total" :value="$invoices->final_total" name="final_total" required  />
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="type" class="form-label">النوع</label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-active" value="1" @checked(old('type', $invoices->type) == 'buy' || old('type', $invoices->type) == null)>
                                <label class="form-check-label" for="type-active">بيع</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type-inactive" value="0" @checked(old('type', $invoices->type) == 'sell')>
                                <label class="form-check-label" for="type-inactive">شراء </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="type-inactive" value="0" @checked(old('type', $invoices->type) == 'return')>
                                <label class="form-check-label" for="type-inactive">مرجع </label>
                            </div>
                        </div>
                    </div>


                    <div class="mb-4 col-md-6">
                        <label for="'supplier_id" class="form-label">الموردين</label>
                        <select id="supplier_id" name="supplier_id" class="form-control">
                            <option value="" disabled selected>اختر</option>
                            @foreach ( $suppliers as  $supplier)
                            <option value="{{$supplier->id}}" @selected($invoices->supplier_id == $supplier->id)>{{$supplier->name}}</option>
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