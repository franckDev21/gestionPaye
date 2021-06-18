<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class EmployeController extends Controller
{
    public function index(){
        $employe = Employe::all();
        $totalEmploye = count($employe->toArray());
        return view('employes.employeIndex' , compact('employe','totalEmploye'));
    }

    public function show(Employe $employe){
        // les informations a utilisée dans la vue employe/{id}
        $primeForEmployes = DB::table('primes')->where('id_employe',$employe->id)->get();
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
        ->where('transaction_ints.id_employe',$employe->id)
        ->orderByDesc('transaction_ints.created_at')->limit(3)->offset(0)->get(['caisse.montant','transaction_ints.totalPrimes','transaction_ints.created_at','transaction_ints.primeA','transaction_ints.primeB','transaction_ints.primeC']);
        $transactoinOut = TransactionOut::limit(3)->where('id_employe',$employe->id)->offset(0)->get();
        $primeForUser   = Employe::join('primes','employe.id','=','primes.id_employe')
                        ->where('employe.id',$employe->id)
                        ->get(['primes.primeA','primes.primeB','primes.primeC','primes.created_at']);


        return view('employes.employeShow',compact('employe','primeForUser','afficherBtn','totalPrime','totalPrimeCalculer','transactoinInt','transactoinOut'));
    }
    
    public function create(){
        return view('employes.employeCreate');
    }

    public function store(Request $req)
    {
        $employe = new Employe();
            $employe ->matricule = $req->input('matricule');
            $employe -> noms_prenoms = $req->input('noms_prenoms');
            $employe -> cni = $req->input('cni');
            $employe -> telephone = $req->input('telephone');
            $employe ->  email = $req->input('email');
            $employe -> date_naissance= $req->input('date_naissance');
            $employe -> ville= $req->input('ville');
            $employe ->  addresse = $req->input('addresse');
            $employe -> grade = $req->input('grade');
            $employe->  departement = $req->input('departement');
            $employe -> poste = $req->input('poste');
            $employe -> sexe = $req->input('sexe');

        if ($req->hasfile('profile')) {
            $file = $req->file('profile');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/employes/', $filename);

        //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
        //a folder->upload and appsetting, and it wil store the images in your file.

            $employe->profile = $filename;
        } else {
            return $req;
            $employe->profile = '';
        }
        $employe->save();
        Session::flash('statuscode' , 'success');
        return  redirect('/employe')->with('status' , 'Employé ajouté avec succès');
    }

    public function edit($id){
        $employe = Employe::find($id);
        return view('employes.employeEdit',compact('employe'));
    }

    public function update(Request $req , $id){

        $employe= Employe::find($id);
        $employe ->matricule = $req->input('matricule');
        $employe -> noms_prenoms = $req->input('noms_prenoms');
        $employe -> cni = $req->input('cni');
        $employe -> telephone = $req->input('telephone');
        $employe ->  email = $req->input('email');
        $employe -> date_naissance= $req->input('date_naissance');
        $employe -> ville= $req->input('ville');
        $employe ->  addresse = $req->input('addresse');
        $employe -> grade = $req->input('grade');
        $employe->  departement = $req->input('departement');
        $employe -> poste = $req->input('poste');
        $employe -> sexe = $req->input('sexe');

        if ($req->hasfile('profile')) {

            $destination = 'uploads/employe/'.$employe->profile;

            if(File::exists($destination)){
                File::delete($destination);
            }
            $file = $req->file('profile');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/employes/', $filename);

            $employe->profile = $filename;
        } 
        $employe->update();
        Session::flash('statuscode' , 'info');
        return  redirect('/employe')->with('status' , 'Employé modifié avec succès');
    }

    public function destroy(Request $req , $id){
        
        $employe = Employe::findOrFail($id);
        
        $destination = 'uploads/employes/'.$employe->profile;

        if(File::exists($destination)){
            File::delete($destination);
        }

        $employe->delete();
        Session::flash('statuscode' , 'error');
        return redirect('/employes')->with('status' , 'Employé supprimé');
    }
}
