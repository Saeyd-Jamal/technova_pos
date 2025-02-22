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
                        <x-form.input label="day" :value="$financialdiaries->day" name="day" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="date" :value="$financialdiaries->date" name="date" required autofocus />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="cash_inventory" :value="$financialdiaries->cash_inventory" name="cash_inventory" required autofocus />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="operating_cost" :value="$financialdiaries->operating_cost" name="operating_cost" required  />
                    </div>


                   
                    <div class="mb-4 col-md-6">
                        <x-form.input label="net_income" :value="$financialdiaries->net_income" name="net_income" required  />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="profit_percentage" :value="$financialdiaries->profit_percentage" name="profit_percentage" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="gross_profit" :value="$financialdiaries->gross_profit" name="gross_profit" required  />


                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="remaining_profit" :value="$financialdiaries->remaining_profit" name="remaining_profit" required  />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="daily_purchases" :value="$financialdiaries->daily_purchases" name="daily_purchases" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="daily_sales" :value="$financialdiaries->daily_sales" name="daily_sales" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="daily_tax_collected" :value="$financialdiaries->daily_tax_collected" name="daily_tax_collected" required  />
                    </div>


                    <div class="mb-4 col-md-6">
                        <x-form.input label="discount_given" :value="$financialdiaries->discount_given" name="discount_given" required  />
                    </div>
                    <div class="mb-4 col-md-6">
                        <x-form.input label="remarks" :value="$financialdiaries->remarks" name="remarks" required  />
                    </div>

                    <div class="mb-4 col-md-6">
                        <x-form.input label="daily_tax_collected" :value="$financialdiaries->daily_tax_collected" name="daily_tax_collected" required  />
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