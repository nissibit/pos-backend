<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\GeneralImport;

class ImportController extends Controller {

    function __construct() {
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        return view('admin.import.index');
    }

    public function create(Request $request) {
        $model = $request->model;
        $class = new $model;
        $table = $class->getTable();
        $tableDesc = \DB::select("DESC {$table}");
        return view('admin.import.create', compact('tableDesc', 'table', 'model'));
    }

    public function store(Request $request) {
        $tableDesc = \DB::select("DESC {$request->table}");
//        dd($tableDesc);
        $keys = array();
        foreach ($tableDesc as $col) {
            if (!in_array($col->Field, array('id', 'created_at', 'updated_at', 'deleted_at'))) {
                array_push($keys, $col->Field);
            }
        }
//        dd($keys);
//        dd($request->all());
        $model = $request->model;

        \Excel::import(new GeneralImport($model, $keys), request()->file('file'));
        return redirect()->route('import.index')->with(['sucesso' => 'Dados importados com sucesso.']);
    }

}
