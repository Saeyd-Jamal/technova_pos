@if ($errors->any())
    <div class="alert alert-danger">
        <h3> Ooops Error</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            @foreach ($errors->keys() as $key)
                <li>{{ $key }}</li>
            @endforeach
        </ul>
    </div>
@endif
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-invoice.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endpush
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body invoice-preview-header rounded">
                <div class="d-flex flex-wrap flex-column flex-sm-row justify-content-between text-heading">
                    <div class="mb-md-0 mb-6">
                        <div class="d-flex svg-illustration mb-6 gap-2 align-items-center">
                            <div class="">
                                <img src="{{ asset('imgs/logo.png') }}" alt="" width="50">
                            </div>
                            <span class="app-brand-text fw-bold fs-4 ms-50">{{ isset($btn_label) ? 'تعديل فاتورة': 'إضافة فاتورة جديدة' }}</span>
                        </div>
                    </div>
                    <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="h5 text-capitalize mb-0 text-nowrap">فاتورة</span>
                            </dt>
                            <dd class="col-sm-7">
                                <div class="input-group input-group-merge disabled">
                                    <span class="input-group-text">#</span>
                                    <x-form.input name="" :value="$invoice->invoice_number"  disabled />
                                    <x-form.input type="hidden" name="invoice_number" :value="$invoice->invoice_number" readonly />
                                </div>
                            </dd>
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="fw-normal">التاريخ:</span>
                            </dt>
                            <dd class="col-sm-7">
                                <x-form.input class="invoice-date flatpickr-input" type="date" placeholder="YYYY-MM-DD" :value="$invoice->invoice_date" name="invoice_date" required />
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.select label="المورد" :value="$invoice->supplier_id" name="supplier_id" class="select2" :optionsId="$suppliers" required />
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input label="اسم المندوب" :value="$invoice->representative_name" name="representative_name" required/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input label="اسم المستلم" :value="$invoice->receiver_name" name="receiver_name" required/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="الإجمالي قبل الضريبة" :value="$invoice->total_before_tax" name="total_before_tax" readonly/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="إجمالي الضريبة" :value="$invoice->total_tax" name="total_tax" readonly/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="الإجمالي بعد الضريبة" :value="$invoice->total_after_tax" name="total_after_tax" readonly/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.select label="تحديد خصم على الفاتورة" :value="$invoice->discount_type" name="discount_type" :optionsId="$discount_type" required />
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="قيمة الخصم" :value="$invoice->discount_amount" name="discount_amount" required readonly/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="إجمالي الخصومات الإضافية" :value="$invoice->extra_discount" name="extra_discount" readonly/>
                    </div>
                    <div class="mb-4 col-md-3 col-sm-4">
                        <x-form.input type="number" min="0" label="إجمالي الخصم" :value="$invoice->total_discount" name="total_discount" readonly/>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h4>المنتجات</h4>
                </div>
                <div class="row">
                    @foreach ($invoice->products as $index => $item)
                        <div class="repeater-wrapper py-4" data-repeater-item="" id="item-{{ $index }}">
                            <div class="d-flex border border-primary rounded position-relative pe-0">
                                <div class="row w-100 p-6">
                                    <div class="col-md-4 col-12">
                                        <p class="h6 repeater-title">المنتج</p>
                                        <div class="input-group search-product" data-index="{{ $index }}">
                                            <span class="input-group-text" id="basic-addon11">
                                                <i class="ti ti-search"></i>
                                            </span>
                                            <x-form.input name="name[{{ $index }}]" id="name-{{ $index }}" value="{{ $item->product->name }}" placeholder="ابحث ...." required readonly/>
                                        </div>
                                        <div class="text-heading">
                                            <div class="mb-1">
                                                النكهة :
                                            </div>
                                            <span class="me-2">
                                                <span class="flavor-{{ $index }}">{{$item->flavor->name}}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="stock_id[{{ $index }}]" id="stock_id-{{ $index }}" value="{{ $item->id }}">
                                    <div class="col-md-3 col-12">
                                        <p class="h6 repeater-title">سعر الوحدة</p>
                                        <x-form.input type="number" min="0" :value="$item->pivot->unit_price" class="unit_price invoice-item-price" data-index="{{ $index }}" name="unit_price[{{ $index }}]" id="unit_price-{{ $index }}" required/>
                                        <div class="text-heading">
                                            <div class="mb-1">الخصومات :</div>
                                            <span class="me-2">
                                                <span class="discount-{{ $index }}">{{ $item->pivot->discount_value }}</span> %
                                            </span>
                                            <input type="hidden" name="discount-{{ $index }}" id="discount-{{ $index }}" value="{{ $item->pivot->discount_value }}"/>
                                            <span  class="discount_amount discount_amount_{{ $index }} d-none"></span>
                                            <span class="me-2">
                                                <span class="tax-{{ $index }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tax 1">{{ $item->pivot->tax_rate }}</span> %
                                            </span>
                                            <input type="hidden" name="tax-{{ $index }}" id="tax-{{ $index }}" value="{{ $item->pivot->tax_rate }}"/>
                                            <span  class="tax_amount tax_amount_{{ $index }}  d-none"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <p class="h6 repeater-title">الكمية</p>
                                        <x-form.input type="number" data-quantity="{{$item->quantity}}" data-quantity-last="{{$item->pivot->quantity}}"  min="0" value="{{ $item->pivot->quantity }}" class="quantity invoice-item-qty" data-index="{{ $index }}" name="quantity[{{ $index }}]" id="quantity-{{ $index }}" required/>
                                        <div class="text-heading">
                                            <div class="mb-1">متبقي :</div>
                                            <span class="me-2">
                                                <span class="quantity-left-{{ $index }}">{{$item->quantity}}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <p class="h6 repeater-title">الاجمالي</p>
                                        <x-form.input type="number" min="0" class="total_price" value="{{ $item->pivot->final_price }}" name="total_price[{{ $index }}]" id="total_price-{{ $index }}" readonly/>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                    <i class="ti ti-x ti-lg cursor-pointer remove-item" data-repeater-delete="" data-index="{{ $index }}"></i>
                                    <div class="dropdown">
                                        <i class="ti ti-settings ti-lg cursor-pointer more-options-dropdown" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"></i>
                                        <div class="dropdown-menu dropdown-menu-end w-px-300 p-4" aria-labelledby="dropdownMenuButton" style="">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="discountInput-{{ $index }}" class="form-label">خصم (%)</label>
                                                    <input type="number" class="form-control" value="{{ $item->pivot->discount_value ?? 0 }}" name="discountInput[{{ $index }}]" id="discountInput-{{ $index }}" min="0" max="100">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="taxInput-{{ $index }}" class="form-label">ضريبة (%)</label>
                                                    <select name="taxInput[{{ $index }}]" id="taxInput-{{ $index }}" class="form-select tax-select" value="{{ $item->pivot->tax_rate }}">
                                                        <option value="0" selected="">0%</option>
                                                        <option value="1">1%</option>
                                                        <option value="10">10%</option>
                                                        <option value="20">20%</option>
                                                        <option value="40">40%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider my-4"></div>
                                            <button type="button" class="btn btn-label-primary waves-effect apply_change" data-index="{{ $index }}">
                                                تطبيق
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="item_count" id="item_count" value="{{ old('item_count', $invoice->products->count()) }}">
                <div class="row" id="items">

                </div>
                <div class="mt-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-success text-white" id="add-item">
                        <i class="fa-solid fa-plus"></i> اضافة
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-4">
                    <x-form.select label="النوع" :value="$invoice->type" name="type" :optionsId="$invoice_type" required />
                </div>
                <div class="mb-4">
                    <x-form.select label="الحالة" :value="$invoice->status" name="status" :optionsId="$status" required />
                </div>
                <div class="mb-4">
                    <x-form.input type="number" min="0" label="الإجمالي" :value="$invoice->final_total" name="final_total" readonly/>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary d-grid w-100 mb-4 waves-effect waves-light">
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>{{ $btn_label ?? 'إضافة' }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Search Product --}}
<div class="modal fade" id="search-product-modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">البحث على المنتج</h4>
                    <p>قم باختيار المنتج من القائمة أو المسح على qr مباشرة</p>
                </div>
                <div class="row">
                    <div class="mb-4 col-md-12">
                        <label for="name_search" class="form-label mb-2">اسم المنتج</label>
                        <div class="input-group">
                            <x-form.input  name="name_search" class="search_field" data-field="name" placeholder="ابحث ...." />
                            <button class="btn btn-outline-primary waves-effect" type="button" id="reset_search">
                                <i class="fa-solid fa-text-slash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4 col-md-6">
                        <label for="name_search" class="form-label mb-2">مسح ال qr</label>
                        <div class="input-group">
                            <x-form.input class="search_field" name="qr_code_search" aria-label="Example text with button addon" aria-describedby="scan-btn" />
                            <button class="btn btn-outline-primary waves-effect" type="button" id="scan-btn">
                                <i class="fa fa-qrcode"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.select label="الصنف" name="category_id_search" class="search_field" data-field="category_id" :optionsId="$categories" />
                    </div>
                </div>
                <hr>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-striped table-bordered">
                        <style>
                            th{
                                font-size: 1.125rem !important;
                                font-weight: 600 !important;
                            }
                        </style>
                        <thead>
                            <tr>
                                <th class="d-flex align-items-center gap-2">
                                    <div class="avatar me-4">
                                        <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                    </div>
                                    <div class="me-2">
                                        <p class="mb-0 text-heading">اسم المنتج</p>
                                        <p class="small mb-0">الصنف</p>
                                    </div>
                                </th>
                                <th class="text-center">النكهة</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-center">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="search-product-list">
                            {{-- @foreach ($products->take(5) as $product)
                            <tr class="cursor-pointer search-product-item" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-quantity="{{ $product->quantity }}">
                                <td class="d-flex align-items-center  flex-grow-1">
                                    <div class="avatar me-4">
                                        <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                    </div>
                                    <div class="me-2">
                                        <p class="mb-0 text-heading">{{ $product->name }}</p>
                                        <p class="small mb-0">{{ $product->supplier->name }}</p>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span id="quantity_search_0" class="btn btn-info me-2">{{ $product->quantity }}</span>
                                </td>
                                <td class="text-center">
                                    <span id="price_search_0" class="btn btn-primary">{{ $product->price }}</span>
                                </td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Choose Type Invoice -- in open --}}
<div class="modal fade" id="choose-type-invoice" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-xl modal-simple modal-pricing modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="rounded-top">
                    <h3 class="text-center mb-6">إختار نوع الفاتورة</h3>
                    <div class="row gy-6">
                        <div class="col-xl mb-md-0 me-8 btn btn-outline-info waves-effect choose_type_invoice_btn" data-type="buy">
                            <div class="card border rounded shadow-none">
                                <div class="card-body pt-12">
                                    <div class="mt-3 mb-5 text-center">
                                        <img src="{{ asset('assets/img/illustrations/page-pricing-enterprise.png') }}" alt="Basic Image" height="100">
                                    </div>
                                    <h4 class="card-title text-center text-capitalize mb-1">شراء</h4>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xl mb-md-0  btn btn-outline-primary waves-effect mx-4 choose_type_invoice_btn" data-type="sell">
                            <div class="card border rounded shadow-none">
                                <div class="card-body pt-12">
                                    <div class="mt-3 mb-5 text-center">
                                        <img src="{{ asset('assets/img/illustrations/page-pricing-basic.png') }}" alt="Basic Image" height="100">
                                    </div>
                                    <h4 class="card-title text-center text-capitalize mb-1">بيع</h4>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-xl mb-md-0  btn btn-outline-dark waves-effect choose_type_invoice_btn" data-type="return">
                            <div class="card border rounded shadow-none">
                                <div class="card-body pt-12">
                                    <div class="mt-3 mb-5 text-center">
                                        <img src="{{ asset('assets/img/illustrations/page-pricing-standard.png') }}" alt="Basic Image" height="100">
                                    </div>
                                    <h4 class="card-title text-center text-capitalize mb-1">مرجعة</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Pricing Plans -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>
    <script>
        const is_edit = '{{ isset($btn_label) ? true : false }}';
        const url_serch = "{{ route("dashboard.products.search") }}";
    </script>
    <script>
        $(document).ready(function () {
            if (!is_edit) {
                $("#choose-type-invoice").modal("show");
            }
            $(document).on("click", ".choose_type_invoice_btn", function () {
                let type = $(this).data("type");
                $("#type").val(type);
                $("#choose-type-invoice").modal("hide");
            });

            let type_invoice = $('#type').val();
            $(document).on("change", "#type", function () {
                type_invoice = $(this).val();
            });
            // المعادلات
            $(document).on("input", ".quantity, .unit_price", function () {
                let index = $(this).data("index");
                let quantity = parseFloat($("#quantity-" + index).val()) || 0;
                let unit_price = parseFloat($("#unit_price-" + index).val()) || 0;
                ApplyFunItem(index);
            });

            // Tax and Discount
            $(document).on("click", ".apply_change", function () {
                let index = $(this).data("index");
                let discountInput = $("#discountInput-" + index).val();
                let taxInput = $("#taxInput-" + index).val();

                // Apply Tax and Discount
                $(".discount-" + index).text(discountInput);
                $("#discount-" + index).val(discountInput);
                $(".tax-" + index).text(taxInput);
                $("#tax-" + index).val(taxInput);

                ApplyFunItem(index);
            });

            function ApplayFunToatalAmount() {
                // Calculate Discount and Tax
                let discount_amount = 0;
                let tax_amount = 0;
                $(".discount_amount").each(function () {
                    discount_amount += parseFloat($(this).text()) || 0;
                });
                $(".tax_amount").each(function () {
                    tax_amount += parseFloat($(this).text()) || 0;
                });
                $("#extra_discount").val(discount_amount);
                $("#total_tax").val(tax_amount);

                // Calculate total before tax
                let quantity = 0;
                let unit_price = 0;
                $(".quantity").each(function () {
                    quantity += parseFloat($(this).val()) || 0;
                });
                $(".unit_price").each(function () {
                    unit_price += parseFloat($(this).val()) || 0;
                });
                $("#total_before_tax").val(quantity * unit_price);

                // Calculate total after tax
                let total_price = (quantity * unit_price) - tax_amount;
                $("#total_after_tax").val(total_price);

                // Calculate Total Discount
                let discount_amount_invoice = 0;
                if (
                    $("#discount_type").val() != "exempted" &&
                    $("#discount_type").val() != ""
                ) {
                    if ($("#discount_type").val() == "percentage") {
                        discount_amount_invoice =
                            total_price * ($("#discount_amount").val() / 100);
                    }
                    if ($("#discount_type").val() == "value") {
                        discount_amount_invoice = $("#discount_amount").val();
                    }
                }
                total_discount = (parseFloat(discount_amount_invoice)+ parseFloat($("#extra_discount").val()));
                $("#total_discount").val(total_discount);

                let total_price_final = 0;
                $(".total_price").each(function () {
                    total_price_final += parseFloat($(this).val()) || 0;
                });

                // Calculate Final Total
                let final_total = 0;
                final_total = total_price_final - total_discount;
                $("#final_total").val(final_total);
            }

            function ApplyFunItem(index) {
                let quantity = parseFloat($("#quantity-" + index).val()) || 0;
                let quantity_left =parseFloat($("#quantity-" + index).data("quantity")) || 0;
                let quantity_last =parseFloat($("#quantity-" + index).data("quantity-last")) || 0;
                let unit_price = parseFloat($("#unit_price-" + index).val()) || 0;
                let discountInput = $("#discountInput-" + index).val();
                let taxInput = $("#taxInput-" + index).val();

                let total_price = quantity * unit_price;
                let discountInput_val = total_price * (discountInput / 100);
                let taxInput_val = total_price * (taxInput / 100);

                $(".discount_amount_" + index).text(discountInput_val);
                $(".tax_amount_" + index).text(taxInput_val);

                total_price = total_price - (discountInput_val + taxInput_val);
                $("#total_price-" + index).val(total_price);

                if(type_invoice == "sell"){
                    $(".quantity-left-" + index).text((quantity_left + quantity_last) - quantity);
                    if(quantity > (quantity_left + quantity_last)){
                        $("#quantity-" + index).val(quantity_left);
                        $(".quantity-left-" + index).text(0);
                    }
                }else{
                    $(".quantity-left-" + index).text((quantity_left - quantity_last) + quantity);
                }
                ApplayFunToatalAmount();
            }

            $(document).on("change", "#discount_type", function () {
                let val = $(this).val();
                if (val != "exempted" && val != "") {
                    $("#discount_amount").attr("readonly", false);
                } else {
                    $("#discount_amount").attr("readonly", true);
                }
                ApplayFunToatalAmount();
            });

            $("#discount_amount").on("input", function () {
                ApplayFunToatalAmount();
            });

            let indexProduct = 0;
            $(document).on("click", ".search-product", function () {
                let index = $(this).data("index");
                indexProduct = index;
                $("#search-product-modal").modal("show");
            });

            $(document).on("input", ".search_field", function () {
                $.ajax({
                    url: url_serch,
                    method: "get",
                    data: {
                        name: $("#name_search").val(),
                        category_id: $("#category_id_search").val(),
                        qr_code: $("#qr_code_search").val(),
                    },
                    success: function (response) {
                        $("#search-product-list").empty();
                        $.each(response, function (index, value) {
                            $("#search-product-list").append(`
                                <tr class="cursor-pointer search-product-item" data-id="${value.id}" data-name="${value.name}" data-flavor="${value.flavor.name}" data-price="${value.price}" data-quantity="${value.quantity}">
                                    <td class="d-flex align-items-center  flex-grow-1">
                                        <div class="avatar me-4">
                                            <i class="fa-solid fa-capsules fa-2x text-primary"></i>
                                        </div>
                                        <div class="me-2">
                                            <p class="mb-0 text-heading">${value.name}</p>
                                            <p class="small mb-0">${value.category_name}</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span id="flavor_search_${value.id}" class="btn btn-info me-2">${value.flavor.name}</span>
                                    </td>
                                    <td class="text-center">
                                        <span id="quantity_search_${value.id}" class="btn btn-info me-2">${value.quantity}</span>
                                    </td>
                                    <td class="text-center">
                                        <span id="price_search_${value.id}" class="btn btn-primary">${value.price}</span>
                                    </td>
                                </tr>
                            `);
                        });
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            });

            $(document).on("click", ".search-product-item", function () {
                let index = indexProduct;
                $("#stock_id-" + index).val($(this).data("id"));
                $("#name-" + index).val($(this).data("name"));
                $(".flavor-" + index).text($(this).data("flavor"));
                $("#quantity-" + index).attr("max", $(this).data("quantity"));
                $("#quantity-" + index).attr("data-quantity", $(this).data("quantity"));
                $("#unit_price-" + index).val($(this).data("price"));
                $("#search-product-modal").modal("hide");
            });

            let item_count = $("#item_count").val();
            $("#add-item").on("click", function () {
                let index = parseFloat($("#items").children().length) + parseFloat(item_count);
                let item = `<div class="repeater-wrapper py-4" data-repeater-item=""  id="item-${index}">
                        <div class="d-flex border border-primary rounded position-relative pe-0">
                            <div class="row w-100 p-6">
                                <div class="col-md-4 col-12">
                                    <p class="h6 repeater-title">المنتج</p>
                                    <div class="input-group search-product" data-index="${index}">
                                        <span class="input-group-text" id="basic-addon11">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <x-form.input name="name[${index}]" id="name-${index}" placeholder="ابحث ...." required readonly/>
                                    </div>
                                    <div class="text-heading">
                                        <div class="mb-1">
                                            النكهة :
                                        </div>
                                        <span class="me-2">
                                            <span class="flavor-${index}"></span>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="stock_id[${index}]" id="stock_id-${index}" value="">
                                <div class="col-md-3 col-12">
                                    <p class="h6 repeater-title">سعر الوحدة</p>
                                    <x-form.input type="number" min="0" class="unit_price invoice-item-price" data-index="${index}" name="unit_price[${index}]" id="unit_price-${index}" required/>
                                    <div class="text-heading">
                                        <div class="mb-1">الخصومات :</div>
                                        <span class="me-2">
                                            <span class="discount-${index}">0</span> %
                                        </span>
                                        <input type="hidden" name="discount-${index}" id="discount-${index}"/>
                                        <span  class="discount_amount discount_amount_${index} d-none"></span>
                                        <span class="me-2">
                                            <span class="tax-${index}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tax 1">0</span> %
                                        </span>
                                        <input type="hidden" name="tax-${index}" id="tax-${index}"/>
                                        <span  class="tax_amount tax_amount_${index}  d-none"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <p class="h6 repeater-title">الكمية</p>
                                    <x-form.input type="number" min="0" class="quantity invoice-item-qty" data-index="${index}" data-quantity="" name="quantity[${index}]" id="quantity-${index}" required/>
                                    <div class="text-heading">
                                        <div class="mb-1">متبقي :</div>
                                        <span class="me-2">
                                            <span class="quantity-left-${index}">0</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">
                                    <p class="h6 repeater-title">الاجمالي</p>
                                    <x-form.input type="number" min="0" class="total_price" name="total_price[${index}]" id="total_price-${index}" readonly/>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                <i class="ti ti-x ti-lg cursor-pointer remove-item" data-repeater-delete="" data-index="${index}"></i>
                                <div class="dropdown">
                                    <i class="ti ti-settings ti-lg cursor-pointer more-options-dropdown" role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-end w-px-300 p-4" aria-labelledby="dropdownMenuButton" style="">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label for="discountInput-${index}" class="form-label">خصم (%)</label>
                                                <input type="number" class="form-control" name="discountInput[${index}]" id="discountInput-${index}" value="0" min="0" max="100">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="taxInput-${index}" class="form-label">ضريبة (%)</label>
                                                <select name="taxInput[${index}]" id="taxInput-${index}" class="form-select tax-select">
                                                    <option value="0" selected="">0%</option>
                                                    <option value="1">1%</option>
                                                    <option value="10">10%</option>
                                                    <option value="20">20%</option>
                                                    <option value="40">40%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider my-4"></div>
                                        <button type="button" class="btn btn-label-primary waves-effect apply_change" data-index="${index}">
                                            تطبيق
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $("#items").append(item);

                indexProduct = index;
                $("#search-product-modal").modal("show");
                $("#search-product-modal").on("shown.bs.modal", function () {
                    $("#qr_code_search").focus();
                });
                $("#item_count").val(index + 1);
            });

            $(document).on("click", ".remove-item", function () {
                let index = $(this).data("index");
                $("#item-" + index).remove();
                let item_counts = $("#item_count").val();
                item_counts = item_counts - 1;
                $("#item_count").val(item_counts);
            });

            $("#scan-btn").click(function () {
                $("#qr_code_search").focus();
            });

            $("#reset_search").click(function () {
                $(".search_field").val("");
                $(".search_field").trigger("input");
            });

            // Select2
            $(".select2").select2();
        });

    </script>
@endpush
