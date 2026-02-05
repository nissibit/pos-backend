<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller {
    private User $user;
    private $limit = 10;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   public function index() {     
        $this->user = Auth::user();
        if ($this->user->hasAnyRoles("Administrador")) {
            $products= \App\Models\Product::doesntHave('parents')->whereHas('stocks', function($query){
                $query->where("stocks.quantity", "<=", 'run_out');                
            })->latest()->paginate($this->limit);
            #dd($products);
             return view('home', compact("products"));        
       }
       return view('home');
   }
//    
    // public function index() {

    //     $wcppScript = WebClientPrint::createWcppDetectionScript(action('WebClientPrintController@processRequest'), Session::getId());

    //     return view('home.index', ['wcppScript' => $wcppScript]);
    // }

    // public function printHtmlCard() {
    //     return view('home.printHtmlCard');
    // }

}
