<?php

require_once 'application/libs/eloquent.php';

class Application
{
    private $url_area = null;
    private $url_controller = null;
    private $url_action = null;
    private $url_parameters = [];

    public function __construct()
    {
        $this->splitUrl();
        $this->loadController();
    }

    private function splitUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $first = isset($url[0]) ? strtolower($url[0]) : null;
            $areas = ['admin', 'dipendente', 'cliente'];

            if (in_array($first, $areas)) {
                $this->url_area = $first;
                $this->url_controller = isset($url[1]) ? $url[1] : 'dashboard';
                $this->url_action = isset($url[2]) ? $url[2] : 'index';
                $this->url_parameters = array_slice($url, 3);
            } else {
                $this->url_area = null;
                $this->url_controller = $first ?: 'home';
                $this->url_action = isset($url[1]) ? $url[1] : 'index';
                $this->url_parameters = array_slice($url, 2);
            }
        } else {
            $this->url_controller = 'home';
            $this->url_action = 'index';
        }
    }

    private function loadController()
    {
        if ($this->url_area) {
            $path = './application/controller/' . $this->url_area . '/' . $this->url_controller . '.php';
            $class = $this->url_area . '_' . ucfirst($this->url_controller);
        } else {
            $path = './application/controller/' . $this->url_controller . '.php';
            $class = $this->url_controller;
        }

        if (file_exists($path)) {
            require $path;

            if (class_exists($class)) {
                $controller = new $class();
                if (method_exists($controller, $this->url_action)) {
                    call_user_func_array([$controller, $this->url_action], $this->url_parameters);
                } else {
                    $controller->index();
                }
            } else {
                $this->loadDefault();
            }
        } else {
            $this->loadDefault();
        }
    }

    private function loadDefault()
    {
        require './application/controller/home.php';
        $home = new Home();
        $home->index();
    }
}
