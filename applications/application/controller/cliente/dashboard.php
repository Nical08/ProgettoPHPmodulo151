<?php

class cliente_Dashboard
{
    public function index()
    {
        Auth::requireRuolo('cliente');
        $fatture = Fattura::perCliente(Auth::getUserId());

        require 'application/views/templates/header.php';
        require 'application/views/cliente/dashboard/index.php';
        require 'application/views/templates/footer.php';
    }
}
