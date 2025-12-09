<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Reinforcement;
use Illuminate\Http\Request;
use App\Http\Requests\Reinforcement\StoreReinforcement;
use App\Http\Requests\Reinforcement\UpdateReinforcement;
use DB;

class ReinforcementController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $reinforcement;
    private $limit = 10;

    function __construct(Reinforcement $reinforcement) {
        $this->reinforcement = $reinforcement;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $fund = auth()->user()->fund->where('endtime', null)->first();
        if ($fund == null) {
            return redirect()->back()->with(['info' => 'Abra ao caixa primeiro.']);
        }
        $reinforcements = $fund->reinforcements()->latest()->paginate($this->limit);
        return view('reinforcement.index', compact('reinforcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $fund = auth()->user()->fund->where('endtime', null)->first();        
        return view('reinforcement.create', compact('fund'));
    }

    /**
     * Reinforcement a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReinforcement $request) {
        DB::beginTransaction();
        try {
            $fund = Fund::find($request->fund_id);
            $fund->present += $request->amount;
            $fund->update();
            $insert = $this->reinforcement->create($request->all());
            DB::commit();
            return redirect()->route('fund.show', $insert->fund_id)->with(['sucesso' => 'Reforço criado com sucesso.']);
            
         } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['falha' => 'Falha na criacao da Reforço.: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reinforcement  $reinforcement
     * @return \Illuminate\Http\Response
     */
    public function show(Reinforcement $reinforcement) {
        return view('reinforcement.show', compact('reinforcement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reinforcement  $reinforcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Reinforcement $reinforcement) {
        $stores = Store::all();
        $fund = Fund::find($reinforcement->fund_id ?? 0);
        // return redirect()->route('fund.show', $reinforcement->fund_id)->with(['sucesso' => 'Reinforcement actualizado com sucesso.']);
        return view('reinforcement.edit', compact('reinforcement', 'stores', 'fund'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Fund\UpdateReinforcement  $request
     * @param  \App\Models\Reinforcement  $reinforcement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReinforcement $request, Reinforcement $reinforcement) {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reinforcement  $reinforcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reinforcement $reinforcement) {
        DB::beginTransaction();
        try {
            $fund = $reinforcement->fund;
            $fund->present -= $reinforcement->amount;
            $fund->update();
            $delete = $reinforcement->delete();
            DB::commit();
            return redirect()->route('fund.index')->with(['info' => 'Reforço suprimida com sucesso.']);
        } catch (\Exceprion $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with(['falha' => 'Falha ao suprimir Reforço.: ' . $e->getMessage()]);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $reinforcements = Reinforcement::whereHas("fund", function($query) use ($string) {
                    $query->where("amount", 'like', '%' . $string . '%')
                    ->orWhere("description", 'like', '%' . $string . '%');
                })
                ->orWhereHas('fund.user', function($store) use($string) {
                    $store->where("name", 'like', '%' . $string . '%')
                    ->orWhere("username", 'like', '%' . $string . '%')
                    ;
                })
                ->paginate($this->limit);
        return view('reinforcement.search', compact('dados', 'reinforcements'));
    }

    public function audit(Request $request) {
        $audits = $this->reinforcement->find($request->id)->audits()->with('user')->get();
        dd($audits);
    }

}
