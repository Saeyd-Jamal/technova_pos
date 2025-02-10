<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\InvoiceDetailDetail;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', InvoiceDetail::class);

        $request = request();
        if ($request->ajax()) {
            $invoicedetails = InvoiceDetail::select(['id', 'quantity','unit_price_before_tax',  'tax_rate', 'tax_amount', 'unit_price_after_tax','total_price_before_tax','total_price_after_tax','discount_amount','final_price','invoice_id','stock_id']);

            return DataTables::of($invoicedetails)
                ->addIndexColumn()
                
                
                ->addColumn('action', function ($invoicedetail) {
                    return $invoicedetail->id;
                })
                ->addColumn('edit', function ($invoicedetail) {
                    return $invoicedetail->id;
                })
                ->addColumn('delete', function ($invoicedetail) {
                    return $invoicedetail->id;
                })
                ->make(true);
        }

        return view('dashboard.invoicesdetails.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('create', InvoiceDetail::class);
        $invoicedetails = new InvoiceDetail();

        return view('dashboard.invoicesdetails.create' , compact('invoicedetails'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', InvoiceDetail::class);
        $request->validate([
            'quantity' => 'required',
            'unit_price_before_tax' => 'required',
            'tax_rate' => 'required',
            'tax_amount' => 'required',
            'unit_price_after_tax' => 'required',
            'total_price_before_tax'=> 'required',
            'total_price_after_tax' => 'required',
            'discount_amount' => 'required',
            'final_price' => 'required',
        ]);
           
        InvoiceDetail::create($request->all());
         
            return redirect()->route('dashboard.invoices.index')->with('success', __('Invoice created successfully.'));
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
       

        $this->authorize('edit', InvoiceDetail::class);
        $invoicedetail = InvoiceDetail::findOrFail($id);
       
       
        return view('dashboard.invoicesdetails.edit' , compact('invoicedetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('edit', InvoiceDetail::class);
        $request->validate([
            'quantity' => 'required',
            'unit_price_before_tax' => 'required',
            'tax_rate' => 'required',
            'tax_amount' => 'required',
            'unit_price_after_tax' => 'required',
            'total_price_before_tax'=> 'required',
            'total_price_after_tax' => 'required',
            'discount_amount' => 'required',
            'final_price' => 'required',
        ]);

        $invoicedetail = InvoiceDetail::findOrFail($id);
        $invoicedetail->update($request->all());

         return redirect()->route('dashboard.invoices.index')->with('success', __('InvoiceDetail updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', InvoiceDetail::class);
        $invoicedetail = InvoiceDetail::findOrFail($id);
        $invoicedetail->delete();
        return redirect()->route('dashboard.invoices.index')->with('success', __('Invoice deleted successfully.'));
    }
}
