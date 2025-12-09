<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Server;
use App\Http\Requests\Customer\StoreAccount;
use App\Http\Requests\Customer\UpdateAccount;

class AccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $account;
    private $limit = 10;

    function __construct(Account $account) {
        $this->account = $account;
        $this->middleware(['auth', 'revalidate']);
//        
    }

    public function index() {
        $accounts = $this->account->orderBy('accountable_type')->latest()->paginate($this->limit);
        return view('account.index', compact('accounts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $customers = Customer::latest()->get();
        return view('account.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccount $request) {
//        dd($request->all());
        if (isset($request->customer_id)) {
            $model = Customer::find($request->customer_id);
        } elseif (isset($request->server_id)) {
            $model = Server::find($request->server_id);
        } else {
            $model = null;
        }
        if ($model->account()->count() > 0) {
            return redirect()->back()->with(['info' => 'O Cliente/Fornecedor já tem uma conta criada.', 'tab' => 'conta'])->withInput();
        }
        if ($model != null) {
            $model->account()->create($request->all());
            if (isset($request->customer_id)) {
                return redirect()->route('customer.show', $request->customer_id)->with(['sucesso' => 'Conta criada com sucesso.', 'tab' => 'conta']);
            } else {
                return redirect()->route('server.show', $request->server_id)->with(['sucesso' => 'Conta criada com sucesso.', 'tab' => 'conta']);
            }
        } else {
            return redirect()->back()->with(['falha' => 'Falha na criacao da conta.', 'tab' => 'conta'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account) {
        return view('account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account) {
        $customers = Customer::latest()->get();
        return view('account.edit', compact('account', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Account\UpdateAccount  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccount $request, Account $account) {
        $account->credit = $request->credit;
        $account->debit = $request->debit;
        $account->balance = $request->balance;
        $account->discount = $request->discount;
        $account->days = $request->days;
        $account->extra_price = $request->extra_price;
        $update = $account->update();
        if ($update) {
            return redirect()->route('account.show', $account->id)->with(['sucesso' => 'Conta actualizada com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da conta.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account) {
        $delete = $account->delete();
        if ($delete) {
            return redirect()->route('account.index')->with(['info' => 'Conta suprimida com sucesso.']);
        } else {
            return redirect()->back()->with(['sucesso' => 'Falha na supressao da conta.']);
        }
    }

    public function search(Request $request) {
        $dados = $request->all();
        $string = $request->criterio;
        $accounts = $this->account->where('id', 'LIKE', '%' . $request->criterio . '%')
                        ->OrWhere('credit', 'LIKE', '%' . $string . '%')
                        ->OrWhere('debit', 'LIKE', '%' . $string . '%')
                        ->OrWhere('balance', 'LIKE', '%' . $string . '%')
                        ->OrWhere('discount', 'LIKE', '%' . $string . '%')
                        ->OrWhereHasMorph('accountable', '*', function($query) use ($string) {
                            $query->where('fullname', 'like', '%' . $string . '%')
                            ->orWhere('nuit', 'like', '%' . $string . '%')
                            ->orWhere('phone_nr', 'like', '%' . $string . '%')
                            ->orWhere('phone_nr_2', 'like', '%' . $string . '%')
                            ->orWhere('address', 'like', '%' . $string . '%');
                        })
                        ->latest()->paginate($this->limit);
        return view('account.search', compact('dados', 'accounts'));
    }

}
