<?php

class Router
{

    /**
     * Associative array of routes (the routing table)
     * @var [] $routes
     */
    protected $routes = [];

    /**
     * Add a route to the routing table
     * @param string $route The route URL
     * @param [] $params Parameters (controller, action etc.)
     * 
     * @return void
     */
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
     * 
     * @return []
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, 
     * setting the $params property if a route is found
     * @param string $url The route URL
     * @return boolean true if a match found, false otherwise
     */
    public function match($url)
    {
        foreach($this->routes as $route => $params) {
            if ($url == $route) {
                 $this->params = $params;
                 return true;
            }
        }
        return false;
    }

    /**
     * Get the currently matched parameters
     * @return []
     */
    public function getParams()
    {
        return $this->params;
    }

}


?>

