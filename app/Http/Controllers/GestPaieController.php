<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;

class GestPaieController extends Controller
{
    public function index(){
        $token = request()->session()->token();
        $employe=Employe::all();
        return view('gestpaie',compact('employe','token'));
    }

    public function searchAjax(){
        if(request('query')){
            $matricule = request('query');
            $employe = Employe::where('matricule' ,"$matricule")->get();
            if(!empty($employe[0])){
                echo json_encode($employe);
            }else{
                echo 'empty';
            }
        }else{
            echo 'empty';
        }
        
    }
    
    public function search(Request $req){
        if($req->isMethod('post')) {

            request()->validate([
                'query'=>'required|string'
            ]);

            $name= $req->get('query');
            $employe = Employe::where('matricule' ,"$name")->get();
            if(empty($employe->toArray())){
                request()->session()->flash('message','Aucun employé ne correspond a ce matricule');
                return back();
            }
            $primeForEmployes = DB::table('primes')->where('id_employe',$employe[0]->id)->get();
            $totalPrime = [];
            $totalPrimeA = 0;
            $totalPrimeB = 0;
            $totalPrimeC = 0;
            $totalPrimeCalculer = 0;
            $afficherBtn = false;
            foreach($primeForEmployes as $prime){
                $totalPrimeA += ($prime->primeA);
                $totalPrimeB += ($prime->primeB);
                $totalPrimeC += ($prime->primeC);
                $totalPrimeCalculer  += ($prime->primeA + $prime->primeB + $prime->primeC);
                if($prime->primeA > 0){
                    $afficherBtn = true;
                }
            }
            $totalPrime = [
                'primeA'=>$totalPrimeA,
                'primeB'=>$totalPrimeB,
                'primeC'=>$totalPrimeC
            ];  
            // on recupere toute les transactions entrantes
            $transactoinInt = TransactionInt::join('caisse','transaction_ints.id_caisse','=','caisse.id_caisse')
            ->where('transaction_ints.id_employe',$employe[0]->id)
            ->orderByDesc('transaction_ints.created_at')->limit(3)->offset(0)->get(['caisse.montant','transaction_ints.totalPrimes','transaction_ints.created_at','transaction_ints.primeA','transaction_ints.primeB','transaction_ints.primeC']);
            $transactoinOut = TransactionOut::limit(3)->where('id_employe',$employe[0]->id)->offset(0)->get();
            $primeForUser   = Employe::join('primes','employe.id','=','primes.id_employe')
                            ->where('employe.id',$employe[0]->id)
                            ->get(['primes.primeA','primes.primeB','primes.primeC','primes.created_at']);
            return view('search' , compact('employe','primeForUser','afficherBtn','totalPrime','totalPrimeCalculer','transactoinInt','transactoinOut'));
        }
        return back();
    }

}
