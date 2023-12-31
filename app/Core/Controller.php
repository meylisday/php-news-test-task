<?php

namespace App\Core;

use Exception;
use RuntimeException;

abstract class Controller
{
    protected array $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * @throws Exception
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new RuntimeException("Method $method not found in controller " . get_class($this));
        }
    }

    protected function before()
    {}

    protected function after()
    {}
}