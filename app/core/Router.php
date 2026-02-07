<?php

namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$this->normalize($path)] = [$controller, $action];
    }

    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$this->normalize($path)] = [$controller, $action];
    }

    public function run(string $path): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->normalize($path);

        // 1. Sprawdzenie zwykłych tras
        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            $this->call($controller, $action);
            return;
        }

        // 2. Obsługa tras dynamicznych typu katalog/{category}
        foreach ($this->routes[$method] as $route => $handler) {
            if (strpos($route, '{') !== false) {
                $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
                $regex = "#^" . $regex . "$#";

                if (preg_match($regex, $path, $matches)) {
                    array_shift($matches);
                    [$controller, $action] = $handler;
                    $this->call($controller, $action, $matches);
                    return;
                }
            }
        }

        // 404
        http_response_code(404);
        require __DIR__ . '/../views/404.view.php';
    }

    private function call(string $controller, string $action, array $params = []): void
    {
        $controllerClass = "App\\Controllers\\$controller";

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "Błąd: kontroler $controllerClass nie istnieje.";
            return;
        }

        $controllerObject = new $controllerClass();

        if (!method_exists($controllerObject, $action)) {
            http_response_code(500);
            echo "Błąd: metoda $action nie istnieje w kontrolerze $controllerClass.";
            return;
        }

        $controllerObject->$action(...$params);
    }

    private function normalize(string $path): string
    {
        $path = parse_url($path, PHP_URL_PATH);
        $path = trim($path, '/');
        return $path;
    }
}
