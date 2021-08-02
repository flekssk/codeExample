<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ActionMakeControllerCommand extends Command
{
    private const PREFIX_URL = '/api/v1/';
    protected static $defaultName = 'action:make:controller';

    protected function configure(): void
    {
        $this
            ->setDescription('Генерация структуры контроллера по документации https://conf.action-media.ru/pages/viewpage.action?pageId=78027582')
            ->addArgument('url', InputArgument::OPTIONAL, '/api/v1/organization-events_get-list')
            ->addOption('http-method', null, InputOption::VALUE_REQUIRED, 'HTTP метод, например GET', 'GET')
            ->addOption('base-path', null, InputOption::VALUE_REQUIRED, 'Базовый путь к генерируемым файлам',
                realpath(__DIR__ . '/../../'))
            ->addOption('dry-run', null, InputOption::VALUE_NONE,
                'Пробный запуск (покажет создаваемые файлы, но ничего создавать не будет)');
    }

    /**
     * @inheritDoc
     * @psalm-suppress PossiblyInvalidArgument
     * @psalm-suppress PossiblyInvalidCast
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $basePath = $input->getOption('base-path');
        $dryRun = $input->getOption('dry-run');
        $httpMethod = strtoupper(trim($input->getOption('http-method')));
        if (!\in_array($httpMethod, ['GET', 'POST'])) {
            throw new \RuntimeException(sprintf('Метод может быть только GET или POST. https://conf.action-media.ru/pages/viewpage.action?pageId=78027582'));
        }
        $url = trim(trim($input->getArgument('url')), '/');
        if (false !== strpos($url, '/')) {
            $parts = explode('/', $url);
            $url = array_pop($parts);
            $prefix = implode('/', $parts);
        } else {
            $prefix = trim(static::PREFIX_URL, '/');
        }
        [$module, $action] = explode('_', $url);

        $module = array_map(function ($item) {
            return ucfirst(strtolower($item));
        }, explode('-', $module));
        if (count($module) === 1) {
            $module = [$module[0], $module[0]];
        }

        $action = array_map(function ($item) {
            return ucfirst(strtolower($item));
        }, explode('-', $action));

        $structure = [
            // Controllers
            sprintf('%s/src/UI/Controller/%s/',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/UI/Controller/%s/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'Controller.php')
            ) => $this->getContent('Controller.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
                '_DESCRIPTION_' => $this->getAction($action) . ' ' . $this->getModule($module, ' '),
                '_MODULE_' => $this->getModule($module),
                '_MODULEVAR_' => lcfirst($this->getModule($module)),
                '_ACTION_' => lcfirst($this->getAction($action)),
                '_TAG_' => $this->getModule($module, ' '),
                '_URL_' => $prefix . '/' . $url,
                '_HTTPMETHOD_' => $httpMethod,
            ]),

            // Controller Form
            sprintf('%s/src/UI/Controller/%s/Form',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/UI/Controller/%s/Form/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'Form.php')
            ) => $this->getContent('Form.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
            ]),

            // Validation Model
            sprintf('%s/src/UI/Controller/%s/Model',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/UI/Controller/%s/Model/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'RequestModel.php')
            ) => $this->getContent('RequestModel.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
            ]),

            // Application Service
            sprintf('%s/src/Application/%s/',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/Application/%s/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, [], 'Service.php')
            ) => $this->getContent('Service.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, []),
                '_FULLFILENAME_' => $this->getFilename($module, $action),
                '_MODULE_' => $this->getModule($module),
                '_VARNAME_' => lcfirst($this->getModule($module)) . $this->getAction($action),
                '_ACTION_' => lcfirst($this->getAction($action)),
            ]),

            // Application Dto
            sprintf('%s/src/Application/%s/Dto',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/Application/%s/Dto/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'Dto.php')
            ) => $this->getContent('Dto.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
            ]),

            // Application Assembler
            sprintf('%s/src/Application/%s/Assembler',
                $basePath,
                implode('/', $module)
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/src/Application/%s/Assembler/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'AssemblerInterface.php')
            ) => $this->getContent('AssemblerInterface.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
            ]),
            sprintf('%s/src/Application/%s/Assembler/%s',
                $basePath,
                implode('/', $module),
                $this->getFilename($module, $action, 'Assembler.php')
            ) => $this->getContent('Assembler.php', [
                '_DIRECTORY_' => implode('\\', $module),
                '_FILENAME_' => $this->getFilename($module, $action),
            ]),

            // API Tests
            sprintf('%s/tests/%s/%s',
                $basePath,
                $prefix,
                $module[0]
            ) => DIRECTORY_SEPARATOR,
            sprintf('%s/tests/%s/%s/%s',
                $basePath,
                $prefix,
                strtolower($module[0]),
                $this->getFilename($module, $action, 'Cest.php')
            ) => $this->getContent('Cest.php', [
                '_DIRECTORY_' => strtolower(str_replace('/', '\\', $prefix) . '\\' . $module[0]),
                '_FILENAME_' => $this->getFilename($module, $action),
                '_URL_' => '/' . $prefix . '/' . $url,
                '_HTTPMETHOD_' => $httpMethod,
            ]),
        ];

        $filesystem = new Filesystem();
        foreach ($structure as $path => $content) {
            $output->writeln($path);
            if ($dryRun) {
                continue;
            }

            if ($content === DIRECTORY_SEPARATOR) {
                $filesystem->mkdir($path);
            } else {
                $filesystem->remove($path);
                $filesystem->touch($path);
                $filesystem->appendToFile($path, $content);
            }
        }

        return 0;
    }

    /**
     * @param array $module
     * @param string $separator
     * @return string
     */
    private function getModule(array $module, string $separator = ''): string
    {
        if ($module[0] === $module[1]) {
            return $module[0];
        }

        return $module[0] . $separator . $module[1];
    }

    /**
     * @param array $action
     * @param string $separator
     * @return string
     */
    private function getAction(array $action, string $separator = ''): string
    {
        if (count($action) === 1) {
            return $action[0];
        }

        return $action[0] . $separator . $action[1];
    }

    /**
     * @param array $module
     * @param array $action
     * @param string $suffix
     * @return string
     */
    private function getFilename(array $module, array $action, string $suffix = ''): string
    {
        $result = $module[0];

        if ($module[0] !== $module[1]) {
            $result .= $module[1];
        }

        if (count($action)) {
            $result .= $action[0];
            if (count($action) === 2) {
                $result .= $action[1];
            }
        }

        if (!empty($suffix)) {
            $result .= $suffix;
        }

        return $result;
    }

    /**
     * @param string $file
     * @param array $data
     * @return string
     */
    private function getContent(string $file, array $data): string
    {
        $content = file_get_contents(__DIR__ . '/../../config/code-templates/' . $file . '.tpl');
        $content = str_replace(array_keys($data), array_values($data), $content);

        return $content;
    }
}
