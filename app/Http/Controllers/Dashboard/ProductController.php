<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('view', Product::class);

        $request = request();
        if ($request->ajax()) {
            $products = Product::with('user','category')->select(['id', 'name', 'image', 'description', 'status', 'created_by','category_id']);

            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('status', function ($product) {
                    return $product->status == 'active' ? 'نشط' : 'مؤرشف';
                })
                ->addColumn('category_name', function ($product) {
                    return $product->category ? $product->category->name : 'No Category'; // إرجاع اسم الكاتيجوري
                })
                ->addColumn('created_by', function ($product) {
                    return $product->user->name ?? 'غير محدد';
                })
                ->addColumn('edit', function ($product) {
                    return $product->id;
                })
                ->addColumn('delete', function ($product) {
                    return $product->id;
                })
                ->make(true);
        }

        return view('dashboard.products.index');
    }

    public function create()
    {
        $this->authorize('create', Product::class);
        $products = new Product();
        $categories = Category::all();
        

        return view('dashboard.products.create', compact('products','categories'));
    }

    public function store(Request $request)
    {

       

        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'status' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
        ]);
        
        


        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // upload obj
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        $products = Product::create($data);

        return redirect()->route('dashboard.products.index')->with('success', __('Product created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('edit', Product::class);
        $products = Product::findOrFail($id);
        $categories = Category::all();
        return view('dashboard.products.edit', compact('products','categories'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', Product::class);

    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image',
        'description' => 'required',
        'status' => 'required',
        'category_id' => 'required|integer|exists:categories,id',

    ]);

   
    $products = Product::findOrFail($id);

    $old_image =  $products->image; 
    $data = $request->except('image'); 

    if ($request->hasFile('image')) {
      
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        $data['image'] = $path; 
    }

   
    $products->update($data);

   
    if ($old_image && isset($data['image'])) {
        Storage::disk('public')->delete($old_image);
    }

    return redirect()->route('dashboard.products.index')->with('success', __('Category updated successfully.'));
}



    public function destroy($id)
    {

        $this->authorize('delete', Product::class);
        $products = Product::findOrFail($id);
        $products->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.products.index')->with('success', __('Item deleted successfully.'));

    }
}
