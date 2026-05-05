<?php

class cliente_Profilo
{
    public function index()
    {
        Auth::requireRuolo('cliente');

        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Cliente::modifica(Auth::getUserId(), $_POST);
        }

        $cliente = Cliente::ottieni(Auth::getUserId());
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/cliente/profilo/index.php';
        require 'application/views/templates/footer.php';
    }
}
