<?php

namespace App\Service;

use DateTime;

class DateHelper
{

    public function getCurrentQuarterAndDatesElements()
    {

        $cd = new DateTime('now');
        $monthNumber = intval($cd->format('m'));
        switch ($monthNumber) {
            case (1 <= $monthNumber && $monthNumber <= 3):
                $q =  1;
                break;
            case (4 <= $monthNumber && $monthNumber <= 6):
                $q =  2;
                break;
            case (7 <= $monthNumber && $monthNumber <= 9):
                $q =  3;
                break;
            case (10 <= $monthNumber && $monthNumber <= 12):
                $q =  4;
                break;
            default:
                break;
        }

        return [
            'q' => $q,
            'd' => intval($cd->format('d')),
            'm' => $monthNumber,
            'y' => intval($cd->format('Y'))
        ];
    }
}
