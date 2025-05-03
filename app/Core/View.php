<?php

namespace Bitka\Core;

use Bitka\Core\Response;

/**
 * Class View
 *
 * Handles rendering of views and layouts in the Bitka framework.
 */
class View
{
    /**
     * Default layout name.
     */
    private string $layout = 'default';

    /**
     * Path to the views directory.
     */
    private string $viewPath;

    /**
     * Constructor.
     *
     * @param string $viewPath Path to the views directory.
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = rtrim($viewPath, '/');
    }

    /**
     * Renders a view and sets the content in the response.
     *
     * @param Response $response Response object.
     * @param string   $template Template file name (without extension).
     * @param array    $data     Data to be passed to the view.
     *
     * @return Response
     */
    public function render(Response $response, string $template, array $data = []): Response
    {
        $content = $this->renderTemplate($template, $data);
        return $response->setContent($content);
    }

    /**
     * Renders a template and returns its content.
     *
     * @param string $template Template file name (without extension).
     * @param array  $data     Data to be passed to the view.
     *
     * @return string Rendered content.
     */
    private function renderTemplate(string $template, array $data): string
    {
        $templateFile = $this->getTemplateFilePath($template);

        if (!is_file($templateFile)) {
            throw new \RuntimeException("View file '{$templateFile}' not found.");
        }

        return $this->includeTemplate($templateFile, $data);
    }

    /**
     * Resolves the full file path of a template.
     *
     * @param string $template Template file name (without extension).
     *
     * @return string Full file path.
     */
    private function getTemplateFilePath(string $template): string
    {
        return "{$this->viewPath}/{$template}.php";
    }

    /**
     * Includes the template file and returns its rendered content.
     *
     * @param string $templateFile Full path to the template file.
     * @param array  $data         Data to be passed to the view.
     *
     * @return string Rendered content.
     */
    private function includeTemplate(string $templateFile, array $data): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include $templateFile;
        return ob_get_clean();
    }
}