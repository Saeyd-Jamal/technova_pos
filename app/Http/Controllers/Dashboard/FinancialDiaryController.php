<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\FinancialDiary;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FinancialDiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', FinancialDiary::class);

        $request = request();
        if ($request->ajax()) {
            $financialdiaries = FinancialDiary::with('user')->get();

            return DataTables::of($financialdiaries)
                ->addIndexColumn()
                ->addColumn('created_by', function ($financialdiariary) {
                    return $financialdiariary->user->name ?? 'غير محدد';
                })
                ->addColumn('action', function ($financialdiariary) {
                    return $financialdiariary->id;
                })
                ->addColumn('edit', function ($financialdiariary) {
                    return $financialdiariary->id;
                })
                ->addColumn('delete', function ($financialdiariary) {
                    return $financialdiariary->id;
                })
                ->make(true);
        }

        return view('dashboard.financialdiary.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', FinancialDiary::class);
        $financialdiary = new FinancialDiary();
        $financialdiary->date = Carbon::now()->format('Y-m-d');
        $financialdiary->day = Carbon::createFromFormat('Y-m-d', $financialdiary->date)->locale('ar')->dayName;
        $financialdiary->funds_statistics = [
            [
                'category' => '100',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '50',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '20',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '10',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '5',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '1',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => 'فراطة',
                'quantity' => '0',
                'amount' => '0'
            ],
        ];


        // حساب اليوميات المالية

        $dailyMal = $this->dailyMal($financialdiary->date);
        $financialdiary->daily_purchases = $dailyMal['daily_purchases'];
        $financialdiary->daily_sales = $dailyMal['daily_sales'];
        $financialdiary->daily_tax_collected = $dailyMal['daily_tax_collected'];
        $financialdiary->discount_given = $dailyMal['discount_given'];
        return view('dashboard.financialdiary.create', compact('financialdiary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', FinancialDiary::class);
        $request->validate([
            'day' => 'required|string',
            'date' => 'required|date',
            'cash_inventory' => 'required|numeric|min:0',
            'operating_cost' => 'required|numeric|min:0',
            'net_income' => 'required|numeric|min:0',
            'profit_percentage' => 'required|numeric',
            'gross_profit' => 'required|numeric',
            'remaining_profit' => 'required|numeric',
            'daily_purchases' => 'required|numeric|min:0',
            'daily_sales' => 'required|numeric|min:0',
            'daily_tax_collected' => 'required|numeric|min:0',
            'discount_given' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'quantity-funds*' => 'required|numeric|min:0'
        ]);

        $funds_statistics = [];
        foreach($request->input('quantity-funds') as $key => $value){
            if($key == 'فراطة'){
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * 1
                ];
            }else{
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * $key
                ];
            }
        }

        $request->merge([
            'created_by' => Auth::user()->id,
            'funds_statistics' => json_encode($funds_statistics)
        ]);
        FinancialDiary::create($request->all());

        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('تمت الاضافة بنجاح'));
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialDiary $financialdiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialDiary $financialdiary)
    {
        $this->authorize('update', FinancialDiary::class);
        $financialdiary->funds_statistics = json_decode($financialdiary->funds_statistics, true);
        $btn_label = 'تعديل';
        return view('dashboard.financialdiary.edit', compact('financialdiary','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialDiary $financialdiary)
    {
        $this->authorize('update', FinancialDiary::class);

        $request->validate([
            'day' => 'required|string',
            'date' => 'required|date',
            'cash_inventory' => 'required|numeric|min:0',
            'operating_cost' => 'required|numeric|min:0',
            'net_income' => 'required|numeric|min:0',
            'profit_percentage' => 'required|numeric',
            'gross_profit' => 'required|numeric',
            'remaining_profit' => 'required|numeric',
            'daily_purchases' => 'required|numeric|min:0',
            'daily_sales' => 'required|numeric|min:0',
            'daily_tax_collected' => 'required|numeric|min:0',
            'discount_given' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
            'quantity-funds*' => 'required|numeric|min:0'
        ]);

        $funds_statistics = [];
        foreach($request->input('quantity-funds') as $key => $value){
            if($key == 'فراطة'){
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * 1
                ];
            }else{
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * $key
                ];
            }
        }

        $request->merge([
            'funds_statistics' => json_encode($funds_statistics)
        ]);
        $financialdiary->update($request->all());

        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('FinancialDiary created successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialDiary $financialdiary)
    {

        $this->authorize('delete', FinancialDiary::class);
        $financialdiary->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('FinancialDiary deleted successfully.'));
    }

    public function dailyMal($date){
        $invoices = Invoice::where('invoice_date', $date)->get();
        $daily_purchases = $invoices->where('type','buy')->sum('final_total');
        // $daily_sales = $invoices->where('type','sell')->sum('final_total');
        $daily_tax_collected = $invoices->sum('total_tax');
        $discount_given = $invoices->sum('total_discount');

        return [
            'daily_purchases' => $daily_purchases,
            // 'daily_sales' => $daily_sales,
            'daily_sales' => 0,
            'daily_tax_collected' => $daily_tax_collected,
            'discount_given' => $discount_given,
        ];
    }
}
