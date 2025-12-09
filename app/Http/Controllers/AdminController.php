<?php

#847720666

namespace App\Http\Controllers;

use OwenIt\Auditing\Models\Audit;
use App\Role;
use App\Permission;
use App\User;

class AdminController extends Controller {

    private $limit = 10;

    function __construct() {
        $this->middleware("auth");
    }

    public function index() {
//        $audits = Audit::orderBy('id', 'DESC')->take($this->maxRecords)->get();
//        $roles = Role::orderBy('id', 'DESC')->take($this->maxRecords)->get();
//        $permissions= Permission::orderBy('id', 'DESC')->take($this->maxRecords)->get();
//        $users = User::orderBy('id', 'DESC')->take($this->maxRecords)->get();
//        $companies = Company::orderBy('id', 'DESC')->take($this->maxRecords)->get();
//        return view('admin.index', compact('audits', 'roles', 'permissions', 'users', 'companies'));
        return view('admin.index');
    }

}
