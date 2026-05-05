<?php

class admin_Clienti
{
    public function index()
    {
        Auth::requireAdmin();
        $search = $_GET['search'] ?? '';
        $clienti = $search ? Cliente::cerca($search) : Cliente::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/admin/clienti/index.php';
        require 'application/views/templates/footer.php';
    }

    public function create()
    {
        Auth::requireAdmin();
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Cliente::crea($_POST);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/clienti/create.php';
        require 'application/views/templates/footer.php';
    }

    public function edit($id)
    {
        Auth::requireAdmin();
        $cliente = Cliente::ottieni($id);
        if (!$cliente) {
            header('Location: ' . URL . 'admin/clienti');
            return;
        }
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $result = Cliente::modifica($id, $_POST);
            $cliente = Cliente::ottieni($id);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/admin/clienti/edit.php';
        require 'application/views/templates/footer.php';
    }

    public function delete($id)
    {
        Auth::requireAdmin();
        Cliente::cancella($id);
        header('Location: ' . URL . 'admin/clienti');
    }

    public function apiSearch()
    {
        Auth::requireAdmin();
        $q = $_GET['q'] ?? '';
        $results = $q ? Cliente::cerca($q) : Cliente::tutti();
        header('Content-Type: application/json');
        echo $results->toJson();
    }
}
