<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $totalEmploye = DB::table('employe')->count();
        $totalCaisse  = DB::table('total_caisses')->SUM('total_caisse');
        $totalTransactionInt = DB::table('transaction_ints')->count();
        $totalTransactionOut = DB::table('transaction_outs')->count();

        $employeRandom = Employe::all();
        $employeRandomArray = [];
        foreach($employeRandom as $employe){
            $employeRandomArray[] = $employe;
        }
        shuffle($employeRandomArray);
        $employeRandom = $employeRandomArray[0];

        $tansactionAll     = [];
        $transactionIntAll = TransactionInt::orderByDesc('created_at')->take(3)->get();
        $transactionOutAll = TransactionOut::orderByDesc('created_at')->take(3)->get();
        foreach($transactionIntAll as $transaction){
            $tansactionAll[] = $transaction;
        }
        foreach($transactionOutAll as $transaction){
            $tansactionAll[] = $transaction;
        }
        shuffle($tansactionAll);
        $classNameInt = TransactionInt::class;

        $employeAll   = Employe::orderByDesc('created_at')->take(4)->get();

        $transactionIntAll = TransactionInt::orderByDesc('created_at')->take(2)->get();
        $transactionOutAll = TransactionOut::orderByDesc('created_at')->take(3)->get();

        return view('index' , compact('employeAll','totalEmploye','totalCaisse','totalTransactionInt','totalTransactionOut','employeRandom','tansactionAll','classNameInt','transactionIntAll','transactionOutAll'));
    }
}
