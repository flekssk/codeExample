<?php

namespace App\Application\TemplateRenderer;

/**
 * Interface TemplateRendererServiceInterface.
 *
 * @package App\Application\TemplateRenderer
 */
interface TemplateRendererServiceInterface
{
    /**
     * @param string $template
     * @param array $variables
     *
     * @return string
     */
    public function render(string $template, array $variables = []): string;

    /**
     * @param string $template
     * @param array $variables
     * @return string
     */
    public function renderWithoutImages(string $template, array $variables = []): string;
}
