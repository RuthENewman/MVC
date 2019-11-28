<?php 

namespace Core;

abstract class Controller
{
    /**
     * Params from the matched route
     * @var []
     */
    protected $routeParams = [];

    public function __construct($routeParams)
    {
        $this->routeParams = $routeParams;
    }

}
