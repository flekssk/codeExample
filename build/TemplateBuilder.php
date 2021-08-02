<?php

//step 0
$templateValues = createTemplateValuesDto();
//step 1
replaceTemplateVariablesInAllProjectFiles($templateValues);
editReadme($templateValues->serviceName, $templateValues->productName);
//step 2
generateKeyForJWT($templateValues->jwtPassphrase);
setSecretVariables();

function geEnvOrRaiseException(string $variablesName)
{
    $result = getenv($variablesName);
    if (empty($result)) {
        throw new UnexpectedValueException(sprintf('%s is not set', $variablesName));
    }

    return $result;
}

/**
 * Создание переменной для авто-замены
 * @return TemplateValuesDto
 */
function createTemplateValuesDto(): TemplateValuesDto
{
    $productName = geEnvOrRaiseException('PRODUCT_NAME');
    $serviceName = geEnvOrRaiseException('SERVICE_NAME');
    $jwtPassphrase = getenv('JWT_PASSPHRASE');
    $dockerComposePortApp = getenv('DOCKER_COMPOSE_PORT_APP');
    $dockerComposePortDb = getenv('DOCKER_COMPOSE_PORT_DB');

    if (empty($dockerComposePortDb) && !empty($dockerComposePortApp)) {
        $dockerComposePortDb = $dockerComposePortApp + 1;
    }
    if (empty($jwtPassphrase)) {
        $jwtPassphrase = generateStrongPassword();
    }

    $templateValuesDto = new TemplateValuesDto();
    $templateValuesDto->productName = $productName;
    $templateValuesDto->serviceName = $serviceName;
    $templateValuesDto->jwtPassphrase = $jwtPassphrase;
    $templateValuesDto->dockerComposePortApp = $dockerComposePortApp;
    $templateValuesDto->dockerComposePortDb = $dockerComposePortDb;

    return $templateValuesDto;
}

/**
 * Заменяет переменные в шаблоне по всем файлам
 * @param TemplateValuesDto $templateValues
 */
function replaceTemplateVariablesInAllProjectFiles(TemplateValuesDto $templateValues)
{
    $projectDir = getenv('CI_PROJECT_DIR');

    if (empty($projectDir)) {
        throw new UnexpectedValueException('CI_PROJECT_DIR is not set');
    }

    $excludedDirs = [
        'vendor',
        'var',
        '.idea',
        '.git'
    ];

    $excludedFiles = [
        'TemplateBuilder.php',
        '.gitignore',
        '.gitkeep'
    ];

    /**
     * @param SplFileInfo $file
     * @param mixed $key
     * @param RecursiveCallbackFilterIterator $iterator
     * @return bool True if you need to recurse or if the item is acceptable
     */
    $filter = static function ($file, $key, $iterator) use ($excludedDirs) {
        if ($iterator->hasChildren() && !in_array($file->getFilename(), $excludedDirs, true)) {
            return true;
        }
        return $file->isFile();
    };

    $innerIterator = new RecursiveDirectoryIterator(
        $projectDir,
        RecursiveDirectoryIterator::SKIP_DOTS
    );
    $iterator = new RecursiveIteratorIterator(
        new RecursiveCallbackFilterIterator($innerIterator, $filter)
    );
    $files = [];
    foreach ($iterator as $pathname => $fileInfo) {
        if (!in_array(basename($fileInfo->getFilename()), $excludedFiles, true)) {
            $files[] = $fileInfo->getPathname();
        }
    }

    foreach ($files as $file) {
        replaceTemplateVariables($file, $templateValues);
    }
}

/**
 * Заменяет переменные в шаблоне
 * @param $file
 * @param $templateValuesDto
 */
function replaceTemplateVariables($file, $templateValuesDto)
{
    $temp = file_get_contents($file);
    $temp = str_replace(
        [
            'erprof',
            'erprof',
            '\<your-service-name\>',
            '<jwt_passphrase>',
            '<your-unique-app-host-port>',
            '<your-unique-db-host-port>'
        ],
        [
            $templateValuesDto->productName,
            $templateValuesDto->serviceName,
            $templateValuesDto->serviceName,
            $templateValuesDto->jwtPassphrase,
            $templateValuesDto->dockerComposePortApp,
            $templateValuesDto->dockerComposePortDb
        ],
        $temp
    );

    if (!file_put_contents($file, $temp)) {
        echo 'There was a problem (permissions?) replacing the file ' . $file . PHP_EOL;
    }
}

/**
 * Генерирует ключи для JWT
 * @param $jwtPassphrase
 */
function generateKeyForJWT($jwtPassphrase)
{
    exec(sprintf('
openssl genrsa -out $CI_PROJECT_DIR/app/config/jwt/prod/private.pem -aes256 -passout pass:%s 4096
openssl rsa -pubout -in $CI_PROJECT_DIR/app/config/jwt/prod/private.pem -passin pass:%s -out  $CI_PROJECT_DIR/app/config/jwt/prod/public.pem
', $jwtPassphrase, $jwtPassphrase));
}

/**
 * Генерирует пароль
 * @param int $length
 * @param bool $add_dashes
 * @param string $available_sets
 * @return bool|string
 */
function generateStrongPassword($length = 11, $add_dashes = false, $available_sets = 'lud')
{
    $sets = array();
    if (strpos($available_sets, 'l') !== false) {
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    }
    if (strpos($available_sets, 'u') !== false) {
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    }
    if (strpos($available_sets, 'd') !== false) {
        $sets[] = '23456789';
    }
    if (strpos($available_sets, 's') !== false) {
        $sets[] = '!@#$%&*?';
    }

    $all = '';
    $password = '';
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }

    $all = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++) {
        $password .= $all[array_rand($all)];
    }

    $password = str_shuffle($password);

    if (!$add_dashes) {
        return $password;
    }

    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while (strlen($password) > $dash_len) {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

function setSecretVariables()
{
    requestGitLabApi('projects/' . getProjectPath() . '/variables', 'POST', [
        'variable_type' => 'env_var',
        'key' => 'DOCKER_REGISTRY_USER',
        'value' => geEnvOrRaiseException('DOCKER_REGISTRY_USER'),
    ]);

    requestGitLabApi('projects/' . getProjectPath() . '/variables', 'POST', [
        'variable_type' => 'env_var',
        'key' => 'DOCKER_REGISTRY_PASSWORD',
        'value' => geEnvOrRaiseException('DOCKER_REGISTRY_PASSWORD'),
    ]);
}

/**
 * Делает запрос к GitLab Api
 * @param $url
 * @param string $method
 * @param array $postParams
 * @return bool|string
 */
function requestGitLabApi($url, $method = 'GET', $postParams = [])
{
    $ch = curl_init();

    $headers = [
        'PRIVATE-TOKEN: ' . geEnvOrRaiseException('GIT_TOKEN')
    ];

    $optArray = [
        CURLOPT_URL => 'http://gitlab.action-media.ru/api/v4/' . $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ];

    if ($method === 'POST') {
        $optArray[CURLOPT_POST] = 1;
        $optArray[CURLOPT_POSTFIELDS] = $postParams;
    }

    curl_setopt_array($ch, $optArray);

    $result =  curl_exec($ch);

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (strpos((string)$responseCode, '2') !== 0) {
        throw new UnexpectedValueException(sprintf('Request to GitLab Api is not success, response code is %s', $responseCode));
    }

    curl_close($ch);

    return $result;
}

/**
 * Возвращает url encoded путь проекта на основании переменной REPO
 * @return string
 */
function getProjectPath(): string
{
    $repo = geEnvOrRaiseException('REPO');
    $path = $repo;
    if (strpos($repo, 'https://gitlab.action-media.ru/') !== false) {
        $path = substr($repo, strpos($repo, 'https://gitlab.action-media.ru/') + strlen('https://gitlab.action-media.ru/'));
    }

    return urlencode($path);
}


function editReadme($serviceName, $productName)
{
    $readmeFile = dirname(__DIR__) . '/README.md';

    $originalReadmeContent = file_get_contents($readmeFile);

    $editedReadme =  strstr($originalReadmeContent, '## Подъем девелоперского окружения');
    $editedReadme = '# ' . $serviceName . ' ' . $productName . PHP_EOL . PHP_EOL .  $editedReadme;

    if (!file_put_contents($readmeFile, $editedReadme)) {
        echo 'There was a problem (permissions?) replacing the file ' . $readmeFile . PHP_EOL;
    }
}

class TemplateValuesDto
{
    /**
     * @var string
     */
    public $productName = 'erprof';
    /**
     * @var string
     */
    public $serviceName = 'erprof';
    /**
     * @var string
     */
    public $jwtPassphrase = '<jwt_passphrase>';
    /**
     * @var string
     */
    public $dockerComposePortApp = '<your-unique-app-host-port>';
    /**
     * @var string
     */
    public $dockerComposePortDb = '<your-unique-db-host-port>';
}
