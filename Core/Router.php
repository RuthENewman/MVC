<?php

class Router
{

    /**
     * Associative array of routes (the routing table)
     * @var [] $routes
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var [] $params
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     * @param string $route The route URL
     * @param [] $params Parameters (controller, action etc.)
     * 
     * @return void
     */
    public function add($route, $params = [])
    {
        // Convert the route to a regex 
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regex
        $route = preg_replace('/\{([a-z]+):([^\}]+)\]/', 
        '(?P<\1>\2)', $route);

        // Add start and end delimiters
        $route = '/^' . $route . '$/i';

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
            if (preg_match($route, $url, $matches)) {
                foreach($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
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

    /**
     * 
     */
    public function dispatch($url)
    {
        if ($this->match($url))
        {
            $controller = $this->params['controller'];
            $controller = $this->capitalise($controller);

            if (class_exists($controller)) {
                $controllerObject = new $controller();
                $action = $this->params['action'];
                $action = $this->camelCase($action);

                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    echo "The $action method in the $controller controller was not found";
                }
            } else {
                echo "The $controller controller was not found.";
            }
        } else {
            echo "No route matched";
        }
    }

    /**
     * Converts a kebab case string to capitalise it
     * @param string $string
     * @return string
     */
    protected function capitalise($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Converts a kebab case string to camelCase
     * @param string $string
     * @return string
     */
    protected function camelCase($string)
    {
        return lcfirst($this->capitalise($string));
    }

}


?>

