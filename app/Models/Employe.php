<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table =  'employe';
    protected $fillable = [
     'profile' , 'matricule' , 'noms_prenoms' , 'cni', 'telephone' , 'email', 'date_naissance' ,'ville', 'addresse','grade','departement' , 'poste' ,'sexe' ,
    ];
    //protected $primaryKey = 'matricule'; 

    //public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';
}
