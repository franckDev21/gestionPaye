<?php

namespace App\Http\Controllers;

use App\Helpers\Text;
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
        $matricule = Text::num_random(10);
        return view('employes.employeCreate',compact('matricule'));
    }

    public function store(Request $req)
    {
        request()->validate([
            'profile'       =>'sometimes|mimes:jpeg,jpg,png|max:5000',
            'matricule'     =>'required:unique:employe|min:10',
            'noms_prenoms'  =>'required|string|min:2|max:100',
            'cni'           =>'required|unique:employe|integer|min:10',
            'telephone'     =>'required|unique:employe|integer',
            'email'         =>'required|email|max:256|unique:employe|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'date_naissance'=>'required|date_format:Y-m-d',
            'ville'         =>'required|min:1|max:256',
            'addresse'      =>'required|min:1|max:256',
            'grade'         =>'required',
            'departement'   =>'required',
            'poste'         =>'required',
            'sexe'          =>'required'
        ]);
        $employe = new Employe();
        $employe ->matricule = $req->input('matricule');
        $employe -> noms_prenoms = $req->input('noms_prenoms');
        $employe -> cni = $req->input('cni');
        $employe -> telephone = $req->input('telephone');
        $employe -> email = $req->input('email');
        $employe -> date_naissance= $req->input('date_naissance');
        $employe -> ville= $req->input('ville');
        $employe -> addresse = $req->input('addresse');
        $employe -> grade = $req->input('grade');
        $employe -> departement = $req->input('departement');
        $employe -> poste = $req->input('poste');
        $employe -> sexe = $req->input('sexe');

        if ($req->hasfile('profile')) {
            $file       = $req->file('profile');
            $extension  = $file->getClientOriginalExtension(); // getting image extension
            $filename   = time() . '.' . $extension;
            $file->move('uploads/employes/', $filename);

            //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
            //a folder->upload and appsetting, and it wil store the images in your file.
            $employe->profile = $filename;
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
        Session::flash('statuscode' , 'success');
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
