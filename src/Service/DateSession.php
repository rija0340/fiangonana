<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DateSession
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setSessionDateRegistre($date)
    {
        $this->session->set('dateRegistre', $date);
    }

    public function getSessionDateRegistre()
    {
        return $this->session->has('dateRegistre') ? $this->session->get('dateRegistre') : null;
    }
}
