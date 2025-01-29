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
            ->editColumn('status', function ($supplier) {
                return $supplier->status ? 'Active' : 'Inactive';
            })
            ->addColumn('edit', function ($supplier) {
                return '<a href="'.route('dashboard.supplier.edit', $supplier->id).'" class="btn btn-primary btn-sm">Edit</a>';
            })
            ->addColumn('delete', function ($supplier) {
                return '<form action="'.route('dashboard.supplier.destroy', $supplier->id).'" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    return view('dashboard.supplier.index');
}



public function create(){
 
    $this->authorize('create', Supplier::class);
    $suppliers = new Supplier();
    return view('dashboard.supplier.create' , compact('suppliers'));

}


public function store(Request $request)
{

    $request->validate([
      'name' => 'required',
      'num_tax' => 'required',
      'email' =>'nullable',
      'phone_number' =>'nullable',
      'address' =>'nullable',
      'financial_category'=> 'required',
      'status' => 'required',

    ]);

    Supplier::create([
         'name' => $request->name,
         'num_tax' => $request->num_tax,
         'email' => $request->email,
         'phone_number' => $request->phone_number,
         'address' => $request->address,
         'financial_category' => $request->financial_category,
         'status' => $request->status,

    ]);

    return redirect()->route('dashboard.supplier.index')->with('success', __('Item updated successfully.'));


}


public function edit($id)
{

    $this->authorize('edit', Supplier::class);
    $suppliers = Supplier::findOrFail($id);
    
    return view('dashboard.supplier.edit',compact('suppliers'));

}


public function update(Request $request, $id)
{
    $this->authorize('edit', Supplier::class);

    $request->validate([
        'name' => 'required',
        'num_tax' => 'required',
        'email' =>'nullable',
        'phone_number' =>'nullable',
        'address' =>'nullable',
        'financial_category'=> 'required',
        'status' => 'required',
      ]);

      $suppliers = Supplier::findOrFail($id);
  
      $suppliers->update([
           'name' => $request->name,
           'num_tax' => $request->num_tax,
           'email' => $request->email,
           'phone_number' => $request->phone_number,
           'address' => $request->address,
           'financial_category' => $request->financial_category,
           'status' => $request->status,
      ]);

      return redirect()->route('dashboard.supplier.index')->with('success', __('Item added successfully.'));

}


public function destroy($id)
{

    $this->authorize('delete', Supplier::class);
        $suppliers = Supplier::findOrFail($id);
        $suppliers->delete();
        return redirect()->route('dashboard.supplier.index')->with('success', __('Item deleted successfully.'));

}













}
