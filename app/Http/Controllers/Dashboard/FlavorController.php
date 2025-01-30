<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Flavor;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FlavorController extends Controller
{
    public function index()
    {
        $this->authorize('view', Flavor::class);

        $request = request();
        if ($request->ajax()) {
            $flavors = Flavor::with('product')->select(['id','name','image','product_id']);

            return DataTables::of($flavors)
                ->addIndexColumn()
                ->addColumn('product_name', function ($flavor) {
                    return $flavor->product ? $flavor->product->name : 'No Product'; // إرجاع اسم الكاتيجوري
                })
               
                ->addColumn('edit', function ($flavor) {
                    return $flavor->id;
                })
                ->addColumn('delete', function ($flavor) {
                    return $flavor->id;
                })
                ->make(true);
        }

        return view('dashboard.flavors.index');
    }

    public function create()
    {
        $this->authorize('create', Flavor::class);
        $flavors = new Flavor();
        $products = Product::all();
        

        return view('dashboard.flavors.create', compact('flavors','products'));
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'product_id' => 'required|integer|exists:products,id',
        ]);
        
        
        


        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // upload obj
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        $flavors = Flavor::create($data);

        return redirect()->route('dashboard.flavors.index')->with('success', __('Flavor created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('edit', Flavor::class);
        $flavors = Flavor::findOrFail($id);
        $products = Product::all();
        return view('dashboard.flavors.edit', compact('flavors','products'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', Flavor::class);

    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image',
        'product_id' => 'required|integer|exists:products,id',
       
    ]);

   
    $flavors = Flavor::findOrFail($id);

    $old_image =  $flavors->image; 
    $data = $request->except('image'); 

    if ($request->hasFile('image')) {
      
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        $data['image'] = $path; 
    }

   
    $flavors->update($data);

   
    if ($old_image && isset($data['image'])) {
        Storage::disk('public')->delete($old_image);
    }

    return redirect()->route('dashboard.flavors.index')->with('success', __('Category updated successfully.'));
}



    public function destroy($id)
    {

        $this->authorize('delete', Flavor::class);
        $flavors = Flavor::findOrFail($id);
        $flavors->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.flavors.index')->with('success', __('Item deleted successfully.'));

    }
}
