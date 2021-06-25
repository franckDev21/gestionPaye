<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
