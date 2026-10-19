# wishbox/russian-post-client

Расширяемый PHP 8.4 клиент для API сервиса «Отправка» Почты России. Сейчас библиотека реализует один метод: расчёт стоимости пересылки `POST /1.0/tariff`.

## Требования

- PHP 8.4+
- PSR-18 HTTP-клиент
- PSR-17 фабрики запросов и потоков

## Установка

```bash
composer require wishbox/russian-post-client guzzlehttp/guzzle
```

Приложение должно предоставить реализации PSR-18 и PSR-17. В примере используется Guzzle.

## Использование

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Enum\PaymentMethod;
use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Request\Calculator\Dimension;
use WishboxRussianPost\RussianPostClient;

$httpClient = new GuzzleClient();
$httpFactory = new HttpFactory();

$client = new RussianPostClient(
    $httpClient,
    $httpFactory,
    $httpFactory,
    [
        'access_token' => getenv('RUSSIAN_POST_ACCESS_TOKEN'),
        'user_authorization' => getenv('RUSSIAN_POST_USER_AUTHORIZATION'),
    ],
);

$result = $client->tariff()->calculate(new CalculatorTariffRequestDto(
    mailType: MailType::PostalParcel,
    mailCategory: MailCategory::Ordinary,
    mass: 1_000,
    inventory: false,
    withOrderOfNotice: false,
    withSimpleNotice: false,
    indexTo: '101000',
    dimension: new Dimension(height: 10, length: 20, width: 30),
    paymentMethod: PaymentMethod::Cashless,
));

echo $result->totalRate; // копейки
echo $result->totalVat;  // копейки
echo $result->deliveryTime?->minDays;
echo $result->deliveryTime?->maxDays;
```

`access_token` — токен приложения без префикса `AccessToken`. `user_authorization` — результат `base64(login:password)` без префикса `Basic`. Если передать значения вместе с префиксами, клиент автоматически удалит их и сформирует заголовки корректно.

Не храните токены, логин или пароль в репозитории. Передавайте их через переменные окружения или хранилище секретов.

## Структура

- `WishboxRussianPost\RussianPostClient` — общая отправка HTTP-запросов, авторизация и преобразование ответов;
- `WishboxRussianPost\Config` — конфигурация клиента;
- `WishboxRussianPost\Api` — отдельный класс для каждой группы методов API;
- `WishboxRussianPost\Request` — типизированные DTO запросов;
- `WishboxRussianPost\Response` — типизированные DTO ответов и общие HTTP-ответы;
- `WishboxRussianPost\Exception` — отдельные исключения конфигурации, транспорта, HTTP и формата ответа.

Такая компоновка позволяет добавлять новые разделы API отдельными модулями, не меняя существующий тарифный интерфейс.

## Проверка

```bash
composer lint
composer test
```

Подробное описание поддерживаемого метода находится в [docs/rate-calculation.md](docs/rate-calculation.md).
