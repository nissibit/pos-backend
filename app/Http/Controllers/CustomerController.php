<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\StoreCustomer;
use App\Http\Requests\Customer\UpdateCustomer;
use App\Models\Account;
class CustomerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $customer;
    private $limit = 10;

    function __construct(Customer $customer) {
        $this->customer = $customer;
        $this->middleware(['auth', 'revalidate']);
    }

    public function index() {
        $customers = $this->customer->latest()->paginate($this->limit);
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request) {
        $insert = $this->customer->create($request->all());
        if ($insert) {
            return redirect()->route('customer.show', $insert->id)->with(['sucesso' => 'Cliente criada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na criacao da cliente.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer) {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer) {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Customer\UpdateCustomer  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, Customer $customer) {
        $customer->fullname = $request->fullname;
        $customer->type = $request->type;
        $customer->nuit = $request->nuit;
        $customer->document_type = $request->document_type;
        $customer->document_number = $request->document_number;
        $customer->phone_nr = $request->phone_nr;
        $customer->phone_nr_2 = $request->phone_nr_2;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->description = $request->description;
        $update = $customer->update();
        if ($update) {
            return redirect()->route('customer.show', $customer->id)->with(['sucesso' => 'Cliente actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da cliente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer) {
        $delete = $customer->delete();
        if ($delete) {
            return redirect()->route('customer.index')->with(['info' => 'Cliente suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da cliente.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $customers = $this->customer->where('id', 'LIKE', '%' . $request->criterio . '%')
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
        return view('customer.search', compact('dados', 'customers'));
    }

    public function searchCustomer($string) {
        $customers = $this->customer->where('id', 'LIKE', '%' . $string . '%')
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
        return $customers;
    }

    public function getCustomerAutoComplete(Request $request) {
        $string = $request->term ?? '';
        $customers = $this->searchCustomer($string);
        $result = array();
        foreach ($customers as $customer) {
            array_push($result, ['label' => $customer->fullname, 'value' => $customer->id, 'phone_nr' => strtoupper($customer->phone_nr), 'name' => strtoupper($customer->fullname), 'id' => $customer->id, 'nuit' => $customer->nuit, 'address' => $customer->address]);
        }
        return json_encode($result);
    }

//    public function accounts() {
//        $accounts = Account::latest()->take($this->limit)->get();
//        return view('customer.accounts', compact('accounts', 'categories'));
//    }
//
//    public function searchAccounts(Request $request) {
//        $dados = $request->all();
//        $string = $request->criterio;
//        $accounts = Account::where('id', 'LIKE', '%' . $request->criterio . '%')
//                        ->OrWhere('credit', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('debit', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('balance', 'LIKE', '%' . $string . '%')
//                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
//                        ->orWhereHas('accountable', function($query) use ($string) {
//                            $query->where('fullname', 'like', '%' . $string . '%')
//                            ->orWhere('nuit', 'like', '%' . $string . '%')
//                            ->orWhere('phone_nr', 'like', '%' . $string . '%')
//                            ->orWhere('phone_nr_2', 'like', '%' . $string . '%')
//                            ->orWhere('address', 'like', '%' . $string . '%');
//                        })
//                        ->latest()->paginate($this->limit);
//        return view('customer.accounts', compact('dados', 'accounts'));
//    }

}
