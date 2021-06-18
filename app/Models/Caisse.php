<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    protected $table =  'caisse';
    protected $fillable = [
     'montant', 
    ];
}
