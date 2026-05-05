<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Auth
{
    public static function login($email, $password)
    {
        $user = Capsule::table('DIPENDENTE')
            ->where('email', $email)
            ->first();

        if ($user && password_verify($password, $user->password)) {
            self::createSession((array)$user, $user->ruolo, 'DIPENDENTE');
            return $user->ruolo;
        }

        $user = Capsule::table('CLIENTE')
            ->where('Email', $email)
            ->first(['id', 'Nome as nome', 'Email as email', 'Password as password']);

        if ($user && password_verify($password, $user->password)) {
            self::createSession((array)$user, 'cliente', 'CLIENTE');
            return 'cliente';
        }

        self::recordLoginAttempt($email);
        return false;
    }

    private static function createSession($user, $ruolo, $table)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nome'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_ruolo'] = $ruolo;
        $_SESSION['user_table'] = $table;
    }

    public static function logout()
    {
        $_SESSION = [];
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    private static function isLoginBlocked($email)
    {
        $attempts = $_SESSION['login_attempts'][$email] ?? ['count' => 0, 'time' => 0];
        if ($attempts['count'] >= 5 && (time() - $attempts['time']) < 300) {
            return true;
        }
        if ((time() - $attempts['time']) >= 300) {
            unset($_SESSION['login_attempts'][$email]);
        }
        return false;
    }

    private static function recordLoginAttempt($email)
    {
        $attempts = $_SESSION['login_attempts'][$email] ?? ['count' => 0, 'time' => 0];
        $attempts['count']++;
        $attempts['time'] = time();
        $_SESSION['login_attempts'][$email] = $attempts;
    }

    private static function clearLoginAttempts($email)
    {
        unset($_SESSION['login_attempts'][$email]);
    }

    public static function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrfToken($token)
    {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function csrfField()
    {
        return '<input type="hidden" name="csrf_token" value="' . self::generateCsrfToken() . '">';
    }

    public static function requireCsrf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!self::validateCsrfToken($token)) {
                die('Richiesta non valida (CSRF).');
            }
        }
    }

    public static function getRuolo()
    {
        return $_SESSION['user_ruolo'] ?? null;
    }

    public static function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUserNome()
    {
        return $_SESSION['user_nome'] ?? null;
    }

    public static function getUserEmail()
    {
        return $_SESSION['user_email'] ?? null;
    }

    public static function getUserTable()
    {
        return $_SESSION['user_table'] ?? null;
    }

    public static function sanitize($input)
    {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function redirectIfNotLoggedIn()
    {
        if (!self::isLoggedIn()) {
            header('Location: ' . URL . 'home/login');
            exit;
        }
    }

    public static function requireRuolo($ruolo)
    {
        self::redirectIfNotLoggedIn();
        if (self::getRuolo() !== $ruolo) {
            self::redirectToDashboard();
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::redirectIfNotLoggedIn();
        if (self::getRuolo() !== 'admin') {
            self::redirectToDashboard();
            exit;
        }
    }

    public static function requireDipendente()
    {
        self::redirectIfNotLoggedIn();
        $ruolo = self::getRuolo();
        if ($ruolo !== 'dipendente' && $ruolo !== 'admin') {
            self::redirectToDashboard();
            exit;
        }
    }

    public static function redirectToDashboard()
    {
        $ruolo = self::getRuolo();
        if ($ruolo === 'admin') {
            header('Location: ' . URL . 'admin/dashboard');
        } elseif ($ruolo === 'dipendente') {
            header('Location: ' . URL . 'dipendente/dashboard');
        } elseif ($ruolo === 'cliente') {
            header('Location: ' . URL . 'cliente/dashboard');
        } else {
            header('Location: ' . URL . 'home/login');
        }
    }
}
