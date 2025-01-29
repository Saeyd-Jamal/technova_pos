<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $this->authorize('view', Supplier::class);

        $request = request();
        if ($request->ajax()) {
            $suppliers = Supplier::select(['id', 'name', 'num_tax', 'email', 'phone_number', 'address', 'financial_category', 'status']);

            return DataTables::of($suppliers)
                ->addIndexColumn() // عمود ترقيم تلقائي
                ->editColumn('financial_category', function ($supplier) {
                    return $supplier->financial_category == 'cash' ? 'كاش' : 'ذمم';
                })
                ->editColumn('status', function ($supplier) {
                    return $supplier->status ? 'نشط' : 'مؤرشف';
                })
                ->addColumn('edit', function ($supplier) {
                    return $supplier->id;
                })
                ->addColumn('delete', function ($supplier) {
                    return $supplier->id;
                })
                ->make(true);
        }

        return view('dashboard.suppliers.index');
    }



    public function create()
    {

        $this->authorize('create', Supplier::class);
        $suppliers = new Supplier();
        return view('dashboard.suppliers.create', compact('suppliers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'num_tax' => 'required',
            'email' => 'nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
            'financial_category' => 'required',
            'status' => 'required',
        ]);
        Supplier::create($request->all());
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item updated successfully.'));
    }


    public function edit($id)
    {
        $this->authorize('edit', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        return view('dashboard.suppliers.edit', compact('suppliers'));
    }


    public function update(Request $request, $id)
    {
        $this->authorize('edit', Supplier::class);

        $request->validate([
            'name' => 'required',
            'num_tax' => 'required',
            'email' => 'nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
            'financial_category' => 'required',
            'status' => 'required',
        ]);

        $suppliers = Supplier::findOrFail($id);

        $suppliers->update($request->all());

        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item added successfully.'));
    }


    public function destroy($id)
    {

        $this->authorize('delete', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        $suppliers->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.suppliers.index')->with('success', __('Item deleted successfully.'));
    }
}
