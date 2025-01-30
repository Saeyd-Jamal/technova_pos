<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends Controller
{
    public function index()
    {
        $this->authorize('view', Size::class);

        $request = request();
        if ($request->ajax()) {
            $sizes = Size::select([ 'id', 'name', 'unit']);

            return DataTables::of($sizes)
                ->addIndexColumn()
               
                ->addColumn('edit', function ($size) {
                    return $size->id;
                })
                ->addColumn('delete', function ($size) {
                    return $size->id;
                })
                ->make(true);
        }

        return view('dashboard.sizes.index');
    }

    public function create()
    {
        $this->authorize('create', Size::class);
        $sizes = new Size();
      
        return view('dashboard.sizes.create', compact('sizes'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            
        ]);
        
        $sizes = Size::create($request->all());

        return redirect()->route('dashboard.sizes.index')->with('success', __('Size created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('edit', Size::class);
        $sizes = Size::findOrFail($id);
       
        return view('dashboard.sizes.edit', compact('sizes'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', Size::class);

    $request->validate([
        'name' => 'required',
        'unit'=> 'required',

    ]);

   
    $sizes = Size::findOrFail($id);

    $sizes->update($request->all());
 
    return redirect()->route('dashboard.sizes.index')->with('success', __('Size updated successfully.'));
}



    public function destroy($id)
    {

        $this->authorize('delete', Size::class);
        $sizes = Size::findOrFail($id);
        $sizes->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.sizes.index')->with('success', __('Item deleted successfully.'));

    }
}
