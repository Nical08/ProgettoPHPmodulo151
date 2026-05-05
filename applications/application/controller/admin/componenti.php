<?php

class admin_Componenti
{
    public function index()
    {
        Auth::requireAdmin();
        $search = $_GET['search'] ?? '';
        $componenti = $search ? Componente::cerca($search) : Componente::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/admin/componenti/index.php';
        require 'application/views/templates/footer.php';
    }

    public function create()
    {
        Auth::requireAdmin();
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Componente::crea($_POST);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/componenti/create.php';
        require 'application/views/templates/footer.php';
    }

    public function edit($id)
    {
        Auth::requireAdmin();
        $componente = Componente::ottieni($id);
        if (!$componente) {
            header('Location: ' . URL . 'admin/componenti');
            return;
        }
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Componente::modifica($id, $_POST);
            $componente = Componente::ottieni($id);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/componenti/edit.php';
        require 'application/views/templates/footer.php';
    }

    public function delete($id)
    {
        Auth::requireAdmin();
        Componente::cancella($id);
        header('Location: ' . URL . 'admin/componenti');
    }

    public function apiSearch()
    {
        Auth::requireAdmin();
        $q = $_GET['q'] ?? '';
        $results = $q ? Componente::cerca($q) : Componente::tutti();
        header('Content-Type: application/json');
        echo $results->toJson();
    }
}
