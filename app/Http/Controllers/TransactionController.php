<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index(){
        $token = request()->session()->token();
        $totalTI = [];
        $totalTO = [];
        $transactionTnts = TransactionInt::all();
        foreach($transactionTnts as $TI){
            $totalTI[] = $TI;
        }
        $transactionOuts = TransactionOut::all();
        foreach($transactionOuts as $TO){
            $totalTO[] = $TO;
        }
        $all = array_merge($totalTI,$totalTO);
        // on melange le les 2 tableaux
        shuffle($all);
        $classNameInt = TransactionInt::class;
        return view('transaction.index',compact('token','all','classNameInt'));
    }
    
    public function search(){
        dd(request()->all());
        return view('transaction.search');
    }
}
