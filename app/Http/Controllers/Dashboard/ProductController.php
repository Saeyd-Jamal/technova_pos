<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuantityType;
use App\Models\Size;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('view', Product::class);

        $request = request();
        if ($request->ajax()) {
            $products = Product::with('user', 'category')->select(['id', 'name', 'image', 'description', 'status', 'created_by', 'category_id']);

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
                ->addColumn('action', function ($product) {
                    return $product->id;
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
        $product = new Product();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $sizes = Size::all();
        $quantityTypes = QuantityType::all();
        return view('dashboard.products.create', compact('product', 'categories', 'suppliers', 'sizes', 'quantityTypes'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'imageFile' => 'nullable|image',
                'description' => 'nullable|string',
                'status' => 'required',
                'category_id' => 'required|integer|exists:categories,id',
                'qr_code' => 'nullable|string|unique:products,qr_code',
            ]);
            if ($request->hasFile('imageFile')) {
                $file = $request->file('imageFile'); // upload obj
                $path = $file->store('uploads', [
                    'disk' => 'public'
                ]);
                $request->merge([
                    'image' => $path
                ]);
            }
            $product = Product::create($request->all());

            if ($request->flavors != null) {
                $flavors = json_decode($request->flavors);
                $flavors = collect($flavors);
                $flavors_count = $flavors->count();
                for ($i = 0; $i < $flavors_count; $i++) {
                    $flavor = $product->flavors()->create([
                        'name' => $request["name-" . $i],
                        'image' => $request["image-" . $i]
                    ]);

                    $sizes_count = $flavors[$i]->sizes;
                    for ($j = 0; $j < $sizes_count; $j++) {
                        $stock = Stock::create([
                            'product_id' => $product->id,
                            'flavor_id' => $flavor->id,
                            'size_id' => $request["size-" . $i . "-" . $j],
                            'quantity_type_id' => $request["unit_type-" . $i . "-" . $j],
                            'quantity' => $request["quantity-" . $i . "-" . $j],
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // throw $e;
            return redirect()->route('dashboard.products.index')->with('danger', $e->getMessage());
        }
        return redirect()->route('dashboard.products.index')->with('success', __('Product created successfully.'));
    }


    public function show($id)
    {

        $products = Product::with('flavors')->findOrFail($id);

        // إرسال المنتج إلى الصفحة لعرض التفاصيل
        return view('dashboard.products.show', compact('products'));
    }


    public function edit($id)
    {
        $this->authorize('update', Product::class);
        $product = Product::with('flavors','category')->findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        $sizes = Size::all();
        $quantityTypes = QuantityType::all();
        $btn_label = "تعديل";
        return view('dashboard.products.edit', compact('product', 'categories', 'suppliers', 'sizes', 'quantityTypes','btn_label'));
    }




    public function update(Request $request, $id)
    {
        $this->authorize('update', Product::class);
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'imageFile' => 'nullable|image',
                'description' => 'nullable|string',
                'status' => 'required',
                'category_id' => 'required|integer|exists:categories,id',
                'qr_code' => 'nullable|string|unique:products,qr_code,'.$id,
            ]);
            $old_image = $request->old_image;
            if ($request->hasFile('imageFile')) {
                $file = $request->file('imageFile'); // upload obj
                $path = $file->store('uploads', [
                    'disk' => 'public'
                ]);
                $request->merge([
                    'image' => $path
                ]);
            }
            $product = Product::findOrFail($id);

            $product->update($request->all());

            if ($request->flavors != null) {
                $product->flavors()->delete();
                $flavors = json_decode($request->flavors);
                $flavors = collect($flavors);
                $flavors_count = $flavors->count();
                for ($i = 0; $i < $flavors_count; $i++) {
                    $flavor = $product->flavors()->create([
                        'name' => $request["name-" . $i],
                        'image' => $request["image-" . $i]
                    ]);

                    $sizes_count = $flavors[$i]->sizes;
                    for ($j = 0; $j < $sizes_count; $j++) {
                        $stock = Stock::create([
                            'product_id' => $product->id,
                            'flavor_id' => $flavor->id,
                            'size_id' => $request["size-" . $i . "-" . $j],
                            'quantity_type_id' => $request["unit_type-" . $i . "-" . $j],
                            'quantity' => $request["quantity-" . $i . "-" . $j],
                        ]);
                    }
                }
            }
            if ($old_image && $request->hasFile('imageFile')) {
                Storage::disk('public')->delete($old_image);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // throw $e;
            return redirect()->route('dashboard.products.index')->with('danger', $e->getMessage());
        }

        return redirect()->route('dashboard.products.index')->with('success', __('Category updated successfully.'));
    }



    public function destroy($id)
    {
        $this->authorize('delete', Product::class);
        $products = Product::findOrFail($id);
        $products->delete();
        $request = request();
        if ($request->ajax()) {
            return response()->json(['message' => 'تم حذف المنتج بنجاح']);
        }
        return redirect()->route('dashboard.products.index')->with('success', __('Item deleted successfully.'));
    }


    public function search(Request $request)
    {
        $products = Product::with(['flavors','category','stock']);
        // name : $('#name_search').val(),
        //                 category_id : $('#category_id_search').val(),
        //                 qr_code : $('#qr_code_search').val(),
        if($request->name != null){
            $products->where('name', 'like', "%{$request->name}%");
        }
        if($request->category_id != null){
            $products->where('category_id', $request->category_id);
        }
        if($request->qr_code != null){
            $products->where('qr_code', "$request->qr_code");
        }

        $stocks = Stock::whereIn('product_id', $products->pluck('id')->toArray())->get()->map(function ($stock) {
            $stock->name = $stock->product->name;
            $stock->category_name = $stock->product->category->name;
            $stock->flavor = $stock->flavor->name;
            $stock->price = $stock->product->price;
            $stock->quantity = $stock->quantity;
            return $stock;
        });
        return response()->json($stocks);
    }
}
