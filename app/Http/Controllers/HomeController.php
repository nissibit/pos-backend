<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller {

    private $limit = 10;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth', 'revalidate']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   public function index() {     
        $user = auth()->user();
        if ($user->hasAnyRoles("Administrador")) {
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
