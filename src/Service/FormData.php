<?php

namespace App\Service;

use App\Service\DateHelper;
use App\Repository\MambraRepository;
use App\Repository\RaharahaRepository;

class FormData
{

    private $raharaha;
    private $date;
    private $responsable;
    private $dateHelper;
    private $mambraRepo;
    private $raharahaRepo;
    private $typeResponsable;


    public function __construct(DateHelper $dateHelper, MambraRepository $mambraRepo, RaharahaRepository $raharahaRepo)
    {
        $this->dateHelper = $dateHelper;
        $this->mambraRepo = $mambraRepo;
        $this->raharahaRepo = $raharahaRepo;
    }


    public function parseFormData($key, $value)
    {

        $parts = explode('-', $key); //ex : 13-ff_alar
        $monthAndWeekNumber =  $parts[0]; //ex 13
        $weekNumber = explode('_', $monthAndWeekNumber);

        $weekNumber = $weekNumber[1];
        $andraikitra =  $this->getAndraikitraAbbrev($parts[1]);
        $explodedAndraikitra =  isset($andraikitra) ? explode('_', $andraikitra) : null;
        $andro  = !is_null($explodedAndraikitra) ? end($explodedAndraikitra) : null; //ex : alar

        $currentYear = $this->dateHelper->getCurrentQuarterAndDatesElements()['y'];
        $year = intval($currentYear);
        $weekDates = isset($weekNumber) ? $this->dateHelper->getWeekDates(intval($weekNumber), $year) : null;

        if (!is_null($andro)) {

            switch ($andro) {
                case 'alar':
                    $this->date = $weekDates['wednesday'];
                    break;
                case 'zoma':
                    $this->date = $weekDates['friday'];
                    break;
                case 'sabata':
                    $this->date = $weekDates['saturday'];
                    break;
                default:
                    $this->date = null;
                    break;
            }
        }


        //get responsable 
        if (is_numeric($value)) {
            $value  = intval($value);
            $this->responsable =  $this->mambraRepo->find(intval($value));
            $this->typeResponsable = 'mambra';
        } else if ($value != "") {
            $this->responsable = $value;
            $this->typeResponsable = 'sampana';
        } else {
            $this->responsable = null;
            $this->typeResponsable = 'unknown';
        }

        //andraikitra 
        $this->raharaha  = $this->raharahaRepo->findOneBy(['abbreviation' => $andraikitra]);
    }

    private function getAndraikitraAbbrev($string)
    {
        if (str_contains($string, "_data")) {
            $string =  str_replace("_data", "", $string);
            return $string;
        } else {
            return $string;
        }
    }


    // Getters pour accéder aux propriétés
    public function getAndraikitra()
    {
        return $this->raharaha;
    }
    public function getAndro()
    {
        return $this->date;
    }
    public function getResponsable()
    {
        return $this->responsable;
    }
    public function getTypeResponsable()
    {
        return $this->typeResponsable;
    }
}
