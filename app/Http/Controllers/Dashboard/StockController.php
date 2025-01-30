<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Size;
use App\Models\Stock;
use App\Models\Flavor;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\QuantityType;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    public function index()
    {
        $this->authorize('view', Stock::class);

        $request = request();
        if ($request->ajax()) {
            $stocks = Stock::with('product','flavor','size','quantity')->select(['id', 'quantity']);

            return DataTables::of($stocks)
                ->addIndexColumn()
                ->editColumn('quantity', function ($stock) {
                    return number_format($stock->quantity, 0, '', '');
                })

                

                ->addColumn('product_name', function ($stock) {
                    return $stock->product ? $stock->product->name : 'No product'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('flavor_name', function ($stock) {
                    return $stock->flavor ? $stock->flavor->name : 'No flavor'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('size_name', function ($stock) {
                    return $stock->size ? $stock->size->name : 'No size'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('quantity_name', function ($stock) {
                    return $stock->quantity? $stock->quantity->name : 'No quantity'; // إرجاع اسم الكاتيجوري
                })
               
                ->addColumn('edit', function ($stock) {
                    return $stock->id;
                })
                ->addColumn('delete', function ($stock) {
                    return $stock->id;
                })
                ->make(true);
        }

        return view('dashboard.stocks.index');
    }

    public function create()
    {
        $this->authorize('create', Stock::class);
        $stocks = new Stock();
        $products = Product::all();
        $flavors = Flavor::all();
        $sizes = Size::all();
        $quantitys = QuantityType::all();
        
        return view('dashboard.stocks.create', compact('stocks','products','flavors','sizes','quantitys'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'quantity' => 'required',
            'product_id' => 'required|integer|exists:products,id',
            'flavor_id' => 'required|integer|exists:flavors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'quantity_type_id' => 'required|integer|exists:quantity_types,id',
        ]);
        
        
        Stock::create($request->all());
        
        return redirect()->route('dashboard.stocks.index')->with('success', __('تمت الاضافة بنجاح'));
    }


    public function edit($id)
    {
        $this->authorize('edit', Stock::class);
        $stocks = Stock::findOrFail($id);
        $products = Product::all();
        $flavors = Flavor::all();
        $sizes = Size::all();
        $quantitys = QuantityType::all();
        return view('dashboard.stocks.edit', compact('stocks','products','flavors','sizes','quantitys'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', Stock::class);

    $request->validate([
        'quantity' => 'required',
        'product_id' => 'required|integer|exists:products,id',
        'flavor_id' => 'required|integer|exists:flavors,id',
        'size_id' => 'required|integer|exists:sizes,id',
        'quantity_type_id' => 'required|integer|exists:quantity_types,id',
    ]);

   
    $stocks = Stock::findOrFail($id);

    $stocks->update($request->all());

    return redirect()->route('dashboard.stocks.index')->with('success', __('تم التعديل بنجاح'));
}



    public function destroy($id)
    {

        $this->authorize('delete', Stock::class);
        $stocks = Stock::findOrFail($id);
        $stocks->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'تم الحذف بنجاح']);
        }
        return redirect()->route('dashboard.stocks.index')->with('success', __('تم الحذف بنجاح'));

    }
}
