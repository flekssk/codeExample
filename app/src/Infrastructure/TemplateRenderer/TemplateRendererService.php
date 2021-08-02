<?php

namespace App\Infrastructure\TemplateRenderer;

use App\Application\TemplateRenderer\TemplateRendererServiceInterface;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Infrastructure\TemplateRenderer\AssetsProcessor\AssetsProcessor;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class TemplateRendererService.
 *
 * @package App\Application\TemplateRenderer
 */
class TemplateRendererService implements TemplateRendererServiceInterface
{
    private const DS = DIRECTORY_SEPARATOR;

    /**
     * Название директории с шаблонами.
     */
    private const TEMPLATES_DIR_NAME = 'templates';

    /**
     * Название файла шаблона.
     */
    private const TEMPLATE_FILE_NAME = 'view.html';

    /**
     * @var string
     */
    private string $templatesDirectory;

    /**
     * @var array
     */
    private array $defaultVariables;

    /**
     * TemplateRenderer constructor.
     *
     * @param ParameterBagInterface $parameterBag
     * @param SiteOptionRepositoryInterface $siteOptionRepository
     */
    public function __construct(ParameterBagInterface $parameterBag, SiteOptionRepositoryInterface $siteOptionRepository)
    {
        $this->templatesDirectory = $parameterBag->get('kernel.project_dir') . self::DS . self::TEMPLATES_DIR_NAME;
        $this->defaultVariables = [
            '%DOMAIN_NAME%' => $siteOptionRepository->findOneByName('registryName')->getValue(),
            '%FIELD_OF_KNOWLEDGE%' => $siteOptionRepository->findOneByName('fieldOfKnowledge')->getValue(),
        ];
    }

    /**
     * @param string $template
     * @param array $variables
     *
     * @return string
     */
    public function render(string $template, array $variables = []): string
    {
        $content = $this->getTemplatesContent($template);

        $assetsProcessor = new AssetsProcessor($this->templatesDirectory, $template, $content);
        $content = $assetsProcessor->process();

        $content = $this->processContentVariables($content, $variables);

        return $content;
    }

    /**
     * @inheritDoc
     */
    public function renderWithoutImages(string $template, array $variables = []): string
    {
        $content = $this->getTemplatesContent($template);

        $assetsProcessor = new AssetsProcessor($this->templatesDirectory, $template, $content);
        $content = $assetsProcessor->processWithoutImages();

        $content = $this->processContentVariables($content, $variables);

        return $content;
    }

    /**
     * @param string $template
     *
     * @return string
     */
    private function getTemplatesContent(string $template)
    {
        $fileName = implode(self::DS, [$this->templatesDirectory, $template, self::TEMPLATE_FILE_NAME]);
        return file_get_contents($fileName);
    }

    /**
     * @param $content
     * @param $variables
     *
     * @return string
     */
    private function processContentVariables($content, $variables)
    {
        $variables = array_merge($this->defaultVariables, $variables);
        foreach ($variables as $key => $variable) {
            $content = str_replace($key, $variable, $content);
        }

        return $content;
    }
}
