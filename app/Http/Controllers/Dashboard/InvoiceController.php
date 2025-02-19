<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $invoices = Invoice::with('user', 'supplier')->get();
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
        $invoice = new Invoice();
        $suppliers = Supplier::get();
        $categories = Category::get();
        $products = Product::get();
        $stocks = Stock::get();

        $discount_type = [
            (object)[
                'id' => 'exempted',
                'name' => 'بدون'
            ],
            (object)[
                'id' => 'percentage',
                'name' => 'نسبة'
            ],
            (object)[
                'id' => 'value',
                'name' => 'مبلغ'
            ],
        ];
        $invoice_type = [
            (object)[
                'id' => 'buy',
                'name' => 'شراء'
            ],
            (object)[
                'id' => 'sell',
                'name' => 'بيع'
            ],
            (object)[
                'id' => 'return',
                'name' => 'مرجعة'
            ],
        ];

        $status = [
            (object)[
                'id' => 'paid',
                'name' => 'مدفوع'
            ],
            (object)[
                'id' => 'unpaid',
                'name' => 'غير مدفوع'
            ],
        ];

        $invoice->invoice_number = Invoice::orderBy('invoice_number', 'desc')->first() ? Invoice::orderBy('invoice_number', 'desc')->first()->invoice_number + 1 : 1;
        $invoice->invoice_date = date('Y-m-d');
        $invoice->discount_type = 'exempted';
        $invoice->status = 'paid';
        $invoice->products = collect([]);

        return view('dashboard.invoices.create', compact('invoice', 'suppliers', 'categories', 'products', 'stocks','discount_type', 'invoice_type','status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->authorize('create', Invoice::class);
            $request->validate([
                'invoice_number' => 'required|integer|unique:invoices,invoice_number',
                'invoice_date' => 'required|date',
                'representative_name' => 'required|string',
                'receiver_name' => 'required|string',
                'total_before_tax' => 'required|numeric',
                'total_tax' => 'required|numeric',
                'total_after_tax' => 'required|numeric',
                'extra_discount' => 'required|numeric',
                'total_discount' => 'required|numeric',
                'final_total' => 'required|numeric',
                'type' => 'required',
                'status' => 'required',
                'item_count' => 'required|integer|min:1',
                'supplier_id' => 'required|integer|exists:suppliers,id',
                'name.*' => 'required|string',
                'stock_id.*' => 'required|integer|exists:stocks,id',
                'unit_price.*' => 'required|numeric',
                'quantity.*' => 'required|numeric',
                'total_price.*' => 'required|numeric',
                'discountInput.*' => 'required|numeric',
                'taxInput.*' => 'required|numeric'
            ],[
                'item_count.min' => 'العدد الفعلي يجب ان يكون اكبر من 0'
            ]);
            $request->merge([
                'supplier_name' => Supplier::findOrFail($request->supplier_id)->name,
                'created_by' => Auth::user()->id
            ]);
            $invoice = Invoice::create($request->all());

            $item_count= $request->item_count;
            for($i=0; $i<$item_count; $i++){
                InvoiceDetail::create([
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'tax_rate' => $request->taxInput[$i],
                    'discount_value' => $request->discountInput[$i],
                    'final_price' => $request->total_price[$i],
                    'invoice_id'  => $invoice->id,
                    'stock_id' => $request->stock_id[$i],
                ]);
                $stock = Stock::findOrFail($request->stock_id[$i]);
                if($request->type == 'sale'){
                    $stock->update([
                        'quantity' => $stock->quantity - $request->quantity[$i]
                    ]);
                }elseif($request->type == 'buy'){
                    $stock->update([
                        'quantity' => $stock->quantity + $request->quantity[$i]
                    ]);
                }elseif($request->type == 'return'){
                    $stock->update([
                        'quantity' => $stock->quantity + $request->quantity[$i]
                    ]);
                }else{
                    abort(404);
                }
            }


            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            // throw $e;
            return redirect()->route('dashboard.invoices.index')->with('danger', __('Something went wrong. Please try again later.'));
        }


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
        $this->authorize('update', Invoice::class);
        $invoice = Invoice::findOrFail($id);
        $suppliers = Supplier::get();
        $categories = Category::get();
        $products = Product::get();
        $stocks = Stock::get();
        // dd($invoice->products);
        $btn_label = "تعديل";

        $discount_type = [
            (object)[
                'id' => 'exempted',
                'name' => 'بدون'
            ],
            (object)[
                'id' => 'percentage',
                'name' => 'نسبة'
            ],
            (object)[
                'id' => 'value',
                'name' => 'مبلغ'
            ],
        ];
        $invoice_type = [
            (object)[
                'id' => 'buy',
                'name' => 'شراء'
            ],
            (object)[
                'id' => 'sell',
                'name' => 'بيع'
            ],
            (object)[
                'id' => 'return',
                'name' => 'مرجعة'
            ],
        ];

        $status = [
            (object)[
                'id' => 'paid',
                'name' => 'مدفوع'
            ],
            (object)[
                'id' => 'unpaid',
                'name' => 'غير مدفوع'
            ],
        ];

        return view('dashboard.invoices.edit', compact('invoice', 'suppliers', 'categories', 'products', 'stocks', 'discount_type', 'invoice_type', 'status','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update', Invoice::class);
        DB::beginTransaction();
        try{
            $request->validate([
                'invoice_number' => 'required|integer|unique:invoices,invoice_number,'.$id,
                'invoice_date' => 'required|date',
                'representative_name' => 'required|string',
                'receiver_name' => 'required|string',
                'total_before_tax' => 'required|numeric',
                'total_tax' => 'required|numeric',
                'total_after_tax' => 'required|numeric',
                'extra_discount' => 'required|numeric',
                'total_discount' => 'required|numeric',
                'final_total' => 'required|numeric',
                'type' => 'required',
                'status' => 'required',
                'item_count' => 'required|integer|min:1',
                'supplier_id' => 'required|integer|exists:suppliers,id',
                'name.*' => 'required|string',
                'stock_id.*' => 'required|integer|exists:stocks,id',
                'unit_price.*' => 'required|numeric',
                'quantity.*' => 'required|numeric',
                'total_price.*' => 'required|numeric',
                'discountInput.*' => 'nullable|numeric',
                'taxInput.*' => 'nullable|numeric'
            ],[
                'item_count.min' => 'العدد الفعلي يجب ان يكون اكبر من 0'
            ]);

            $request->merge([
                'supplier_name' => Supplier::findOrFail($request->supplier_id)->name,
            ]);
            $invoice = Invoice::findOrFail($id);
            $invoice->update($request->all());

            $item_count= $request->item_count;
            for($i=0; $i<$item_count; $i++){
                $stock = Stock::findOrFail($request->stock_id[$i]);
                $invoice_detail = InvoiceDetail::where('invoice_id', $invoice->id)->where('stock_id', $request->stock_id[$i])->first();
                if($invoice_detail){

                    if($invoice->type == 'sale'){
                        $stock->update([
                            'quantity' => ($stock->quantity + $invoice_detail->quantity) - $request->quantity[$i]
                        ]);
                    }elseif($invoice->type == 'buy'){
                        // dd($stock->quantity , $stock->quantity , $invoice_detail->quantity, $request->quantity[$i]);
                        $stock->update([
                            'quantity' => ($stock->quantity - $invoice_detail->quantity) + $request->quantity[$i]
                        ]);
                    }elseif($invoice->type == 'return'){
                        $stock->update([
                            'quantity' => ($stock->quantity - $invoice_detail->quantity ) + $request->quantity[$i]
                        ]);
                    }else{
                        abort(500);
                    }

                    $invoice_detail->update([
                        'quantity' => $request->quantity[$i],
                        'unit_price' => $request->unit_price[$i],
                        'tax_rate' => $request->taxInput[$i],
                        'discount_value' => $request->discountInput[$i],
                        'final_price' => $request->total_price[$i],
                    ]);
                }else{
                    InvoiceDetail::create([
                        'quantity' => $request->quantity[$i],
                        'unit_price' => $request->unit_price[$i],
                        'tax_rate' => $request->taxInput[$i],
                        'discount_value' => $request->discountInput[$i],
                        'final_price' => $request->total_price[$i],
                        'invoice_id'  => $invoice->id,
                        'stock_id' => $request->stock_id[$i],
                    ]);
                    if($request->type == 'sale'){
                        $stock->update([
                            'quantity' => $stock->quantity - $request->quantity[$i]
                        ]);
                    }elseif($request->type == 'buy'){
                        $stock->update([
                            'quantity' => $stock->quantity + $request->quantity[$i]
                        ]);
                    }elseif($request->type == 'return'){
                        $stock->update([
                            'quantity' => $stock->quantity + $request->quantity[$i]
                        ]);
                    }else{
                        abort(404);
                    }
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
            return redirect()->route('dashboard.invoices.index')->with('danger', __('Something went wrong. Please try again later.'));
        }

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
