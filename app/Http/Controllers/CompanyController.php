<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;

class CompanyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $company;
    private $limit = 10;
    function __construct(Company $company) {
        $this->company = $company;
        $this->middleware("auth");
    }

    public function index() {
        $companies = $this->company->latest()->take($this->limit)->get();
        return view("admin.company.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view("admin.company.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request) {
        $data = $request->all();
        $data['foto'] = $request->foto ?? $request->nuit ?? '';
        $insert = $this->company->create($data);
        if ($insert) {
            return redirect()->route("company.create")->with("sucesso", " Empresa criada com sucesso");
        } else {
            return redirect()->back()->with("falha", "Ocorreu um erro desconhecido ao criar Company.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company) {
        return view("admin.company.show", compact("company"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company) {
        return view("admin.company.edit", compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCompany $request, Company $company) {
        $company->name = $request->name;
        $company->tel = $request->tel;
        $company->fax = $request->fax;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->otherPhone = $request->otherPhone;
        $company->init = $request->init;
        $company->nuit = $request->nuit;
        $company->address = $request->address;
        $company->description = $request->description;

#        $company->status = isset($request->status) ? $request->status : $company->status;

        $update = $company->save();
        if ($update) {
            return redirect()->back()->with("sucesso", "Empresa actualizada com sucesso.");
        } else {
            return redirect()->back()->with("falha", "Falha ao actualizar Company.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company) {
        $nome = $company->name;
        $delete = $company->delete();
        if ($delete) {
            return redirect()->route('company.index')->with("info", " Company '{$nome}' suprimida!");
        } else {
            return redirect()->back()->with("falha", " não foi possível suprimir a company.");
        }
    }

    public function pesquisar(Request $request) {
        $dados = $request->all();
        $companies = Company::where("id", 'like', '%' . $request->criterio . '%')
                ->orWhere("name", 'like', '%' . $request->criterio . '%')
                ->orWhere("foto", 'like', '%' . $request->criterio . '%')
                ->orWhere("tel", 'like', '%' . $request->criterio . '%')
                ->orWhere("fax", 'like', '%' . $request->criterio . '%')
                ->orWhere("email", 'like', '%' . $request->criterio . '%')
                ->orWhere("website", 'like', '%' . $request->criterio . '%')
                ->orWhere("otherPhone", 'like', '%' . $request->criterio . '%')
                ->orWhere("init", 'like', '%' . $request->criterio . '%')
                ->orWhere("nuit", 'like', '%' . $request->criterio . '%')
                ->orWhere("address", 'like', '%' . $request->criterio . '%')
                ->orWhere("description", 'like', '%' . $request->criterio . '%')
                ->latest()
                ->paginate($this->limit);
        return view("admin.company.pesquisar", compact('dados', 'companies'));
    }

}
