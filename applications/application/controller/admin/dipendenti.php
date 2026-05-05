<?php

class admin_Dipendenti
{
    public function index()
    {
        Auth::requireAdmin();
        $search = $_GET['search'] ?? '';
        $dipendenti = $search ? Dipendente::cerca($search) : Dipendente::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/admin/dipendenti/index.php';
        require 'application/views/templates/footer.php';
    }

    public function create()
    {
        Auth::requireAdmin();
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Dipendente::crea($_POST);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/dipendenti/create.php';
        require 'application/views/templates/footer.php';
    }

    public function edit($id)
    {
        Auth::requireAdmin();
        $dipendente = Dipendente::ottieni($id);
        if (!$dipendente) {
            header('Location: ' . URL . 'admin/dipendenti');
            return;
        }
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Dipendente::modifica($id, $_POST);
            $dipendente = Dipendente::ottieni($id);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/dipendenti/edit.php';
        require 'application/views/templates/footer.php';
    }

    public function delete($id)
    {
        Auth::requireAdmin();
        Dipendente::cancella($id);
        header('Location: ' . URL . 'admin/dipendenti');
    }

    public function apiSearch()
    {
        Auth::requireAdmin();
        $q = $_GET['q'] ?? '';
        $results = $q ? Dipendente::cerca($q) : Dipendente::tutti();
        header('Content-Type: application/json');
        echo $results->toJson();
    }
}
