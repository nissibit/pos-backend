<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use App\Http\Requests\Server\StoreServer;
use App\Http\Requests\Server\UpdateServer;
use DB;
class ServerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $server;
    private $limit = 10;

    function __construct(Server $server) {
        $this->server = $server;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $servers = $this->server->latest()->take($this->limit)->get();
        return view('server.index', compact('servers', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('server.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServer $request) {
        DB::beginTransaction();
        try {
            $insert = $this->server->create($request->all());
            $insert->account()->create(['extra_price' => 0]);
            DB::commit();
            return redirect()->route('server.show', $insert->id)->with(['sucesso' => 'Fornecedor criado com sucesso.']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['falha' => 'Falha na criacao da fornecedor: '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server) {
        return view('server.show', compact('server'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server) {
        return view('server.edit', compact('server'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Server\UpdateServer  $request
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServer $request, Server $server) {
        $server->fullname = $request->fullname;
        $server->type = $request->type;
        $server->nuit = $request->nuit;
        $server->document_type = $request->document_type;
        $server->document_number = $request->document_number;
        $server->phone_nr = $request->phone_nr;
        $server->phone_nr_2 = $request->phone_nr_2;
        $server->email = $request->email;
        $server->address = $request->address;
        $server->description = $request->description;
        $update = $server->update();
        if ($update) {
            return redirect()->route('server.show', $server->id)->with(['sucesso' => 'Fornecedor actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da fornecedor.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server) {
        $delete = $server->delete();
        if ($delete) {
            return redirect()->route('server.index')->with(['info' => 'Fornecedor suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da fornecedor.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $servers = $this->server->where('id', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('fullname', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('type', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('nuit', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('document_type', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('document_number', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('phone_nr', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('phone_nr_2', 'LIKE', '%' . $request->criterio . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->criterio . '%')
                        ->orWhere('address', 'LIKE', '%' . $request->criterio . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->criterio . '%')
                        ->latest()->paginate($this->limit);
        return view('server.search', compact('dados', 'servers'));
    }

}
