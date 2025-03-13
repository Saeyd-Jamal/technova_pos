<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RevolvingBalanceBill;
use Yajra\DataTables\Facades\DataTables;

class RevolvingBalanceBillController extends Controller
{
    public function index()
    {
        $this->authorize('view', RevolvingBalanceBill::class);

        $request = request();
        if ($request->ajax()) {
            $revolvingbalancebills = RevolvingBalanceBill::all();

            return DataTables::of($revolvingbalancebills)
                ->addIndexColumn()  
                ->addColumn('edit', function ($revolvingbalancebill) {
                    return $revolvingbalancebill->id;
                })
                ->addColumn('delete', function ($revolvingbalancebill) {
                    return $revolvingbalancebill->id;
                })
                ->make(true);
        }

        return view('dashboard.revolvingbalancebills.index');
    }

    public function create()
    {
        $this->authorize('create', RevolvingBalanceBill::class);
        $revolvingbalancebills = new RevolvingBalanceBill();
        return view('dashboard.revolvingbalancebills.create', compact('revolvingbalancebills'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'date' => 'required',
            
           
        ]);
       

        $revolvingbalancebill = RevolvingBalanceBill::create($request->all());

        return redirect()->route('dashboard.revolvingbalancebills.index')->with('success', __('RevolvingBalanceBill created successfully.'));
    }

    public function edit($id)
    {
        $this->authorize('update', RevolvingBalanceBill::class);
        $revolvingbalancebills = RevolvingBalanceBill::findOrFail($id);
        return view('dashboard.revolvingbalancebills.edit', compact('revolvingbalancebills'));
    }

    


    public function update(Request $request, $id)
{
    $this->authorize('update', RevolvingBalanceBill::class);

    $request->validate([
        'name' => 'required',
        'amount' => 'required',
        'date' => 'required',
        
       
    ]);

    $revolvingbalancebills = RevolvingBalanceBill::findOrFail($id);
    $revolvingbalancebills->update($request->all());

    return redirect()->route('dashboard.revolvingbalancebills.index')->with('success', __('RevolvingBalanceBill updated successfully.'));
}


    public function destroy($id)
    {

        $this->authorize('delete', RevolvingBalanceBill::class);
        $revolvingbalancebills = RevolvingBalanceBill::findOrFail($id);
        $revolvingbalancebills->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.revolvingbalancebills.index')->with('success', __('Item deleted successfully.'));

    }
}
