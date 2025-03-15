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
                        <x-form.input label="التاريخ" :value="$costbalance->date" type="date"  name="date" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="المبلغ" :value="$costbalance->total_amount"  name="total_amount" required readonly />
                    </div>
                    <div class="card mb-4 col-md-4">
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
                                        @foreach ($costbalance->funds_statistics as $funds_statistic)
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
                                                {{ $costbalance->total_amount }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
@push('scripts')
    <script>
        $(document).ready(function() {
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
                $('#total_amount').val(amount_total);
            }
        });
    </script>
@endpush