<?php

namespace App\Infrastructure\TemplateRenderer\AssetsProcessor;

/**
 * Class AssetsProcessor.
 *
 * @package App\Infrastructure\TemplateRenderer\AssetsProcessor
 */
class AssetsProcessor
{
    private const DS = DIRECTORY_SEPARATOR;

    /**
     * Название директории с асетами.
     */
    private const TEMPLATE_ASSETS_DIR_NAME = 'assets';

    /**
     * Соответствует подстроке "<link rel="stylesheet" href="css/styles.css"/>".
     */
    private const STYLESHEET_PATTERN = '/<link rel=("|\')stylesheet("|\') href=("|\').*("|\')\s?\/>/';

    /**
     * Соответствует подстроке "css/styles.css".
     */
    private const STYLESHEET_HREF_PATTERN = '/(\/(css|styles)\/(.*).css)/';

    /**
     * Соответствует подстроке "src="/img/image.jpg"".
     */
    private const IMG_SRC_PATTERN = '(src="(?!https|http).*\/(img|image|images)\/(.*)(.jpg|.png|.gif)("|\'))';

    /**
     * Соответствует подстроке "/img/image.jpg".
     */
    private const IMG_FILE_PATTERN = '(\/(img|image|images)\/(.*)(.jpeg|.jpg|.png|.gif))';

    /**
     * @var string
     */
    private string $template;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var string
     */
    private string $templatesDirectory;

    /**
     * AssetsProcessor constructor.
     *
     * @param string $templateDirectory
     * @param string $template
     * @param string $content
     */
    public function __construct(string $templateDirectory, string $template, string $content)
    {
        $this->templatesDirectory = $templateDirectory;
        $this->template = $template;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function process(): string
    {
        $this->processStylesheet();
        $this->processImages();

        return $this->content;
    }

    /**
     * @return string
     */
    public function processWithoutImages(): string
    {
        $this->processStylesheet();

        return $this->content;
    }


    /**
     * Функция процессинга подключенных CSS файлов.
     */
    private function processStylesheet(): void
    {
        // Поиск подключенных CSS файлов вида "<link rel="stylesheet" href="css/styles.css"/>".
        $stylesheetMatches = [];
        $stylesheetDefinitionExist = preg_match(self::STYLESHEET_PATTERN, $this->content, $stylesheetMatches);

        if ($stylesheetDefinitionExist !== 0) {
            $stylesheetDefinition = reset($stylesheetMatches);

            // При наличии подключенных CSS файлов - выполнить поиск значения атрибута href вида "css/styles.css".
            $stylesheetHrefMatches = [];
            $stylesheetHrefExist = preg_match(self::STYLESHEET_HREF_PATTERN, $stylesheetDefinition, $stylesheetHrefMatches);

            // При наличии файла - прочитать его содержимое, обернуть в тэг "style" и заменить
            // подключаемый файл на получившийся тэг.
            if ($stylesheetHrefExist !== 0) {
                $stylesheetFile = $stylesheetHrefMatches[1];
                $stylesheetPath = $this->templatesDirectory . self::DS . $this->template . self::DS . self::TEMPLATE_ASSETS_DIR_NAME . $stylesheetFile;
                $stylesheetContent = file_get_contents($stylesheetPath);
                $stylesheetDefinitionReplacement = "<style>\n{$stylesheetContent}\n</style>";

                $this->content = str_replace($stylesheetDefinition, $stylesheetDefinitionReplacement, $this->content);
            }
        }
    }

    /**
     * Функция процессинга изображений.
     */
    private function processImages(): void
    {
        // Поиск атрибута src изображений вида "src="%DOMAIN_HOST%/img/image.jpg"".
        $imgMatches = [];
        $imgDefinitionExist = preg_match_all(self::IMG_SRC_PATTERN, $this->content, $imgMatches);

        if ($imgDefinitionExist !== 0) {
            // Для каждого найденного src определить путь до файла вида "/img/image.jpg".
            foreach (reset($imgMatches) as $match) {
                $imgDefinition = $match;

                $imgHrefMatches = [];
                $imgHrefExist = preg_match(self::IMG_FILE_PATTERN, $imgDefinition, $imgHrefMatches);

                // Прочитать содержимое найденного файла, преобразовать его в base64 и заменить
                // значение атрибута src.
                if ($imgHrefExist !== 0) {
                    $imgFile = $imgHrefMatches[0];
                    $imgPath = $this->templatesDirectory . self::DS . $this->template . self::DS . self::TEMPLATE_ASSETS_DIR_NAME . $imgFile;
                    $type = pathinfo($imgPath, PATHINFO_EXTENSION);
                    $imgContent = file_get_contents($imgPath);
                    $imgSrcReplacement = "src='data:image/" . $type . ';base64, ' . base64_encode($imgContent) . "'";

                    $this->content = str_replace($imgDefinition, $imgSrcReplacement, $this->content);
                }
            }
        }
    }
}
