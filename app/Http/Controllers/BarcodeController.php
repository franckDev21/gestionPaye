<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarcodeController extends Controller
{
    public function index(){
        $barcodes = Barcode::all();
        return view('employes.employesBarcode',compact('barcodes'));
    }

    public function create($id){
        $employe   = Employe::find($id);
        $generator = new  BarcodeGeneratorJPG();
        $filename  = "matricule/{$employe->noms_prenoms}-{$employe->matricule}.jpg";
        file_put_contents ($filename , $generator ->getBarcode( "$employe->matricule" , $generator::TYPE_CODE_128 , 3 , 50 , [ 0 , 0 , 0 ] ));
        $filePath = $filename;
        $filename = basename($filename);
        
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachement; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Emcoding: binary");

        readfile($filePath);
        
        $barcodes = Barcode::all();
        return view('employes.employesBarcode',compact('barcodes'));
    }
}
