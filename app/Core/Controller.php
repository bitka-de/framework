<?php

/**
 * Class Controller
 *
 * Base class for all controllers in the Bitka framework.
 * Provides shared functionality for derived controllers, such as methods
 * for rendering views or handling requests.
 *
 * @package Bitka
 * @author  Jan P. Behrens
 * @license MIT
 * @version 1.0.0
 */

namespace Bitka\Core;

class Controller
{
    /**
     * Render a view file.
     *
     * @param string $view The name of the view file (without extension).
     * @param array $data  An associative array of data to pass to the view.
     */
    public function render(string $view, array $data = [])
    {
        $viewFile = dirname(__DIR__, 2) . "/resources/{$view}.php";

        if (file_exists($viewFile)) {
            extract($data);
            require $viewFile;
        } else {
            throw new \Exception("View file '{$view}' not found.");
        }
    }
}
