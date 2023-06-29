<?php

namespace App\Service;

use App\Repository\MambraRepository;

class ApplicationGlobals
{


    public function getTrancheAgeClasse()
    {

        return  [
            'choisir' => null,
            "0 à 2" =>  '0_2',
            "3 à 4" =>  '3_4',
            "5 à 12" => '5_12',
            "13 à 15" => '13_15',
            "16 à 18" => '16_18',
            "19 à 35" => '19_35',
            "Plus de 35" =>  '35+',
        ];
    }

    public function getActiviteChoral()
    {
        return [
            'Choisir' => '',
            'Répétition' => 'Répétition',
            'Culte' => 'Culte',
            'Sabata Hariva' => 'Sabata Hariva',
            'Prise de son' => 'Prise de son',
            'Prise de vue' => 'Prise de vue',
        ];
    }
}
