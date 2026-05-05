<?php

class dipendente_Dispositivi
{
    public function index()
    {
        Auth::requireDipendente();
        $search = $_GET['search'] ?? '';
        $dispositivi = $search ? Dispositivo::cerca($search) : Dispositivo::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/dispositivi/index.php';
        require 'application/views/templates/footer.php';
    }

    public function view($id)
    {
        Auth::requireDipendente();
        $dispositivo = Dispositivo::ottieni($id);
        if (!$dispositivo) {
            header('Location: ' . URL . 'dipendente/dispositivi');
            return;
        }
        $categorie = Dispositivo::ottieniCategorie($id);

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/dispositivi/view.php';
        require 'application/views/templates/footer.php';
    }

    public function apiSearch()
    {
        Auth::requireDipendente();
        $q = $_GET['q'] ?? '';
        $results = $q ? Dispositivo::cerca($q) : Dispositivo::tutti();
        header('Content-Type: application/json');
        echo json_encode($results);
    }
}
