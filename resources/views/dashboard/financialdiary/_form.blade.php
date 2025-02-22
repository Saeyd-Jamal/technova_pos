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
                            <span class="app-brand-text fw-bold fs-4 ms-50">{{ isset($btn_label) ? 'تعديل إحصائيات يومية': 'إضافة إحصائيات يومية جديدة' }}</span>
                        </div>
                    </div>
                    <div class="col-md-5 col-8 pe-0 ps-0 ps-md-2">
                        <dl class="row mb-0">
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="h5 text-capitalize mb-0 text-nowrap">اليوم : </span>
                            </dt>
                            <dd class="col-sm-7">
                                <div class="input-group input-group-merge disabled">
                                    <span class="input-group-text">#</span>
                                    <x-form.input name="" class="day" :value="$financialdiary->day"  disabled />
                                    <x-form.input type="hidden" name="day" class="day" :value="$financialdiary->day" readonly />
                                </div>
                            </dd>
                            <dt class="col-sm-5 mb-2 d-md-flex align-items-center justify-content-end">
                                <span class="fw-normal">التاريخ:</span>
                            </dt>
                            <dd class="col-sm-7">
                                <x-form.input class="invoice-date flatpickr-input" type="date" placeholder="YYYY-MM-DD" :value="$financialdiary->date" name="date" required />
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" label="جرد الكاش" :value="$financialdiary->cash_inventory" name="cash_inventory" required autofocus />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" label="تكلفة التشغيل" :value="$financialdiary->operating_cost" name="operating_cost" required  />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" label="صافي اليومية" :value="$financialdiary->net_income" name="net_income" required readonly  />
                        <span class="text-muted">الصافي = جرد الكاش - تكلفة التشغيل</span>
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" max="100" label="نسبة الربح" :value="$financialdiary->profit_percentage" name="profit_percentage" required  />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" label="الربح" :value="$financialdiary->gross_profit" name="gross_profit" required readonly  />
                        <span class="text-muted">الربح = صافي اليومية * نسبة الربح</span>
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" class="dailyMalCalc" min="0" step="0.01" label="باقي الربح" :value="$financialdiary->remaining_profit" name="remaining_profit" required readonly />
                        <span class="text-muted">باقي الربح = الربح - تكلفة التشغيل</span>
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" min="0" step="0.01" label="المشتريات اليومية" :value="$financialdiary->daily_purchases" name="daily_purchases" required readonly  />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" min="0" step="0.01" label="المبيعات اليومية" :value="$financialdiary->daily_sales" name="daily_sales" required readonly  />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" min="0" step="0.01" label="حصيلة الضريبة اليومية" :value="$financialdiary->daily_tax_collected" name="daily_tax_collected" required readonly  />
                    </div>
                    <div class="mb-4 col-md-4">
                        <x-form.input type="number" min="0" step="0.01" label="حصيلة الخصم اليومي" :value="$financialdiary->discount_given" name="discount_given" required readonly  />
                    </div>
                </div>
            </div>
            <hr class="mt-0">
            <div class="card-body pt-4">
                <div class="row">
                    <div class="mb-4 col-md-12">
                        <x-form.textarea label="ملاحظات" :value="$financialdiary->remarks" rows="2" name="remarks"   />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="m-0 h4">حساب الصندوق</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white fs-5">الفئة</th>
                                <th class="bg-primary text-white fs-5">العدد</th>
                                <th class="bg-primary text-white fs-5">القيمة الفردية</th>
                            </tr>
                        </thead>
                        <style>
                            td{
                                padding: 3px 4px !important;
                            }
                        </style>
                        <tbody>
                            @foreach ($financialdiary->funds_statistics as $funds_statistic)
                            <tr>
                                <td class="bg-primary text-white fs-5 text-center">
                                    {{ $funds_statistic['category'] }}
                                </td>
                                <td>
                                    <x-form.input
                                        type="number"
                                        class="text-center quantity-funds"
                                        data-category="{{ $funds_statistic['category'] }}"
                                        min="0"
                                        :value="$funds_statistic['quantity']"
                                        name="quantity-funds[{{ $funds_statistic['category'] }}]"
                                        required  />
                                </td>
                                <td class="fs-5 text-center amount-total" id="amount-{{ $funds_statistic['category'] }}">
                                    {{ $funds_statistic['amount'] }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="bg-primary text-white fs-5 text-center" colspan="2">
                                    الاجمالي
                                </td>
                                <td class="fs-5 text-center" id="amount_total">
                                    {{ $financialdiary->cash_inventory }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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


@push('scripts')
    <!-- Vendors JS -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/locale/ar.js"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/js/offcanvas-send-invoice.js') }}"></script>
    <script src="{{ asset('assets/js/app-invoice-add.js') }}"></script>

    <script>
        const is_edit = '{{ isset($btn_label) ? true : false }}';
    </script>
    <script>
        $(document).ready(function () {
            // المعادلات
            $(document).on("input", ".quantity, .unit_price", function () {
                let index = $(this).data("index");
                let quantity = parseFloat($("#quantity-" + index).val()) || 0;
                let unit_price = parseFloat($("#unit_price-" + index).val()) || 0;
                ApplyFunItem(index);
            });

            $(document).on('input','#date',function(){
                let date = $(this).val();
                let formattedDate = moment(date).locale('ar').format('dddd');
                $('.day').val(formattedDate);

                $.ajax({
                    url: `{{ route('dashboard.financialdiaries.dailyMal',':date') }}`.replace(':date', date),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#daily_purchases').val(response.daily_purchases);
                        $('#daily_sales').val(response.daily_sales);
                        $('#daily_tax_collected').val(response.daily_tax_collected);
                        $('#discount_given').val(response.discount_given);
                    }
                });
            });

            $(document).on('input','.dailyMalCalc',function(){
                ApplayFunToatalAmount();
            })

            function ApplayFunToatalAmount() {
                let cash_inventory = $('#cash_inventory').val();
                let operating_cost = $('#operating_cost').val();
                let net_income = $('#net_income').val();
                let profit_percentage = $('#profit_percentage').val();
                let gross_profit = $('#gross_profit').val();

                cash_inventory = cash_inventory != '' ? cash_inventory : 0;
                profit_percentage = profit_percentage != '' ? profit_percentage : 0;

                net_income =  cash_inventory - operating_cost;
                $('#net_income').val(net_income);

                net_income = net_income != '' ? net_income : 0;

                gross_profit = (net_income * (profit_percentage / 100));
                $('#gross_profit').val(gross_profit);

                $('#remaining_profit').val(gross_profit - operating_cost);
            }

            $(document).on('input','.quantity-funds',function(){
                let quantity = $(this).val();
                let category = $(this).data("category");
                if(category == 'فراطة'){
                    category = 1;
                    $('#amount-فراطة').text(quantity * category);
                }else{
                    $('#amount-'+category).text(quantity * category);
                }

                ApplayFunToatalAmountFunds();
            })


            function ApplayFunToatalAmountFunds() {
                let amount_total = 0;

                $('.amount-total').each(function() {
                    amount_total += parseFloat($(this).text()) || 0;
                });

                $('#amount_total').text(amount_total);
            }

            $(document).on('submit','form',function(e){
                e.preventDefault();
                let amount_total = parseFloat($('#amount_total').text()) || 0;
                let cash_inventory = $('#cash_inventory').val();


                console.log(amount_total,cash_inventory);
                if(amount_total != cash_inventory){
                    alert('الاجمالي غير متطابق !!! ');
                    return false;
                }

                this.submit();
            })
            // Select2
            $(".select2").select2();
        });

    </script>
@endpush
