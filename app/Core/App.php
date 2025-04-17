<?php

namespace App\Core;

class App
{
    public function __construct(
        private Router $router = new Router(),
    ) {
    }

    /**
     * Démarre l'application
     * @return void
     */
    public function start(): void
    {
        // On stock l'url du navigateur dans une variable
        $url = $_SERVER['REQUEST_URI'];

        // On va vérifier si l'url n'est pas juste / et si elle termine par un /
        if (!empty($url) && $url !== '/' && $url[-1] === '/') {
            $url = substr($url, 0, -1);

            // On redirige vers l'url sans le /
            http_response_code(301);

            header("Location: $url");
            exit(301);
        }

        // Init du routeur (remplir le tableau $this->routes)
        $this->router->initRouter();

        // On va vérifier si l'url du navigateur correspond à une route
        $this->router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}