<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('view', Category::class);

        $request = request();
        if ($request->ajax()) {
            $categories = Category::with('user')->select(['id', 'name', 'image', 'slug', 'description', 'status', 'created_by']);

            return DataTables::of($categories)
                ->addIndexColumn()
                ->editColumn('status', function ($category) {
                    return $category->status == 'active' ? 'نشط' : 'مؤرشف';
                })
                ->addColumn('created_by', function ($category) {
                    return $category->user->name ?? 'غير محدد';
                })
                ->addColumn('edit', function ($category) {
                    return $category->id;
                })
                ->addColumn('delete', function ($category) {
                    return $category->id;
                })
                ->make(true);
        }

        return view('dashboard.categories.index');
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        $categories = new Category();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {

       

        $request->validate([
            'name' => 'required',
            'image' => 'required|image',
           // 'slug' => 'required|unique:categories',
            'description' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());
        $request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);


        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // upload obj
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        $category = Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success', __('Category created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('edit', Category::class);
        $categories = Category::findOrFail($id);
        return view('dashboard.categories.edit', compact('categories'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('edit', Category::class);

    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image',
        'description' => 'required',
        'status' => 'required',
    ]);

    $categories = Category::findOrFail($id);

    $old_image =  $categories->image; 
    $data = $request->except('image'); 

    if ($request->hasFile('image')) {
      
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        $data['image'] = $path; 
    }

   
    $categories->update($data);

   
    if ($old_image && isset($data['image'])) {
        Storage::disk('public')->delete($old_image);
    }

    return redirect()->route('dashboard.categories.index')->with('success', __('Category updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', Category::class);
        $categories = Category::findOrFail($id);
        $categories->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.categories.index')->with('success', __('Item deleted successfully.'));

    }
}
