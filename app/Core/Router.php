<?php

namespace Bitka\Core;

class Router
{
    private array $routes = [];
    private array $allowedMethods = ['GET', 'POST'];

    public function __call(string $method, array $arguments): void
    {
        $method = strtoupper($method);

        if (!in_array($method, $this->allowedMethods, true)) {
            throw new \BadMethodCallException("Method $method is not allowed.");
        }

        [$uri, $action] = $arguments;
        $this->addRoute($method, $uri, $action);
    }

    private function addRoute(string $method, string $uri, callable|string $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(string $requestMethod, string $requestUri): void
    {
        $action = $this->routes[$requestMethod][$requestUri] ?? null;

        if ($action === null) {
            $this->sendResponse(404, "404 Not Found");
            return;
        }

        if (is_callable($action)) {
            $action();
            return;
        }

        if (is_string($action) && str_contains($action, '@')) {
            $this->handleControllerAction($action);
            return;
        }

        $this->sendResponse(500, "Invalid route action.");
    }

    private function handleControllerAction(string $action): void
    {
        [$controller, $method] = explode('@', $action);
        $controller = "Bitka\\Controllers\\$controller";

        if (!class_exists($controller) || !method_exists($controller, $method)) {
            $this->sendResponse(500, "Controller or method not found.");
            return;
        }

        $instance = new $controller();
        $instance->$method();
    }

    private function sendResponse(int $statusCode, string $message): void
    {
        http_response_code($statusCode);
        echo $message;
    }
}
