<?php

namespace App\Service;

use App\Repository\MambraRepository;

class KilasyHelper
{

    private $mambraRepo;
    public function __construct(MambraRepository $mambraRepo)
    {
        $this->mambraRepo = $mambraRepo;
    }

    /**
     * @param kilasy
     * @return array of mpampianatra
     */
    public function getMpampianatras($kilasy)
    {
        $mambra = $this->mambraRepo->findMambra($kilasy);
        $mpampianatra = [];
        foreach ($mambra as $m) {
            if ($m['is_mpampianatra'] == 1) {
                $mpampianatra[] = [
                    'id' => $m['id'],
                    'nom' => $m['nom'] != "" ? $m['nom'] : $m['prenom'],
                ];
            }
        }
        return $mpampianatra;
    }

    /**
     * @param kilasy
     * @return array of mpampianatra
     */
    public function getMpanentanas($kilasy)
    {
        $mambra = $this->mambraRepo->findMambra($kilasy);
        $mpampianatra = [];
        foreach ($mambra as $m) {
            if ($m['is_mpanentana'] == 1) {
                $mpampianatra[] = [
                    'id' => $m['id'],
                    'nom' => $m['nom'] != "" ? $m['nom'] : $m['prenom'],
                ];
            }
        }
        return $mpampianatra;
    }

    /** 
     * return une valeur en fonction préférence nombre à utiliser pour registre
     * @param kilasy
     * @return integer
     */
    public function getNbrMambra($kilasy)
    {
        $preference = $kilasy->getUsedNbrMambra();
        if ($preference == "custom") {
            return  count($this->mambraRepo->findMambra($kilasy));
        } else {
            return $kilasy->getNbrMambra();
        }
    }
}
