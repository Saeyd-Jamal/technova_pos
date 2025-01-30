<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\QuantityType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuantityTypeController extends Controller
{
    public function index()
    {
        $this->authorize('view', QuantityType::class);

        $request = request();
        if ($request->ajax()) {
            $quantitys = QuantityType::select(['id', 'name']);

            return DataTables::of($quantitys)
                ->addIndexColumn()
               
                ->addColumn('edit', function ($quantity) {
                    return $quantity->id;
                })
                ->addColumn('delete', function ($quantity) {
                    return $quantity->id;
                })
                ->make(true);
        }

        return view('dashboard.quantitytypes.index');
    }

    public function create()
    {
        $this->authorize('create', QuantityType::class);
        $quantitys = new QuantityType();
        
        return view('dashboard.quantitytypes.create', compact('quantitys'));
    }

    public function store(Request $request)
    {

       

        $request->validate([
            'name' => 'required',
        ]);
        
        QuantityType::create($request->all());
       

        return redirect()->route('dashboard.quantitytypes.index')->with('success', __('quantitytypes created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('edit', QuantityType::class);
        $quantitys = QuantityType::findOrFail($id);
        return view('dashboard.quantitytypes.edit', compact('quantitys'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', QuantityType::class);

    $request->validate([
        'name' => 'required',
    ]);

    $quantitys = QuantityType::findOrFail($id);

   
    $quantitys->update($request->all());
   
    return redirect()->route('dashboard.quantitytypes.index')->with('success', __('quantitytypes updated successfully.'));
}



    public function destroy($id)
    {

        $this->authorize('delete', QuantityType::class);
        $quantitys = QuantityType::findOrFail($id);
        $quantitys->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.quantitytypes.index')->with('success', __('Item deleted successfully.'));

    }
}
