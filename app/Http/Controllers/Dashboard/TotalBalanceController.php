<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\TotalBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TotalBalanceController extends Controller
{
    public function index()
    {
        $this->authorize('view', TotalBalance::class);

        $request = request();
        if ($request->ajax()) {
            $totalbalances = TotalBalance::all();

            return DataTables::of($totalbalances)
                ->addIndexColumn()  
                ->addColumn('edit', function ($totalbalance) {
                    return $totalbalance->id;
                })
                ->addColumn('delete', function ($totalbalance) {
                    return $totalbalance->id;
                })
                ->make(true);
        }

        return view('dashboard.totalbalances.index');
    }

    public function create()
    {
        $this->authorize('create', TotalBalance::class);
        $totalbalances = new TotalBalance();
        return view('dashboard.totalbalances.create', compact('totalbalances'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'source' => 'required',
            'amount' => 'required',
            'date' => 'required', 
        ]);
       

        $totalbalance = TotalBalance::create($request->all());

        return redirect()->route('dashboard.totalbalances.index')->with('success', __('TotalBalance created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('update', TotalBalance::class);
        $totalbalances = TotalBalance::findOrFail($id);
        return view('dashboard.totalbalances.edit', compact('totalbalances'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('update', TotalBalance::class);

    $request->validate([
            'source' => 'required',
            'amount' => 'required',
            'date' => 'required', 
    ]);

    $totalbalances = TotalBalance::findOrFail($id);
    $totalbalances->update($request->all());

    return redirect()->route('dashboard.totalbalances.index')->with('success', __('TotalBalance updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', TotalBalance::class);
        $totalbalances = TotalBalance::findOrFail($id);
        $totalbalances->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.totalbalances.index')->with('success', __('Item deleted successfully.'));

    }
}
