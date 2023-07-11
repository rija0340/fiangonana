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
}
