<?php

/**
 * Class App
 *
 * Diese Klasse stellt den Einstiegspunkt für die gesamte Anwendung dar und ist verantwortlich für
 * das Initialisieren und Verwalten der Kernkomponenten wie Routing, Konfiguration und Datenbankverbindung.
 * Sie dient als zentraler Controller, der Anfragen verarbeitet und die entsprechenden Controller-Methoden
 * aufruft. Außerdem stellt die Klasse die Umgebungskonfiguration und Dienste zur Verfügung.
 *
 * @package Bitka
 * @author  Jan P. Behrens
 * @license MIT
 * @version 1.0.0
 */

namespace Bitka\Core;

use Bitka\Core\EnvLoader;

class App
{
    private Request $request;
    private Router $router;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router();
    }

    public function run(): void
    {
        $router = $this->router;

        (new EnvLoader(dirname(__DIR__, 2), '.env'))->load();
        $this->loadFile('bootstrap/helpers');
        $this->loadFile('routes/web', $router);
        $router->dispatch($this->request->method(), $this->request->path());
    }


    private function loadFile($path, $router = null )
    {
        
        $file = dirname(__DIR__, 1) . "/{$path}.php";
        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new \Exception("File '{$file}' not found.");
        }
    }
}
