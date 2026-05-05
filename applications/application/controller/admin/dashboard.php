<?php

class admin_Dashboard
{
    public function index()
    {
        Auth::requireAdmin();
        $totClienti = Cliente::conta();
        $totDipendenti = Dipendente::conta();
        $totDispositivi = Dispositivo::conta();
        $totFatture = Fattura::conta();
        $totRicavi = Fattura::ricaviTotali();
        $ultimeFatture = Fattura::tutte();

        require 'application/views/templates/header.php';
        require 'application/views/admin/dashboard/index.php';
        require 'application/views/templates/footer.php';
    }
}
