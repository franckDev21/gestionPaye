<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CaisseController;
use App\Models\Caisse;
use App\Models\Employe;
use App\Models\Prime;
use App\Models\TotalCaisse;
use App\Models\TransactionOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PrimeController extends Controller
{
    public function index(){
        $prime=Prime::all();
        return view('prime')->with('prime' , $prime);
    }

    public function ajouterprime(Request $req){
        $prime = new Prime();
        $prime  ->matricule = $req->input('matricule');
        $caisse = DB::table('caisse')->get('montant');
        $caisse = new Caisse();
        $prime ->prime1 = $caisse->count()/10;
        $prime ->save();

        
        Session::flash('statuscode' , 'success');
        return  redirect('/prime')->with('status' , 'Montant Ajouté');
    }

    public function decaisser($id_employer){

        if($this->dejaDecaisser($id_employer)){
            Session::flash('statuscode' , 'error');
            return  redirect("/employe/{$id_employer}")->with('status' , 'Le compte est vide');
        }
        // on recherche l'employer qui veux decaisser
        $employer = Employe::find($id_employer);
        // on recherche toutes les primes associers a cet employer
        $primeForEmployes = DB::table('primes')->where('id_employe',$employer->id)->get();
        
        // on met toutes les primes a 0
        Prime::where('id_employe',$employer->id)
            ->update([
            'primeA'=>0,
            'primeB'=>0,
            'primeC'=>0
        ]);

        $transactionOut = new TransactionOut();
        // on calcule le total des primes pour l'employe
        # toute les primes pour un employé
        $totalPrime = 0;
        foreach($primeForEmployes as $primes){
            $totalPrime += ($primes->primeA + $primes->primeB + $primes->primeC);
        }

        // on verifie si on a deja fait une transaction et on met a jour la table total caisse
        $transactionOut = TransactionOut::all();
        $totalCaisse    = new TotalCaisse();
        $allTotalCaisse = TotalCaisse::all();
        if(!empty($transactionOut[0])){
            # on recupere ce qui etait deja dans total caisse
            $total = 0;
            foreach($allTotalCaisse as $tc){
                $total += $tc->total_caisse;
            }
            # on soustrait du total caisse la somme total des primes
            $total -= $totalPrime; 
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
            # on enleve le total de ses primes sur le total en caisse
            $total -= $totalPrime;
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

        // on créer la transaction sortante
        $transactionOut = new TransactionOut();
        $transactionOut->id_employe = $employer->id;
        $transactionOut->montant = $totalPrime;
        $transactionOut->save();

        Session::flash('statuscode' , 'success');
        return  redirect("/employe/{$employer->id}")->with('status' , 'Montant décaisser avec succès');
    }

    public function dejaDecaisser($id_employer){
        // on recherche l'employer qui veux decaisser
        $employer = Employe::find($id_employer);
        // on recherche toutes les primes associers a cet employer
        $primeForEmployes = DB::table('primes')->where('id_employe',$employer->id)->get();
        
        $dejaDecaisser = false;

        foreach($primeForEmployes as $prime){
            if($prime->primeA > 0){
                $dejaDecaisser = true;
                break;
            }
        }
        return !$dejaDecaisser;
    }

}
