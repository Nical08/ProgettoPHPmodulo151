<?php

class dipendente_Dashboard
{
    public function index()
    {
        Auth::requireDipendente();
        $fatture = Fattura::perDipendente(Auth::getUserId());
        $dispositivi = Dispositivo::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/dashboard/index.php';
        require 'application/views/templates/footer.php';
    }
}
