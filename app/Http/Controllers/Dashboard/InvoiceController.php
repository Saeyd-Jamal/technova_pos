<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Invoice::class);

        $request = request();
        if ($request->ajax()) {
            $invoices = Invoice::with('user','supplier')->select(['id', 'representative_name','invoice_date',  'receiver_name', 'invoice_number', 'total_before_tax','total_tax','total_after_tax','extra_discount','total_discount','final_total','type','created_by','supplier_id']);

            return DataTables::of($invoices)
                ->addIndexColumn()
                
                ->addColumn('created_by', function ($invoice) {
                    return $invoice->user->name ?? 'غير محدد';
                })
                ->addColumn('supplier_name', function ($invoice) {
                    return $invoice->supplier ? $invoice->supplier->name : 'No supplier'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('action', function ($invoice) {
                    return $invoice->id;
                })
                ->addColumn('edit', function ($invoice) {
                    return $invoice->id;
                })
                ->addColumn('delete', function ($invoice) {
                    return $invoice->id;
                })
                ->make(true);
        }

        return view('dashboard.invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Invoice::class);
        $invoices = new Invoice();
        $suppliers = Supplier::all();

        return view('dashboard.invoices.create' , compact('invoices','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Invoice::class);
        $request->validate([
            'invoice_date' => 'required',
            'representative_name' => 'required',
            'receiver_name' => 'required',
            'invoice_number' => 'required',
            'total_before_tax' => 'required',
            'total_tax'=> 'required',
            'total_after_tax' => 'required',
            'extra_discount' => 'required',
            'total_discount' => 'required',
            'final_total' => 'required',
            'type' => 'required',
            'supplier_id' => 'required|integer|exists:suppliers,id',
        ]);
           
           Invoice::create($request->all());
         
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
        $this->authorize('edit', Invoice::class);
        $invoices = Invoice::findOrFail($id);
        $suppliers = Supplier::all();
        return view('dashboard.invoices.edit' , compact('invoices','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('create', Invoice::class);
        $request->validate([
            'invoice_date' => 'required',
            'representative_name' => 'required',
            'receiver_name' => 'required',
            'invoice_number' => 'required',
            'total_before_tax' => 'required',
            'total_tax'=> 'required',
            'total_after_tax' => 'required',
            'extra_discount' => 'required',
            'total_discount' => 'required',
            'final_total' => 'required',
            'type' => 'required',
            'supplier_id' => 'required|integer|exists:suppliers,id',
        ]);
           
                $invoices = Invoice::findOrFail($id);
                $invoices->update($request->all());

         return redirect()->route('dashboard.invoices.index')->with('success', __('Invoice updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Invoice::class);
        $invoices = Invoice::findOrFail($id);
        $invoices->delete();
        return redirect()->route('dashboard.invoices.index')->with('success', __('Invoice deleted successfully.'));
    }
}
