<?php
namespace App\Core;

class App
{
    protected mixed $controller = 'UserController';
    protected string $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if (file_exists('app/Controllers/' . $url[0] . '.php'))
        {
            $this->controller = $url[0];
            unset($url[0]);
        }
        require_once 'app/Controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;
        if(isset($url[1]))
        {
            if(method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl()
    {
        if(isset($_GET['route']))
        {
            return explode('/', filter_var(rtrim($_GET['route'], '/'), FILTER_SANITIZE_URL));
        }
    }
}