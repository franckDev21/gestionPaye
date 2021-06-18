<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\EmployeController;
use App\Models\Prime;
use App\Models\TotalCaisse;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Helper\Table;

class CaisseController extends Controller
{
    public function index(){
        $caisse=Caisse::all();
        $caisseTotal = DB::table('total_caisses')->SUM('total_caisse');
        return view('caisse.caisse',compact('caisse','caisseTotal'));
    }

    public function ajouter(){
        // on ajoute le montant dans la caisse
        $caisse = new Caisse();
        request()->validate([
            'montant'=>'required|integer|min:0'
        ]);
        $caisse -> montant = request('montant');
        $caisse->save();

        // on verifie si on a deja fait une transaction
        $transactionOut = TransactionOut::all();
        $totalCaisse    = new TotalCaisse();
        $allTotalCaisse = TotalCaisse::all();
        if(!empty($transactionOut[0])){
            # on recupere ce qui etait deja dans total caisse
            $total = 0;
            foreach($allTotalCaisse as $tc){
                $total += $tc->total_caisse;
            }
            # on additionne le total calculer avec le montant entré
            $total += request('montant');
            # on modifie le total caisse qui est deja en BD
            if(count($allTotalCaisse) > 0){
                foreach($allTotalCaisse as $ttc){
                    TotalCaisse::where('id',$ttc->id)
                ->update(['total_caisse'=>$total]);
                }
            }else{  # on creer une ligne total caisse
                $totalCaisse->total_caisse = $total;
                $totalCaisse->save();
            }

        }else{
            // on met a jour le total caisse
            $allCaise = Caisse::all();
            $total    = 0;
            foreach($allCaise as $caisseMotant){
                $total += $caisseMotant->montant;
            }
            # on modifie le total caisse qui est deja en BD
            if(count($allTotalCaisse) > 0){
                foreach($allTotalCaisse as $ttc){
                    TotalCaisse::where('id',$ttc->id)
                ->update(['total_caisse'=>$total]);
                }
            }else{  # on creer une ligne total caisse
                $totalCaisse->total_caisse = $total;
                $totalCaisse->save();
            }
        }
        // total employer
        $employes =  Employe::all();
        $totalEmployes =  DB::table('employe')->count();

        // montant par employer
        $mtEmploye =  (request('montant') / $totalEmployes);

        $mtPrimeA  = $mtEmploye / 3;
        $mtPrimeB  = $mtEmploye / 3;
        $mtPrimeC  = $mtEmploye / 3;

        foreach($employes as $employe){
            $prime = new Prime();
            
            $prime->primeA = $mtPrimeA;
            $prime->primeB = $mtPrimeB;
            $prime->primeC = $mtPrimeC;
            $prime->id_employe = $employe->id;
            $prime->id_caisse = $caisse->id;
            $prime->save();

            $transactionInt = new TransactionInt();
            
            $transactionInt->primeA = $mtPrimeA;
            $transactionInt->primeB = $mtPrimeB;
            $transactionInt->primeC = $mtPrimeC;
            $transactionInt->totalPrimes = $mtEmploye;
            $transactionInt->id_employe = $employe->id;
            $transactionInt->id_caisse = $caisse->id;
            $transactionInt->save();
        }

        Session::flash('statuscode' , 'success');
        return  redirect('/caisse')->with('status' , 'Montant Ajouté');
    }

    public function editcaisse($id){
        $caisse = Caisse::find($id);
        return view('caisse.caisse-edit')->with('caisse' , $caisse);
    }

    public function modifier(Request $req , $id){
        $caisse= Caisse::findOrFail($id);
        $caisse -> montant = $req->input('montant');
        $caisse->update();
        Session::flash('statuscode' , 'info');
        return  redirect('/caisse')->with('status' , 'Montant modifié avec succès');
    }
}
