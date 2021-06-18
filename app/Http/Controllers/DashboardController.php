<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
    $employe = DB::table('employe')->count();
    $caisse = DB::table('total_caisses')->SUM('total_caisse');
        return view('index' , compact('employe' , 'caisse'));
    }
}
