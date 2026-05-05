<?php

class cliente_Fatture
{
    public function index()
    {
        Auth::requireRuolo('cliente');
        $fatture = Fattura::perCliente(Auth::getUserId());

        require 'application/views/templates/header.php';
        require 'application/views/cliente/fatture/index.php';
        require 'application/views/templates/footer.php';
    }

    public function view($id)
    {
        Auth::requireRuolo('cliente');
        $fattura = Fattura::ottieni($id);
        if (!$fattura) {
            header('Location: ' . URL . 'cliente/fatture');
            return;
        }

        require 'application/views/templates/header.php';
        require 'application/views/cliente/fatture/view.php';
        require 'application/views/templates/footer.php';
    }
}
