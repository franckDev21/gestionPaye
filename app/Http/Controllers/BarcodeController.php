<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Employe;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    public function index(){
        $barcodes = Barcode::all();
        return view('employes.employesBarcode',compact('barcodes'));
    }

    public function create($id){
        header("Content-type: image/png");
        $image = imagecreate(200,50);
        dd($image);
    }
}
