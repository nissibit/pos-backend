<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Requests\Partner\StorePartner;
use App\Http\Requests\Partner\UpdatePartner;
class PartnerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $partner;
    private $limit = 10;

    function __construct(Partner $partner) {
        $this->partner = $partner;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $partners = $this->partner->latest()->paginate($this->limit);
        return view('partner.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('partner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartner $request) {
        $insert = $this->partner->create($request->all());
        if ($insert) {
            return redirect()->route('partner.show', $insert->id)->with(['sucesso' => 'Cliente criada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da cliente.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner) {
        return view('partner.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partner $partner) {
        return view('partner.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Partner\UpdatePartner  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartner $request, Partner $partner) {
        $partner->fullname = $request->fullname;
        $partner->type = $request->type;
        $partner->nuit = $request->nuit;
        $partner->document_type = $request->document_type;
        $partner->document_number = $request->document_number;
        $partner->phone_nr = $request->phone_nr;
        $partner->phone_nr_2 = $request->phone_nr_2;
        $partner->email = $request->email;
        $partner->address = $request->address;
        $partner->description = $request->description;
        $update = $partner->update();
        if ($update) {
            return redirect()->route('partner.show', $partner->id)->with(['sucesso' => 'Cliente actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da cliente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner) {
        $delete = $partner->delete();
        if ($delete) {
            return redirect()->route('partner.index')->with(['info' => 'Cliente suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da cliente.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $partners = $this->partner->where('id', 'LIKE', '%' . $request->criterio . '%')
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
        return view('partner.search', compact('dados', 'partners'));
    }

    public function searchPartner($string) {
        $partners = $this->partner->where('id', 'LIKE', '%' . $string . '%')
                        ->OrWhere('fullname', 'LIKE', '%' . $string . '%')
                        ->OrWhere('type', 'LIKE', '%' . $string . '%')
                        ->OrWhere('nuit', 'LIKE', '%' . $string . '%')
                        ->OrWhere('document_type', 'LIKE', '%' . $string . '%')
                        ->OrWhere('document_number', 'LIKE', '%' . $string . '%')
                        ->OrWhere('phone_nr', 'LIKE', '%' . $string . '%')
                        ->OrWhere('phone_nr_2', 'LIKE', '%' . $string . '%')
                        ->orWhere('email', 'LIKE', '%' . $string . '%')
                        ->orWhere('address', 'LIKE', '%' . $string . '%')
                        ->orWhere('description', 'LIKE', '%' . $string . '%')
                        ->latest()->take($this->limit)->get();
        return $partners;
    }


}
