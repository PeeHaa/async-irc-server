<?php declare(strict_types=1);

namespace AsyncIrcServer\Router;

use AsyncIrcServer\Command\Request\Request;

class Router
{
    private $routes = [];

    public function addRoute(string $commandName, string $requestClass, callable $action): self
    {
        $this->routes[$commandName] = [
            'requestClass' => $requestClass,
            'action'       => $action,
        ];

        return $this;
    }

    public function exists(string $command): bool
    {
        return isset($this->routes[$command]);
    }

    public function getAction(string $command): callable
    {
        return $this->routes[$command]['action'];
    }
}
