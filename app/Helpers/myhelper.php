<?php

use Illuminate\Support\Facades\DB;

function getEmploye($id){
    $employe = DB::table('employe')->where('id',$id)->first();
    return $employe;
}

function getCaisse($id){
    $caisse = DB::table('caisse')->where('id_caisse',$id)->first();
    return $caisse;
}

function navLink(string $link):?string{
    return $_SERVER['REQUEST_URI'] === $link ? 'active':null;
}