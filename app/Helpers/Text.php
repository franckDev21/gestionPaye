<?php

namespace App\Helpers;

class Text{
    
    public static function num_random($length){
        $numbers = "0123456789".time();
        return substr(str_shuffle(str_repeat($numbers,$length)),0,$length);
    }

}