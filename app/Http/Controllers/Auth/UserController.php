<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\User;
use App\Http\Requests\UpdateUser;
//use \App\Http\Requests\UpdateSenha;
use Auth;
use Hash;
use OwenIt\Auditing\Models\Audit;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $user;
    private $limit = 10;

    function __construct(User $user) {
        $this->user = $user;
        $this->middleware("auth");
    }

    public function index() {
        $users = $this->user->latest()->paginate($this->limit);
        return view("admin.user.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request) {
        $data = $request->all();
        $data["password"] = bcrypt($data['password']);
        $data["password2"] = bcrypt($data['password']);
        $insert = $this->user->create($data);
        if ($insert) {

            return redirect()->route("user.create")->with("sucesso", " Utilizador criado com sucesso");
            #Enviar um email:::
        } else {
            return redirect()->back()->with("falha", "Ocorreu um erro desconhecido ao criar utilizador");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = $this->user->find($id);
        return view("admin.user.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = $this->user->find($id);
        return view("admin.user.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id) {
//        dd($request->all());
        $user = $this->user->find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $request->resetpassword ?? ($user->password = bcrypt($request->username));
        $update = $user->save();
        if ($update) {
            return redirect()->route("user.edit", $id)->with("sucesso", " dados actualiados com sucesso.");
        } else {
            return redirect()->route("user.edit", $id)->with("falha", " não foi possível editar dados do utilizador.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = User::findOrFail($id);
        if (auth()->user()->id != $user->id) {
            if ($user->delete()) {
                return redirect()->route('user.index')->with("info", " Utilizador '{$user->name} {$user->lastname}' suprimido!");
            } else {
                return redirect()->back()->with("falha", " não foi possível suprimir utilizador.");
            }
        }
        return redirect()->route('user.index')->with("falha", " não é possível eliminar-se!.");
    }

    public function pesquisar(Request $request) {
        $criterio = $request->criterio;
        $users = $this->user->where('name', 'like', "%{$criterio}%")
                ->orWhere('username', 'like', "%{$criterio}%")
                ->orWhere('email', 'like', "%{$criterio}%")
                ->orWhere('created_at', 'like', "%{$criterio}%")
                ->orWhere('updated_at', 'like', "%{$criterio}%")
                ->latest()
                ->paginate($this->limit);
        $dados = $request->all();
        return view("admin.user.pesquisar", compact("users", "dados"));
    }

    public function report_excel() {
        Excel::create('TodosUtilizadores', function($excel) {

            // Set the title
            $excel->setTitle('Lista de utilizadores');

            // Chain the setters
            $excel->setCreator(env("APP_NAME"))
                    ->setCompany(env("APP_NAME"));

            // Call them separately
            $excel->setDescription('Lista de Utilizadores');

            //Creating a sheet
            $excel->sheet('Todos Utilizadores', function($sheet) {
                $users = $this->user->all();
                $sheet->loadView('admin.user.reports.excel.all')->with("users", $users);
            });
        })->export('xlsx');
        #return view("admin.user.reports.excel.all", compact("users"));
    }

    public function profile() {
        $user = auth()->user();
        return view("admin.user.profile", compact('user'));
    }

    public function getChangePassword() {
        $user = auth()->user();
        return view('admin.user.changepwd', compact('user'));
    }

    public function changePassword(Request $request) {
        #dd($request);
        if (!(Hash::check($request->get('oldpass'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("falha", "Senha actual não corresponde. Volte a tentar.");
        }

        if (strcmp($request->get('newpass'), $request->get('confpass')) != 0) {
            //Current password and new password are same
            return redirect()->back()->with(["falha" => "Nova senha deve ser igual a confirmação."]);
        }
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('newpass'));
        $user->save();

        return redirect()->back()->with(["sucesso" => "Senha actualizada"]);
    }

    public function activity($id) {
        $user = $this->user->find($id);
        $audits = Audit::where('user_id', $user->id)->paginate($this->limit);
        return view('activity.index', compact('audits', 'user'));
    }

}
