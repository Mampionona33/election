<?php

namespace router;

class Router
{
    private $routes;
    private $url;

    public function __construct()
    {
        $this->routes = [];
        $this->url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }
    public function get(string $path, callable $callback)
    {
        $this->routes["GET"][$path] = $callback;
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $path => $callback) {
                if ($this->url === $path) {
                    $callback(); // Appel de la fonction de rappel
                    return;
                }
            }
        }

        echo "404 Not Found";
    }
}
