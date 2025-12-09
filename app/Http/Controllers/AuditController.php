<?php

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use DB;
use App\Models\Factura;

class AuditController extends Controller {

    private $audit;
    private $limit = 10;

    function __construct(Audit $audit) {
        $this->audit = $audit;
        $this->middleware(['auth', 'revalidate']);
    }

    /** Audite */
    public function index() {
        $audits = $this->audit->latest()->take($this->limit)->get();
        #dd($audits);
        return view('admin.audit.index', compact('audits'));
    }

    /*
     * Get audit for any item
     */

    public function audit(Request $request) {
        $dados = $request->all();
        $name = $request->name;
        $model = $request->model;
        $class = class_basename($model);
        $entity = $model::where('id', $request->id)->withTrashed()->first();
        $audits = null;
        if ($request->from_search != null) {
            $audits = $entity->audits()->whereBetween(DB::raw('DATE(created_at)'), array($request->from_search, $request->to_search))->latest()->get();
        } else {
            $audits = $entity->audits()->latest()->get();
        }
        return view('audit.index', compact('audits', 'class', 'name', 'model', 'dados'));
//        return view('product.audit', compact('audits', 'class', 'name'));
    }

    public function searchEntity(Request $request) {
        $dados = $request->all();
        $id = $request->id;
        $data = $this->audit->latest();
        $model = $request->model;        
        $name = $request->name;
        $class = class_basename($model);
        
        if ($model != 'All') {
            $model = substr($request->model, 1);
        }
        $type = $model == 'All' ? '*' : $model;
       dd($request->all());
        $data_final = $data->whereHasMorph("auditable", $type, function($query) use ($request) {
            $query->where("auditable_id", $request->id)
                    ->whereDate("created_at", '>=', $request->from_search)
                    ->whereDate("created_at", '<=', $request->to_search);
        });
//        dd($data_final);
        $audits = $data_final->paginate($this->limit);
        return view('audit.index', compact('audits', 'id', 'class', 'name', 'model', 'dados'));

        //return view('audit.index', compact('audits', 'model', 'dados'));
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $data = $this->audit->latest();
        $model = $request->model;
        if ($model != 'All') {
            $model = substr($request->model, 1);
        }
        $type = $model == 'All' ? '*' : $model;
        $data_final = $data->whereHasMorph("auditable", $type, function($query) use ($string) {
            $query->where("old_values", 'like', '%' . $string . '%')
                    ->orWhere("new_values", 'like', '%' . $string . '%');
        });
        $audits = $data_final->paginate($this->limit);
        return view('admin.audit.search', compact('audits', 'model', 'dados'));
    }

    public function auditFacturaTrashed() {
        $facturas = Factura::onlyTrashed()->latest()->paginate($this->limit);
        return view('admin.factura.index', compact('facturas'));
    }

    public function auditFacturaTrashedSearch(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $facturas = Factura::onlyTrashed()->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_name', 'LIKE', '%' . $string . '%')
                        ->OrWhere('customer_phone', 'LIKE', '%' . $string . '%')
                        ->OrWhere('subtotal', 'LIKE', '%' . $string . '%')
                        ->OrWhere('totalrate', 'LIKE', '%' . $string . '%')
                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
                        ->OrWhere('total', 'LIKE', '%' . $string . '%')
                        ->OrWhere('day', 'LIKE', '%' . $string . '%')
                        ->OrWhere('payed', 'LIKE', '%' . $string . '%')
                        ->whereHas('audits', function($query) {
                            $query->where('event', 'deleted');
                        })->latest()->paginate($this->limit);
        return view('admin.factura.index', compact('facturas', 'dados'));
    }

}
