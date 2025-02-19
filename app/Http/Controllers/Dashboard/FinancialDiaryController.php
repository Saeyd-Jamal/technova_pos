<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\FinancialDiary;
use App\Http\Controllers\Controller;
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
            $financialdiaries = FinancialDiary::with('user')->select(['id', 'day','cash_inventory',  'operating_cost', 'net_income', 'profit_percentage','gross_profit','remaining_profit','daily_purchases','daily_sales','daily_tax_collected','discount_given','remarks','created_by']);

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
        
        $financialdiaries = new FinancialDiary();
        return view('dashboard.financialdiary.create', compact('financialdiaries'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', FinancialDiary::class);

        $request->validate([
            'day' => 'required',
            'date' => 'required',
            'cash_inventory' => 'required|integer',
            'operating_cost' => 'required|integer',
            'net_income' => 'required|integer',
            'profit_percentage' => 'required|integer',
            'gross_profit' => 'required|integer',
            'remaining_profit' => 'required|integer',
            'daily_purchases' => 'required|integer',
            'daily_sales' => 'required|integer',
            'daily_tax_collected' => 'required|integer',
            'discount_given' => 'required|integer',
            'remarks' => 'required',
            'daily_tax_collected' => 'required|integer',
        ]);
        
        
        FinancialDiary::create($request->all());
        
        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('تمت الاضافة بنجاح'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update', FinancialDiary::class);

        $financialdiaries = FinancialDiary::all();
        
        return view('dashboard.financialdiary.edit', compact('financialdiaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', FinancialDiary::class);

        $request->validate([
            'day' => 'required',
            'date' => 'required',
            'cash_inventory' => 'required|integer',
            'operating_cost' => 'required|integer',
            'net_income' => 'required|integer',
            'profit_percentage' => 'required|integer',
            'gross_profit' => 'required|integer',
            'remaining_profit' => 'required|integer',
            'daily_purchases' => 'required|integer',
            'daily_sales' => 'required|integer',
            'daily_tax_collected' => 'required|integer',
            'discount_given' => 'required|integer',
            'remarks' => 'required',
            'daily_tax_collected' => 'required|integer',
        ]);


        $financialdiaries = FinancialDiary::findOrFail($id);

        $financialdiaries->update($request->all());
    
        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('FinancialDiary created successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $this->authorize('delete', FinancialDiary::class);
        $financialdiaries = FinancialDiary::findOrFail($id);
        $financialdiaries->delete();
        return redirect()->route('dashboard.financialdiaries.index')->with('success', __('FinancialDiary deleted successfully.'));
    }
}
