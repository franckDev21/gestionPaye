<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use DateTime;
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
        $employeId          = request('id_employe');
        $transactionInt     = request('transactionInt');
        $transactionOut     = request('transactionOut');
        $dateDebut          = request('debut');
        $dateFin            = request('fin');
        $trierPar           = request('trie');

        // final tab
        $all  = [];
        
        dump($employeId,$transactionInt,$transactionOut,$dateDebut,$dateFin,$trierPar);

        // employe check et pas date
        if($employeId && (!$dateDebut || !$dateFin)){
            $trierPar  = $trierPar ?? 'desc';

            // TI sans TO check
            if($transactionInt && !$transactionOut){
                $transactionIntAll = TransactionInt::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionIntAll = $transactionIntAll->orderByDesc('id')->get();
                }else{
                    $transactionIntAll = $transactionIntAll->orderBy('id')->get();
                }
                
                $all['transactionInt'] = $transactionIntAll;
                dd($all);
            }

            // TO sans TI check
            if($transactionOut && !$transactionInt){
                $transactionOutAll = TransactionOut::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionOutAll = $transactionOutAll->orderByDesc('id')->get();
                }else{
                    $transactionOutAll = $transactionOutAll->orderBy('id')->get();
                }
                
                $all['transactionOut'] = $transactionOutAll;
                dd($all);
            }

            // TI et TO
            if($transactionInt && $transactionOut){
                $transactionIntAll = TransactionInt::where('id_employe',$employeId);
                $transactionOutAll = TransactionOut::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionIntAll = $transactionIntAll->orderByDesc('id')->get();
                    $transactionOutAll = $transactionOutAll->orderByDesc('id')->get();
                }else{
                    $transactionIntAll = $transactionIntAll->orderBy('id')->get();
                    $transactionOutAll = $transactionOutAll->orderBy('id')->get();
                }

                $all['transactionInt'] = $transactionIntAll;
                $all['transactionOut'] = $transactionOutAll;
                dd($all);
            }
        
        
        }

        // date check et pas employe
        if(($dateDebut || $dateFin) && !$employeId){
            $trierPar = $trierPar ?? 'desc';
            
            // date D check
            if($dateDebut && !$dateFin){ 
                
                $dateDebut = new DateTime($dateDebut);
                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $transactionIntAllWidthDate = DB::table('transaction_ints');
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderByDesc('id')->get();
                    }else{
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderBy('id')->get();
                    }

                    $all['transactionIntAllWidthDate'] = $transactionIntAllWidthDate;
                    dd($all);
                }
            }
        }

        // return view('transaction.search');
    }
}
