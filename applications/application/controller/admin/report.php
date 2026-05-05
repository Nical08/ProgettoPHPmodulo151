<?php

class admin_Report
{
    public function index()
    {
        Auth::requireAdmin();
        $totFatture = Fattura::conta();
        $totRicavi = Fattura::ricaviTotali();
        $totClienti = Cliente::conta();
        $totCategorie = Categoria::conta();
        $fatture = Fattura::tutte();

        require 'application/views/templates/header.php';
        require 'application/views/admin/report/index.php';
        require 'application/views/templates/footer.php';
    }
}
