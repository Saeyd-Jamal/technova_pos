<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CostBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CostBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', CostBalance::class);

        $request = request();
        if ($request->ajax()) {
            $costbalances = CostBalance::get();

            return DataTables::of($costbalances)
                ->addIndexColumn()
                ->addColumn('edit', function ($costbalance) {
                    return $costbalance->id;
                })
                ->addColumn('delete', function ($costbalance) {
                    return $costbalance->id;
                })
                ->make(true);
        }

        return view('dashboard.cost_balances.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', CostBalance::class);
        $costbalance = new CostBalance();
        $costbalance->funds_statistics = [
            [
                'category' => '100',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '50',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '20',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '10',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '5',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => '1',
                'quantity' => '0',
                'amount' => '0'
            ],
            [
                'category' => 'فراطة',
                'quantity' => '0',
                'amount' => '0'
            ],
        ];

        return view('dashboard.cost_balances.create', compact('costbalance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', CostBalance::class);
        $request->validate([
            'date' => 'required',
            'total_amount' => 'required',
            'quantity-funds*' => 'required|numeric|min:0'
        ]);

        $funds_statistics = [];
        foreach($request->input('quantity-funds') as $key => $value){
            if($key == 'فراطة'){
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * 1
                ];
            }else{
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * $key
                ];
            }
        }

        $request->merge([
            'created_by' => Auth::user()->id,
            'funds_statistics' => json_encode($funds_statistics)
        ]);
        CostBalance::create($request->all());
        return redirect()->route('dashboard.cost_balances.index')->with('success', __('CostBalance created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CostBalance $costBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('update', CostBalance::class);
        $costbalance = CostBalance::findOrFail($id);
        $costbalance->funds_statistics = json_decode($costbalance->funds_statistics, true);
        $btn_label = 'تعديل';
        return view('dashboard.cost_balances.edit', compact('costbalance','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CostBalance $costBalance)
    {
        $request->validate([
            'date' => 'required',
            'total_amount' => 'required',
            'quantity-funds*' => 'required|numeric|min:0'
        ]);

        $funds_statistics = [];
        foreach($request->input('quantity-funds') as $key => $value){
            if($key == 'فراطة'){
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * 1
                ];
            }else{
                $funds_statistics[] = [
                    'category' => $key,
                    'quantity' => $value,
                    'amount' => $value * $key
                ];
            }
        }

        $request->merge([
            'funds_statistics' => json_encode($funds_statistics)
        ]);
        $costBalance->update($request->all());
        return redirect()->route('dashboard.cost_balances.index')->with('success', __('CostBalance updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostBalance $costBalance)
    {
        $this->authorize('delete', CostBalance::class);
        $costBalance->delete();
        $request = request();
        if($request->ajax()){
            return response()->json(['message' => 'Item deleted successfully.']);
        }
        return redirect()->route('dashboard.cost_balances.index')->with('success', __('CostBalance deleted successfully.'));
    }
}
