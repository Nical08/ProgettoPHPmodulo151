<?php

class dipendente_Fatture
{
    public function index()
    {
        Auth::requireDipendente();
        $fatture = Fattura::tutte();

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/fatture/index.php';
        require 'application/views/templates/footer.php';
    }

    public function create()
    {
        Auth::requireDipendente();
        $clienti = Cliente::tutti();
        $componenti = Componente::tutti();

        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $ore = (float)($_POST['ore_lavoro'] ?? 0);
            $dipendente = Dipendente::ottieni(Auth::getUserId());
            $componentiIds = $_POST['componenti'] ?? [];
            $quantita = $_POST['quantita'] ?? [];
            $prezzo = Fattura::calcolaPrezzo($ore, $dipendente->salario_orario, $componentiIds, $quantita);

            $result = Fattura::crea([
                'prezzo' => $prezzo,
                'descrizione' => $_POST['descrizione'] ?? '',
                'ore_lavoro' => $ore,
                'dispositivo_id' => (int)($_POST['dispositivo_id'] ?? 0),
                'dipendente_id' => Auth::getUserId(),
                'componenti' => $componentiIds,
                'quantita' => $quantita,
            ]);
        }
        $error = $result['error'] ?? '';
        $success = $result['success'] ?? '';

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/fatture/create.php';
        require 'application/views/templates/footer.php';
    }

    public function view($id)
    {
        Auth::requireDipendente();
        $fattura = Fattura::ottieni($id);
        if (!$fattura) {
            header('Location: ' . URL . 'dipendente/fatture');
            return;
        }

        require 'application/views/templates/header.php';
        require 'application/views/dipendente/fatture/view.php';
        require 'application/views/templates/footer.php';
    }

    public function getDispositiviByCliente()
    {
        Auth::requireDipendente();
        $clienteId = (int)($_GET['cliente_id'] ?? 0);
        if ($clienteId > 0) {
            $dispositivi = Dispositivo::perCliente($clienteId);
            header('Content-Type: application/json');
            echo json_encode($dispositivi);
        }
    }
}
