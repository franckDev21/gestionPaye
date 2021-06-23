<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\TransactionInt;
use App\Models\TransactionOut;
use Carbon\Carbon;
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
        $token = request()->session()->token();

        $employeId          = request('id_employe');
        $transactionInt     = request('transactionInt');
        $transactionOut     = request('transactionOut');
        $dateDebut          = request('debut');
        $dateFin            = request('fin');
        $trierPar           = request('trie');

        // final tab
        $all  = [];
        
        if(!$employeId && (!$dateDebut && !$dateFin) && ($transactionInt || $transactionOut)){
            // TI sans TO check
            if($transactionInt && !$transactionOut){
                $allTI = [];
                if($trierPar === 'desc'){
                    $transactionIntAll = TransactionInt::orderByDesc('created_at')->get();
                }else{
                    $transactionIntAll = TransactionInt::orderBy('created_at')->get();
                }
                foreach($transactionIntAll as $tI){
                    $allTI[] = $tI;
                }
                $all['transactionInt'] = $allTI;
                return view('transaction.search',compact('all','token'));
            }
            // TO sans TI check
            if(!$transactionInt && $transactionOut){
                $allTO = [];
                if($trierPar === 'desc'){
                    $transactionOutAll = TransactionOut::orderByDesc('created_at')->get();
                }else{
                    $transactionOutAll = TransactionOut::orderBy('created_at')->get();
                }
                foreach($transactionOutAll as $tI){
                    $allTO[] = $tI;
                }
                $all['transactionOut'] = $allTO;
            
                return view('transaction.search',compact('all','token'));
            }
            // TO et TI check
            if($transactionInt && $transactionOut){
                $allTI = [];
                $allTO = [];
                if($trierPar === 'desc'){
                    $transactionIntAll = TransactionInt::orderByDesc('created_at')->get();
                    $transactionOutAll = TransactionOut::orderByDesc('created_at')->get();
                }else{
                    $transactionOutAll = TransactionOut::orderBy('created_at')->get();
                    $transactionIntAll = TransactionInt::orderBy('created_at')->get();
                }
                foreach($transactionIntAll as $tI){
                    $allTI[] = $tI;
                }
                foreach($transactionOutAll as $tI){
                    $allTO[] = $tI;
                }
                $all['transactionInt'] = $allTI;
                $all['transactionOut'] = $allTO;
                return view('transaction.search',compact('all','token'));
            }
        }
        // employe check et pas date
        if($employeId && (!$dateDebut && !$dateFin)){
            $trierPar  = $trierPar ?? 'desc';
            
            if(!$transactionInt && !$transactionOut){
                $allTI = [];
                $allTO = [];
                $transactionIntAll = TransactionInt::where('id_employe',$employeId);
                $transactionOutAll = TransactionOut::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionIntAll = $transactionIntAll->orderByDesc('created_at')->get();
                    $transactionOutAll = $transactionOutAll->orderByDesc('created_at')->get();
                }else{
                    $transactionIntAll = $transactionIntAll->orderBy('created_at')->get();
                    $transactionOutAll = $transactionOutAll->orderBy('created_at')->get();
                }

                foreach($transactionIntAll as $tI){
                    $allTI[] = $tI;
                }
                foreach($transactionOutAll as $tI){
                    $allTO[] = $tI;
                }
                $all['transactionInt'] = $allTI;
                $all['transactionOut'] = $allTO;
                return view('transaction.search',compact('all','token'));
            }
            // TI sans TO check
            if($transactionInt && !$transactionOut){
                $allTI = [];
                $transactionIntAll = TransactionInt::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionIntAll = $transactionIntAll->orderByDesc('created_at')->get();
                }else{
                    $transactionIntAll = $transactionIntAll->orderBy('created_at')->get();
                }
                foreach($transactionIntAll as $tI){
                    $allTI[] = $tI;
                }
                $all['transactionInt'] = $allTI;
                return view('transaction.search',compact('all','token'));
            }

            // TO sans TI check
            if($transactionOut && !$transactionInt){
                $allTO = [];
                $transactionOutAll = TransactionOut::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionOutAll = $transactionOutAll->orderByDesc('created_at')->get();
                }else{
                    $transactionOutAll = $transactionOutAll->orderBy('created_at')->get();
                }
                foreach($transactionOutAll as $tI){
                    $allTO[] = $tI;
                }
                $all['transactionOut'] = $allTO;
                return view('transaction.search',compact('all','token'));
            }

            // TI et TO
            if($transactionInt && $transactionOut){
                $allTI = [];
                $allTO = [];
                $transactionIntAll = TransactionInt::where('id_employe',$employeId);
                $transactionOutAll = TransactionOut::where('id_employe',$employeId);
                if($trierPar === 'desc'){
                    $transactionIntAll = $transactionIntAll->orderByDesc('created_at')->get();
                    $transactionOutAll = $transactionOutAll->orderByDesc('created_at')->get();
                }else{
                    $transactionIntAll = $transactionIntAll->orderBy('created_at')->get();
                    $transactionOutAll = $transactionOutAll->orderBy('created_at')->get();
                }

                foreach($transactionIntAll as $tI){
                    $allTI[] = $tI;
                }
                foreach($transactionOutAll as $tI){
                    $allTO[] = $tI;
                }
                $all['transactionInt'] = $allTI;
                $all['transactionOut'] = $allTO;
                return view('transaction.search',compact('all','token'));
            }
        
        
        }

        // date check et pas employe
        if(($dateDebut || $dateFin) && !$employeId){
            $trierPar = $trierPar ?? 'desc';
            
            # date D check
            if($dateDebut && !$dateFin){ 
                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTI[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    return view('transaction.search',compact('all','token'));
                }
                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->get();
                    }else{
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->get();
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->get();
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->get();
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTI[] = $tId;
                        }
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }

            # date F check
            if($dateFin && !$dateDebut){
                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTI[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    return view('transaction.search',compact('all','token'));
                }
                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->get();
                    }else{
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->get();
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->get();
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->get();
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTI[] = $tId;
                        }
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }

            # date D et F check
            if($dateDebut && $dateFin){

                $dateDebut = new Carbon($dateDebut);
                $dateFin   = new Carbon($dateFin);

                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    $transactionIntAllWidthDate = TransactionInt::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"]);

                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionIntAllWidthDate as $tI){
                        $allTI[] = $tI;
                    }
                    $all['transactionInt'] =  $allTI;
                    return view('transaction.search',compact('all','token'));
                }

                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    $transactionOutAllWidthDate = TransactionOut::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"]);

                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionOutAllWidthDate as $tI){
                        $allTO[] = $tI;
                    }
                    $all['transactionOut'] =  $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];

                    $transactionIntAllWidthDate = TransactionInt::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"]);

                    $transactionOutAllWidthDate = TransactionOut::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"]);

                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderByDesc('created_at')->get();
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderBy('created_at')->get();
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionIntAllWidthDate as $tId){
                        $allTI[] = $tId;
                    }

                    foreach($transactionOutAllWidthDate as $tId){
                        $allTO[] = $tId;
                    }

                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }
            
        }

        // date check et employe
        if(($dateDebut || $dateFin) && $employeId){

            # date D et employe check
            if($dateDebut && !$dateFin){ 
                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTI[] = $tId;
                        }
                    }
                    $all['transactionInt'] =  $allTI;
                    return view('transaction.search',compact('all','token'));
                }
                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionInt'] =  $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->where('id_employe',$employeId)->get();
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTI[] = $tId;
                        }
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateDebut){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }

            # date D et employe check
            if($dateFin && !$dateDebut){ 
                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTI[] = $tId;
                        }
                    }
                    $all['transactionInt'] =  $allTI;
                    return view('transaction.search',compact('all','token'));
                }
                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionOut'] =  $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];
                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = TransactionInt::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                        $transactionOutAllWidthDate = TransactionOut::orderByDesc('created_at')->where('id_employe',$employeId)->get();
                    }else{
                        $transactionIntAllWidthDate = TransactionInt::orderBy('created_at')->where('id_employe',$employeId)->get();
                        $transactionOutAllWidthDate = TransactionOut::orderBy('created_at')->where('id_employe',$employeId)->get();
                    }
                    foreach($transactionIntAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTI[] = $tId;
                        }
                    }
                    foreach($transactionOutAllWidthDate as $tId){
                        if($tId->created_at->format('Y-m-d') === $dateFin){
                            $allTO[] = $tId;
                        }
                    }
                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }

            # date D et F et employe check
            if($dateDebut && $dateFin){

                $dateDebut = new Carbon($dateDebut);
                $dateFin   = new Carbon($dateFin);

                // TI et pas TO
                if($transactionInt && !$transactionOut){
                    $allTI = [];
                    $transactionIntAllWidthDate = TransactionInt::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"])->where('id_employe',$employeId);

                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionIntAllWidthDate as $tI){
                        $allTI[] = $tI;
                    }
                    $all['transactionInt'] =  $allTI;
                    return view('transaction.search',compact('all','token'));
                }

                // TO et pas TI
                if($transactionOut && !$transactionInt){
                    $allTO = [];
                    $transactionOutAllWidthDate = TransactionOut::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"])->where('id_employe',$employeId);

                    if($trierPar === 'desc'){
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionOutAllWidthDate as $tI){
                        $allTO[] = $tI;
                    }
                    $all['transactionOut'] =  $allTO;
                    return view('transaction.search',compact('all','token'));
                }

                // TI et TO
                if($transactionInt && $transactionOut){
                    $allTI = [];
                    $allTO = [];

                    $transactionIntAllWidthDate = TransactionInt::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"])->where('id_employe',$employeId);

                    $transactionOutAllWidthDate = TransactionOut::whereBetween('created_at', 
                    [$dateDebut->format('Y-m-d')." 00:00:00", $dateFin->format('Y-m-d')." 23:59:59"])->where('id_employe',$employeId);

                    if($trierPar === 'desc'){
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderByDesc('created_at')->get();
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderByDesc('created_at')->get();
                    }else{
                        $transactionIntAllWidthDate = $transactionIntAllWidthDate->orderBy('created_at')->get();
                        $transactionOutAllWidthDate = $transactionOutAllWidthDate->orderBy('created_at')->get();
                    }

                    foreach($transactionIntAllWidthDate as $tId){
                        $allTI[] = $tId;
                    }

                    foreach($transactionOutAllWidthDate as $tId){
                        $allTO[] = $tId;
                    }

                    $all['transactionInt'] = $allTI;
                    $all['transactionOut'] = $allTO;
                    return view('transaction.search',compact('all','token'));
                }
            }
        }
    }
}
