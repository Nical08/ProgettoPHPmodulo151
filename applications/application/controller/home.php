<?php

class home
{
    public function index()
    {
        if (Auth::isLoggedIn()) {
            Auth::redirectToDashboard();
        } else {
            header('Location: ' . URL . 'home/login');
        }
    }

    public function login()
    {
        if (Auth::isLoggedIn()) {
            Auth::redirectToDashboard();
            return;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::requireCsrf();
            $email = Auth::sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Inserisci email e password.';
            } elseif (!Auth::validateEmail($email)) {
                $error = 'Formato email non valido.';
            } else {
                $result = Auth::login($email, $password);
                if ($result) {
                    Auth::redirectToDashboard();
                    return;
                } else {
                    $error = 'Email o password errati.';
                }
            }
        }

        require 'application/views/auth/login.php';
    }

    public function logout()
    {
        Auth::logout();
        header('Location: ' . URL . 'home/login');
    }
}
