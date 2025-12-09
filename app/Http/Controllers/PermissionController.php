<?php

namespace App\Http\Controllers;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $permission;
    private $limit = 10;

    function __construct(Permission $permission) {
        $this->permission = $permission;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $permissions = $this->permission->latest()->take($this->limit)->get();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
       return view("admin.permission.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $insert = $this->permission->create($request->all());
        if ($insert) {
            return redirect()->back()->with("sucesso", "Permissao criada/registadoacom sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao criar/registar permissao.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission) {
        return view('admin.permission.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission) {
        //
    }

    public function setPermission() {
        $roles = Role::where("id", ">", "1")->get();
        $permissions = $this->permission->latest()->orderBy('name')->paginate($this->limit);
        return view('admin.permission.set', compact('roles', 'permissions'));
    }

    public function attachPermission(Request $request) {
        try {
            if (!is_array($request->permission_id)) {
                return redirect()->back()->with("info", "Seleccione ao menos uma permissão.");
            }
            $role = Role::find($request->role_id);
            $insert = $role->permissions()->attach($request->permission_id);
            #dd($insert);
            if (!$insert) {
                return redirect()->back()->with("sucesso", "Permissão para o perfil '{$role->name}' adicionada com sucesso.");
            } else {
                return redirect()->back()->with("falha", "Falha ao adicionar Permissão para o perfil '{$role->name}'.");
            }
        } catch (\PDOException $e) {
            return redirect()->back()->with("falha", "Erro na base de dados, dados podem estar a ser duplicados.");
        }
    }

    public function detachPermission(Request $request) {
        try {
            #dd($request->role_idd);
            $role = User::find($request->role_idd);
            $insert = $role->permissions()->detach($request->permission_idd);
            #dd($insert);
            if ($insert) {
                return redirect()->back()->with("infoo", "Perfil para '{$role->name}' suprimida com sucesso.");
            } else {
                return redirect()->back()->with("falhaa", "Falha ao suprimir permissão para '{$role->name}'.");
            }
        } catch (\PDOException $e) {
            return redirect()->back()->with("falhaa", "Erro na base de dados, dados podem estar a ser duplicados.");
        }
    }

    public function restoreAll() {
        return $this->permission->withTrashed()->restore();
    }

    public function restore($id) {
        $permission = $this->permission->find($id);
        if ($permission == null) {
            return redirect()->route("admin.permission.index")->with("info", "Regra não encontrada.");
        }
        return $permission->withTrashed()->restore();
    }

    public function pesquisar(Request $request) {
        $criterio = $request->criterio;
        $permissions = $this->permission->where('name', 'like', "%{$criterio}%")
                ->orWhere('label', 'like', "%{$criterio}%")
                ->orWhere('created_at', 'like', "%{$criterio}%")
                ->orWhere('updated_at', 'like', "%{$criterio}%")
                ->latest()
                ->paginate($this->limit);
        $dados = $request->all();
        return view("admin.permission.pesquisar", compact("permissions", "dados"));
    }

}
