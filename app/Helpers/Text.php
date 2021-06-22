<?php

namespace App\Helpers;

use App\Models\Employe;
use Illuminate\Support\Facades\DB;

class Text{
    
    public static function num_random($length){
        $numbers = "0123456789".time();
        return substr(str_shuffle(str_repeat($numbers,$length)),0,$length);
    }

}