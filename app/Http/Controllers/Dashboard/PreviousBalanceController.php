<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\PreviousBalance;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PreviousBalanceController extends Controller
{
    public function index()
    {
        $this->authorize('view', PreviousBalance::class);

        $request = request();
        if ($request->ajax()) {
            $previousbalances = PreviousBalance::all();

            return DataTables::of($previousbalances)
                ->addIndexColumn()  
                ->addColumn('edit', function ($previousbalance) {
                    return $previousbalance->id;
                })
                ->addColumn('delete', function ($previousbalance) {
                    return $previousbalance->id;
                })
                ->make(true);
        }

        return view('dashboard.previousbalances.index');
    }

    public function create()
    {
        $this->authorize('create', PreviousBalance::class);
        $previousbalances = new PreviousBalance();
        return view('dashboard.previousbalances.create', compact('previousbalances'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'month' => 'required',
            'amount' => 'required',
            'type' => 'required',
           
        ]);
       

        $previousbalance = PreviousBalance::create($request->all());

        return redirect()->route('dashboard.previousbalances.index')->with('success', __('PreviousBalance created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('update', PreviousBalance::class);
        $previousbalances = PreviousBalance::findOrFail($id);
        return view('dashboard.previousbalances.edit', compact('previousbalances'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('update', PreviousBalance::class);

    $request->validate([
            'month' => 'required',
            'amount' => 'required',
            'type' => 'required',
       
    ]);

    $previousbalances = PreviousBalance::findOrFail($id);
    $previousbalances->update($request->all());

    return redirect()->route('dashboard.previousbalances.index')->with('success', __('PreviousBalance updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', PreviousBalance::class);
        $previousbalances = PreviousBalance::findOrFail($id);
        $previousbalances->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.previousbalances.index')->with('success', __('Item deleted successfully.'));

    }
}
