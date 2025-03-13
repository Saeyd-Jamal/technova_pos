<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\SubSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SubSaleController extends Controller
{
    public function index()
    {
        $this->authorize('view', SubSale::class);

        $request = request();
        if ($request->ajax()) {
            $subsales = SubSale::all();

            return DataTables::of($subsales)
                ->addIndexColumn()  
                ->addColumn('edit', function ($subsale) {
                    return $subsale->id;
                })
                ->addColumn('delete', function ($subsale) {
                    return $subsale->id;
                })
                ->make(true);
        }

        return view('dashboard.subsales.index');
    }

    public function create()
    {
        $this->authorize('create', SubSale::class);
        $subsales = new SubSale();
        return view('dashboard.subsales.create', compact('subsales'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'amount' => 'required',
            'date' => 'required',
        ]);
       

        $subsale = SubSale::create($request->all());

        return redirect()->route('dashboard.subsales.index')->with('success', __('SubSale created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('update', SubSale::class);
        $subsales = SubSale::findOrFail($id);
        return view('dashboard.subsales.edit', compact('subsales'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('update', SubSale::class);

    $request->validate([
        'amount' => 'required',
            'date' => 'required',
    ]);

    $subsales = SubSale::findOrFail($id);
    $subsales->update($request->all());

    return redirect()->route('dashboard.subsales.index')->with('success', __('SubSale updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', SubSale::class);
        $subsales = SubSale::findOrFail($id);
        $subsales->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.subsales.index')->with('success', __('Item deleted successfully.'));

    }
}
