<?php

use App\Models\Prime;
use Illuminate\Support\Facades\DB;

function getEmploye($id){
    $employe = DB::table('employe')->where('id',$id)->first();
    return $employe;
}

function getPrimeForEmploye($id){
    $primeEmploye = Prime::where('id_employe',$id)->take(4)->get();
    // on calcule le total des primes pour l'employe
    # toute les primes pour un employé
    $totalPrime = 0;
    foreach($primeEmploye as $primes){
        $totalPrime += ($primes->primeA + $primes->primeB + $primes->primeC);
    }
    return $totalPrime;
}

function getCaisse($id){
    $caisse = DB::table('caisse')->where('id_caisse',$id)->first();
    return $caisse;
}

function navLink(string $link):?string{
    return $_SERVER['REQUEST_URI'] === $link ? 'active':null;
}