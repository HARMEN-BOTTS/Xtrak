<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    static function years()
    {
        $years = [];
        for ($i = 2019; $i <= date('Y'); $i++) {
            $years[$i] = $i;
        }
        return $years;
    }
    static function monthName()
    {
        return [
            '01' => 'Janvier',
            '02' => 'Février',
            '03' => 'Mars',
            '04' => 'Avril',
            '05' => 'Mai',
            '06' => 'Juin',
            '07' => 'Juillet',
            '08' => 'Août',
            '09' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre',
        ];
    }
    static function generateCandidateCertificate(){
        return Str::random(10);
    }
    
}
