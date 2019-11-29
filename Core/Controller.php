<?php 

namespace Core;

abstract class Controller
{
    /**
     * Params from the matched route
     * @var []
     */
    protected $route_params = [];

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            echo "The $method method was not found in the controller";
        }
    }

    protected function before()
    {
        echo "(before) ";
    }

    protected function after()
    {
        echo " (after)";
    }
    
}
