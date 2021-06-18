<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class TransactionController extends Controller
{
    public function index(){
       

return view('/transaction' , compact('data'));
    }

    public function payer(Request $req){
      
          $transaction= new Transaction();
          $transaction -> id = $req->input('id');
          $transaction -> prime_paye = $req->input('prime_paye');
          $transaction -> status = $req->input('status');
          $transaction -> date= $req->input('date'); 
          $transaction->save();
         Session::flash('statuscode' , 'success');
   return  redirect('/transaction')->with('status' , 'Paiement Effectué ');
    }
    
    /*public function voirtransaction(){
        $data = Employe::join('transaction','transaction.id' , '=' ,'employe.id')
                         ->get(['employe.id' ,'employe.noms_prenoms' , 'employe.grade' , 'employe.prime1' , 'employe.prime2' , 'employe.prime3' , 'transaction.prime_paye' , 'transaction.status' , 'transaction.date']);
    
       return view('/transaction' , compact('data'));
                        }*/
}
