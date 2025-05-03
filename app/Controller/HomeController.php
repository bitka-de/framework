<?php

/**
 * Class HomeController
 *
 * Diese Klasse stellt den Einstiegspunkt für die Home-Seite der Anwendung dar und ist verantwortlich für
 * das Verarbeiten von Anfragen, die an den Home-Bereich der Anwendung gerichtet sind. Sie verwaltet die
 * Anzeige der Startseite und kann Daten für diese Seite bereitstellen, zum Beispiel Begrüßungsnachrichten oder 
 * andere dynamische Inhalte.
 *
 * @package Bitka
 * @author  Jan P. Behrens
 * @license MIT
 * @version 1.0.0
 */

namespace Bitka\Controller;

use Bitka\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        echo "Hello @ Bitka - Framework!";
    }
}
