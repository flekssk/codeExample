<?php

namespace App;

use App\Tests\TestContainerPass;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * Class Kernel.
 *
 * @package App
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    const ER_GLAV_X_SITE_HOST = 'ru-ru.er_glavbukh_ru';

    const GLMS_X_SITE_HOST = 'ru-ru.er_1glms_ru';

    const BUDGETNIK_X_SITE_HOST = 'ru-ru.er_budgetnik_ru';

    const GKH_X_SITE_HOST = 'ru-ru.er_gkh_ru';

    const GZAKYPKI_X_SITE_HOST = 'ru-ru.er_gzakypki_ru';

    const KDELO_X_SITE_HOST = 'ru-ru.er_kdelo_ru';

    const LAW_X_SITE_HOST = 'ru-ru.er_law_ru';

    const OTRUDA_X_SITE_HOST = 'ru-ru.er_otruda_ru';

    const MENOBR_X_SITE_HOST = 'ru-ru.erro_menobr_ru';

    const SOVET_GD_X_SITE_HOST = 'ru-ru.sovet_gd_ru';

    const NA_FD_X_SITE_HOST = 'ru-ru.na_fd_ru';

    const HR_DIRECTOR_X_SITE_HOST = 'ru-ru.er_hr-director_ru';

    const GLV_X_SITE_HOST = 'ru-ru.er_1glv_ru';

    const DEFAULT_X_SITE_HOST = self::ER_GLAV_X_SITE_HOST;

    /**
     * @var array|string[]
     */
    private array $allowedXHosts = [
        self::ER_GLAV_X_SITE_HOST,
        self::GLMS_X_SITE_HOST,
        self::BUDGETNIK_X_SITE_HOST,
        self::GKH_X_SITE_HOST,
        self::GZAKYPKI_X_SITE_HOST,
        self::KDELO_X_SITE_HOST,
        self::LAW_X_SITE_HOST,
        self::OTRUDA_X_SITE_HOST,
        self::MENOBR_X_SITE_HOST,
        self::NA_FD_X_SITE_HOST,
        self::SOVET_GD_X_SITE_HOST,
        self::HR_DIRECTOR_X_SITE_HOST,
        self::GLV_X_SITE_HOST,
    ];

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    /**
     * @inheritdoc
     */
    public function getLogDir()
    {
        return dirname(__DIR__) . '/log';
    }

    /**
     * @inheritdoc
     */
    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        if ($this->getEnvironment() === 'test') {
            $container->addCompilerPass(new TestContainerPass(), PassConfig::TYPE_OPTIMIZE);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/' . $this->environment . '/*.yaml');

        if (is_file(\dirname(__DIR__) . '/config/services.yaml')) {
            $container->import('../config/services.yaml');
            $container->import('../config/{services}_' . $this->environment . '.yaml');
        } elseif (is_file($path = \dirname(__DIR__) . '/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    /**
     * @inheritdoc
     */
    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__) . '/config/routes.yaml')) {
            $routes->import('../config/routes.yaml');
        } elseif (is_file($path = \dirname(__DIR__) . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

    /**
     * @inheritDoc
     */
    protected function initializeContainer(): void
    {
        if ($this->environment !== 'test') {
            $this->loadEnv($this->getSiteConfigDir());
            $this->loadEnvFromVault();
        }

        parent::initializeContainer();
    }

    /**
     * Загружаем env из Vault
     */
    protected function loadEnvFromVault(): void
    {
        $envPrefix = strtoupper(str_replace('-', '_', $this->getConfigAlias()));
        $envPrefixLength = strlen($envPrefix) + 1;

        foreach (getenv() as $envName => $envValue) {
            if (strpos($envName, $envPrefix) !== false) {
                $baseEnvName = substr($envName, $envPrefixLength, strlen($envName));

                $_ENV[$baseEnvName] = $envValue;
            }
        }
    }

    /**
     * Загружает env по x-host
     *
     * @param string $siteConfigDir
     */
    private function loadEnv(string $siteConfigDir): void
    {
        $dotEnv = new Dotenv();

        $siteConfigDir = rtrim($siteConfigDir, '/') . '/';

        $defaultEnvPath = $siteConfigDir . '.env';
        $environmentEnvPath = $siteConfigDir . '.env.' . $this->environment;

        if (is_file($defaultEnvPath)) {
            $dotEnv->load($defaultEnvPath);
        }
        if (is_file($environmentEnvPath)) {
            $dotEnv->load($environmentEnvPath);
        }

        $dotEnv->populate(['X_HOST' => $this->getXHost()], true);
        $dotEnv->populate(['CLI' => PHP_SAPI === 'cli' ? 'true' : 'false'], true);
    }

    /**
     * @return string
     */
    private function getXHost(): string
    {
        $xHost = '';

        if (isset($_SERVER['x-host'])) {
            $xHost = $_SERVER['x-host'];
        }

        if (isset($_SERVER['HTTP_x-host'])) {
            $xHost = $_SERVER['HTTP_x-host'];
        }

        if (isset($_SERVER['HTTP_X_HOST'])) {
            $xHost = $_SERVER['HTTP_X_HOST'];
        }

        if (isset($_GET['x-host'])) {
            $xHost = $_GET['x-host'];
        }

        $xHost = !empty($xHost) ? $xHost : self::DEFAULT_X_SITE_HOST;

        if (!in_array($xHost, $this->allowedXHosts)) {
            $xHost = self::DEFAULT_X_SITE_HOST;
        }

        return $xHost;
    }

    /**
     * @return string
     */
    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    /**
     * @return string
     */
    private function getSiteConfigDir(): string
    {
        return $this->getConfigDir() . '/sites/' . $this->getConfigAlias();
    }

    /**
     * @return mixed|string
     */
    private function getConfigAlias()
    {
        $xHost = $this->getXHost();

        [$lang, $siteConfigDir] = explode('.', $xHost);

        return $siteConfigDir;
    }
}
