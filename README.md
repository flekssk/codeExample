# Описание вашего проекта
Единый реестр профессий

## Подъем девелоперского окружения

Для начала работ вам необходимо установить docker-compose на свою машину, далее:

```bash
./dev-up.sh
```

Приложение будет доступно по следующему URL: `http://localhost`

Swagger-документация доступна по URL: `http://localhost/_/swaggerui`

Перед пушем в ветку можно проверить код линтером

```bash
./lint.sh
```

### Тестовое окружение

Во время подъема окружения поднимается две БД, одна для разработки(*db*), вторая для запуска тестов, которым необходимо работать с БД(*db_test*).

Для того чтобы запускать тесты и при этом не "убить" рабочую БД для разработки используйте сервис **test** вместо сервиса **app**:
```bash
docker-compose exec test ./vendor/bin/codecept run
```

Для работы с моками в тестах, необходимо раскоментировать строки с мок-сервером wiremock в docker-compose файле. Для того что бы тесты работали с заглушками необходимо указать хост контейнера, на который будут отправляться запросы. Это можно сделать через .env.test файл.

Все заглушки находятся в директиве /tests/wiremock/mappings. Заглушки могут быть сгенерированы как статически так и динамически. Пример использования динамической заглушки добавлен в тест HelloCest.php.

Заглушки поддерживают вложенность в директории, маппинг происходит по url указанном в заглушке, а не по пути. Подробнее о заглушках можно посмотреть в документации - http://wiremock.org/docs/stubbing/

Перед запуском тестов необхоидимо загрузить туда фикстуры(они накатывается автоматически при запуске *./dev-up.sh*)
```bash
docker-compose exec test ./bin/console doctrine:fixtures:load -n --purge-with-truncate
```

### Настройка  Xdebug
Preferences -> Languages -> Frameworks -> PHP -> Servers

Нажимаем добавить сервер(значок "+").
В качестве имени вводим **\<your-service-name\>** (это важно), host - **localhost**, ставим чекбокс напротив "Use path mapping", в появившемся окне в поле "Absolute path on the server" напротив папки локальной подпапки **app**  пишем **/var/www**

Для того чтобы начать пользоваться:
- расставьте break points в IDE
- включите прослушивание DEBUG connections(значок трубки в правом верхнем углу экрана).
- Для Web: Добавьте к URL GET параметр *XDEBUG_SESSION_START=1* или  установите одно из расширений для брауера: [https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html](https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html)
- Для Console: перед запуской скрипта выполните команду `export XDEBUG_CONFIG=""`  и далее запускайте свой консольный скрипт.

**Внимание** Xdebug по умолчанию настроен для работы в ОС macOS, в случае если вы пытаетесь настроить его работу в другой ОС, вам вероятнее всего придется поменять значение *PHP_XDEBUG_REMOTE_HOST* в файле `.env` в корне проекта


## Работа с Symfony

### Кодогенерация API

Чтобы создать минимально необходимую структуру для API, воспользуйтесь командой:

```bash
./bin/console action:make:controller /api/v1/client-events_create --http-method=post
```

Формат формирования API-методов описан тут: [https://conf.action-media.ru/pages/viewpage.action?pageId=78027582](https://conf.action-media.ru/pages/viewpage.action?pageId=78027582)

Сразу после генерации можно запустить тесты: `docker-compose exec test ./vendor/bin/codecept run` (они рабочие и проверяют базовые коды ответов).
Сразу после генерации можно запустить тесты: `docker-compose exec test ./vendor/bin/codecept run` (они рабочие и проверяют базовые коды ответов).


### Логгирование

Все логи складываются в папочку app/logs одним уровнем. И обязательно должны иметь расширение .log

Чтобы определить логгер, который будет писать в отдельный файл требуется:

1. Открыть файл `app/config/packages/monolog.yaml`
2. Зарегистрировать новый канал логгирования в секции monolog.channels (например, `'http_api_exceptions'`)
3. Исключить канал логгирования в хендреле nested (например, `'!http_api_exceptions'`)
4. Создать хендлер по примеру `'http_api_exceptions'`
5. В файле `app/config/packages/prod/monolog.yaml` нужно повысить уровень логгирования (чтобы в проде debug-сообщения не попадали в elk)
6. (Необязательно) В файле `app/config/packages/local/monolog.yaml` можно проставить `formatter: ~`, чтобы использовался стандартный вывод логов симфони

При использовании конкретного логгера зависимость может выглядеть как: `@monolog.logger.http_api_exceptions`. В класс он будет прилетать, как `Psr\Log\LoggerInterface`

### Доступность URL из публичного пространства

По умолчанию все контроллеры закрыты для доступа из публичного пространства(анализируется заголовок `x-pub`).  Если есть необходимость дать доступ к URL публично - контроллер должен реализовать пустой интерфейс `\App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface`, например:
```php

use \App\UI\Middleware\RestrictAccessFromPublic\AccessibleFromPublicInterface;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetNewsController extends AbstractController implements AccessibleFromPublicInterface
{
    //...
}
```

### Health check

Что такое health check можно узнать [здесь](https://conf.action-media.ru/display/DEV/Health+checks).

По умолчанию в приложении активирована проверка доступности БД, если ваше приложение ее не использует, необходимо отключить проверку в файле конфигурации app/config/services.yaml:
```yaml
App\Application\HealthCheck\CompositeHealthCheckService:
  -
    - '@App\Infrastructure\HealthCheck\DbConnectionHealthChecker'
```
Также вы можете дополнять приложение дополнительными проверками, реализуя интерфейс \App\Application\HealthCheck\HealthCheckServiceInterface и добавляя реализацию в конфигурацию:
```yaml
App\Infrastructure\HealthCheck\YourOwnHealthChecker: ~
App\Application\HealthCheck\CompositeHealthCheckService:
  -
    - '@App\Infrastructure\HealthCheck\DbConnectionHealthChecker'
    - '@App\Infrastructure\HealthCheck\YourOwnHealthChecker'
```

# Разделение реестров (мультидомен)

## Описание работы

Вся суть разделения реестра кроется в кастомизации env переменных.

Заменить env переменную можно в config/sites/{REGISTRY_ALIAS}/.env.{ENVIRONMENT}

REGISTRY_ALIAS - это x-host без префикса языковой зоны, к примеру для ru-ru.er_glavbukh_ru
REGISTRY_ALIAS будет er_glavbukh_ru.

Загружаются переменные перед инициализацией контейнера в app/src/Kernel::initializeContainer.

Порядок загрузки .env:

1. app/.env
2. app/.env.{ENVIRONMENT}
3. app/config/sites/{REGISTRY_ALIAS}/.env из папки конфига выбранного реестра на основание -x-host
4. app/config/sites/{REGISTRY_ALIAS}/.env.{ENVIRONMENT} из папки конфига выбранного реестра на основание -x-host

Старайтесь выносить общие для всех реестров и environment переменные в более низкий уровень.

## Как выбрать окружение реестра

Реестры разделаются между собой по x-host, по умолчанию, без параметра x-host, выбирается ru-ru.er_glavbukh_ru,
так как это необходимо для билда образа.

При http запросах:

- Передать заголовок x-host
- Передать GET параметр x-host

При вызове консольной команды:

- Передав параметр --x-host

## Список допустимых x-host

- ru-ru.er_glavbukh_ru
- ru-ru.er_1glms_ru
- ru-ru.er_budgetnik_ru
- ru-ru.er_gkh_ru
- ru-ru.er_gzakypki_ru
- ru-ru.er_kdelo_ru
- ru-ru.er_law_ru
- ru-ru.er_otruda_ru
- ru-ru.erro_menobr_ru
- ru-ru.sovet_gd_ru
