<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use App\User;
use OwenIt\Auditing\Models\Audit;

class RoleController extends Controller {

    private $role;
    private $limit = 10;

    function __construct(Role $role) {
        $this->role = $role;
        $this->middleware(['auth', 'revalidate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = $this->role->all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request) {
        $insert = $this->role->create($request->all());
        if ($insert) {
            return redirect()->back()->with("sucesso", "Perfil criado/registado com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao criar/registar perfil.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role) {
        return view('admin.role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role) {
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role) {
        $role->name = $request->name;
        $role->label = $request->label;
        $role->description = $request->description;
        $update = $role->save();
        if ($update) {
            return redirect()->back()->with("sucesso", "Perfil actualizado com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao actualizar perfil.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) {
        $update = $role->delete();
        if ($update) {
            return redirect()->back()->with("info", "Perfil suprimido com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao suprimir perfil.");
        }
    }

    public function setRole() {
        $roles = $this->role->all();
        $users = User::all();
        return view('admin.role.set', compact('roles', 'users'));
    }
    
    public function listSetRole() {
        $roles = $this->role->all();
        $users = User::latest()->paginate($this->limit);
        return view('admin.role.listset', compact('roles', 'users'));
    }

    public function attachRole(\App\Http\Requests\AttachRoleFromUser $request) {
        try {
            if (!is_array($request->role_id)) {
                return redirect()->back()->with("info", "Seleccione ao menos um perfil.");
            }
            $user = User::find($request->user_id);
            $insert = $user->roles()->attach($request->role_id);
            #dd($insert);
            if (!$insert) {
                return redirect()->route('user.show', $request->user_id)->with("sucesso", "Perfil para '{$user->name}' adicionado com sucesso.");
            } else {
                return redirect()->back()->with("falha", "Falha ao adicionar perfil para '{$user->name}'.");
            }
        } catch (\PDOException $e) {
            return redirect()->back()->with("falha", "Erro na base de dados, dados podem estar a ser duplicados.");
        }
    }

    public function detachRole(Request $request) {
        try {
            #dd($request->role_idd);


            $user = User::find($request->user_idd);
            $insert = $user->roles()->detach($request->role_idd);
            #dd($insert);
            if ($insert) {
                return redirect()->back()->with("infoo", "Perfil para '{$user->name}' suprimido com sucesso.");
            } else {
                return redirect()->back()->with("falhaa", "Falha ao suprimir perfil para '{$user->name}'.");
            }
        } catch (\PDOException $e) {
            return redirect()->back()->with("falhaa", "Erro na base de dados, dados podem estar a ser duplicados.");
        }
    }

    public function restoreAll() {
        $restored = $this->role->withTrashed()->restore();
        return redirect()->back()->with("sucesso", "Foram restaurados {$restored} Perfil(s).");
    }

    public function restore($id) {
        $role = $this->role->find($id);
        if ($role == null) {
            return redirect()->route("admin.role.index")->with("info", "Perfil não encontrada.");
        }
        $restored = $role->withTrashed()->restore();
        return redirect()->back()->with("sucesso", "Foram restaurados {$restored} Perfil(s).");
    }

    public function pesquisar(Request $request) {
        $criterio = $request->criterio;
        $roles = $this->role->where('name', 'like', "%{$criterio}%")
                ->orWhere('label', 'like', "%{$criterio}%")
                ->orWhere('created_at', 'like', "%{$criterio}%")
                ->orWhere('updated_at', 'like', "%{$criterio}%")
                ->latest()
                ->paginate($this->limit);
        $dados = $request->all();
        return view("admin.role.pesquisar", compact("roles", "dados"));
    }

}
