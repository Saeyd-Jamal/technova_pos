<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\BankBalance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BankBalanceController extends Controller
{
    public function index()
    {
        $this->authorize('view', BankBalance::class);

        $request = request();
        if ($request->ajax()) {
            $bankbalances = BankBalance::all();

            return DataTables::of($bankbalances)
                ->addIndexColumn()  
                ->addColumn('edit', function ($bankbalance) {
                    return $bankbalance->id;
                })
                ->addColumn('delete', function ($bankbalance) {
                    return $bankbalance->id;
                })
                ->make(true);
        }

        return view('dashboard.bankbalances.index');
    }

    public function create()
    {
        $this->authorize('create', BankBalance::class);
        $bankbalances = new BankBalance();
        return view('dashboard.bankbalances.create', compact('bankbalances'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'type' => 'required',
           
        ]);
       

        $bankbalance = BankBalance::create($request->all());

        return redirect()->route('dashboard.bankbalances.index')->with('success', __('BankBalance created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('update', BankBalance::class);
        $bankbalances = BankBalance::findOrFail($id);
        return view('dashboard.bankbalances.edit', compact('bankbalances'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('update', BankBalance::class);

    $request->validate([
        'name' => 'required',
        'amount' => 'required',
        'date' => 'required',
        'type' => 'required',
       
    ]);

    $bankbalances = BankBalance::findOrFail($id);
    $bankbalances->update($request->all());

    return redirect()->route('dashboard.bankbalances.index')->with('success', __('BankBalance updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', BankBalance::class);
        $bankbalances = BankBalance::findOrFail($id);
        $bankbalances->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.bankbalances.index')->with('success', __('Item deleted successfully.'));

    }
}
