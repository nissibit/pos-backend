<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \OwenIt\Auditing\Models\Audit;
use App\User;

class RestoreController extends Controller {

    private $audit;
    private $limit = 10;

    function __construct(Audit $audit) {
        $this->audit = $audit;
    }

    /** Audite */
    public function index() {
        $audits = $this->audit->latest()->where('event', 'deleted')->take($this->limit)->get();
        #dd($audits);
        return view('admin.restore.index', compact('audits'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \OwenIt\Auditing\Models\Audit;  $audit
     * @return Response
     */
    public function show($id) {
        $audit = Audit::findOrfail($id);
        return view('admin.restore.show', compact('audit'));
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $data = $this->audit->latest()->where('event', 'deleted');
        $model = $request->model;
        if ($model != 'All') {
            $model = substr($request->model, 1);
            $data = $data->where("auditable_type", $model);
        }
        //dd($model);
        $data_final = $data->where("old_values", 'like', '%' . $string . '%');
        $audits = $data_final->paginate($this->limit);
        return view('admin.restore.search', compact('audits', 'model', 'dados'));
    }

    public function restoreEntity(Request $request) {
        $audit = json_decode($request->audit);
        $model = $audit->auditable_type;
        $model_id = $audit->auditable_id;
        $entity = $model::withTrashed()->find($model_id)->restore();
        if ($entity) {
            return redirect()->route('restore.index')->with(['sucesso' => 'Entidade restaurado!']);
        } else {
            return redirect()->back()->with(['falha' => 'Erro na execução!']);
        }
    }

}
