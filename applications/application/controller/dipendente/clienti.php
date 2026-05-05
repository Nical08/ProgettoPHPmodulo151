<?php

class dipendente_Clienti
{
    public function index()
    {
        Auth::requireDipendente();
        $search = $_GET['search'] ?? '';
        $clienti = $search ? Cliente::cerca($search) : Cliente::tutti();

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/clienti/index.php';
        require 'application/views/templates/footer.php';
    }

    public function view($id)
    {
        Auth::requireDipendente();
        $cliente = Cliente::ottieni($id);
        if (!$cliente) {
            header('Location: ' . URL . 'dipendente/clienti');
            return;
        }
        $dispositivi = Cliente::elencoDispositivi($id);

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/clienti/view.php';
        require 'application/views/templates/footer.php';
    }
}
