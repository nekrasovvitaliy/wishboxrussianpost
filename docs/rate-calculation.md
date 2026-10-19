# Расчёт стоимости пересылки

Источник: [Спецификация API «Отправка» Почты России](https://otpravka.pochta.ru/specification#/nogroup-rate_calculate)  
Сохранено: 19 октября 2026 года.

Метод рассчитывает стоимость пересылки в зависимости от указанных входных данных. Индекс ОПС точки отправления берётся из профиля клиента. Возвращаемые денежные значения указываются в копейках.

## Запрос

- Метод: `POST`
- Локальный URL: `/1.0/tariff`

### Заголовки

| Заголовок | Значение |
| --- | --- |
| `Authorization` | `AccessToken <токен приложения>` |
| `X-User-Authorization` | `Basic <base64(login:password)>` |
| `Content-Type` | `application/json;charset=UTF-8` |

Подробнее: [токен авторизации приложения](https://otpravka.pochta.ru/specification#/authorization-token) и [ключ авторизации пользователя](https://otpravka.pochta.ru/specification#/authorization-key).

### Тело запроса

```json
{
  "completeness-checking": true,
  "contents-checking": true,
  "courier": true,
  "declared-value": 0,
  "delivery-point-index": "string",
  "dimension": {
    "height": 0,
    "length": 0,
    "width": 0
  },
  "dimension-type": "S",
  "entries-type": "GIFT",
  "fragile": true,
  "index-from": "string",
  "index-to": "string",
  "inventory": true,
  "mail-category": "SIMPLE",
  "mail-direct": 0,
  "mail-type": "UNDEFINED",
  "mass": 0,
  "notice-payment-method": "CASHLESS",
  "payment-method": "CASHLESS",
  "sms-notice-recipient": 0,
  "transport-type": "SURFACE",
  "vsd": true,
  "with-electronic-notice": true,
  "with-order-of-notice": true,
  "with-simple-notice": true
}
```

### Поля запроса

| Поле | Тип | Обязательность | Описание |
| --- | --- | --- | --- |
| `completeness-checking` | boolean | Необязательное | Признак услуги проверки комплектности |
| `contents-checking` | boolean | Необязательное | Признак услуги проверки вложения |
| `courier` | boolean | Необязательное | Отметка «Курьер» |
| `declared-value` | integer | Необязательное | Объявленная ценность |
| `delivery-point-index` | string | Необязательное | Идентификатор пункта выдачи заказов |
| `dimension` | object | Необязательное | Линейные размеры отправления |
| `dimension.height` | integer | Необязательное | Высота, см |
| `dimension.length` | integer | Необязательное | Длина, см |
| `dimension.width` | integer | Необязательное | Ширина, см |
| `dimension-type` | string | Необязательное | [Типоразмер](https://otpravka.pochta.ru/specification#/enums-dimension-type) |
| `entries-type` | string | Обязательное | [Категория вложения](https://otpravka.pochta.ru/specification#/enums-base-entries-type) для международных отправлений |
| `fragile` | boolean | Необязательное | Отметка «Осторожно» |
| `index-from` | string | Необязательное | Почтовый индекс ОПС места приёма |
| `index-to` | string | Необязательное | Почтовый индекс ОПС места назначения |
| `inventory` | boolean | Обязательное | Опись вложения |
| `mail-category` | string | Обязательное | [Категория РПО](https://otpravka.pochta.ru/specification#/enums-base-mail-category) |
| `mail-direct` | integer | Необязательное | [Код страны назначения](https://otpravka.pochta.ru/specification#/dictionary-countries) |
| `mail-type` | string | Обязательное | [Вид РПО](https://otpravka.pochta.ru/specification#/enums-base-mail-type) |
| `mass` | integer | Обязательное | Масса отправления, г |
| `notice-payment-method` | string | Необязательное | [Способ оплаты уведомления](https://otpravka.pochta.ru/specification#/enums-payment-methods) |
| `payment-method` | string | Необязательное | [Способ оплаты](https://otpravka.pochta.ru/specification#/enums-payment-methods) |
| `sms-notice-recipient` | integer | Необязательное | Признак услуги SMS-уведомления |
| `transport-type` | string | Необязательное | [Вид транспортировки](https://otpravka.pochta.ru/specification#/enums-base-transport-type) |
| `vsd` | boolean | Необязательное | Возврат сопроводительных документов |
| `with-electronic-notice` | boolean | Необязательное | Отметка «С электронным уведомлением» |
| `with-order-of-notice` | boolean | Обязательное | Отметка «С заказным уведомлением» |
| `with-simple-notice` | boolean | Обязательное | Отметка «С простым уведомлением» |

## Ответ

```json
{
  "avia-rate": {
    "rate": 0,
    "vat": 0
  },
  "completeness-checking-rate": {
    "rate": 0,
    "vat": 0
  },
  "contents-checking-rate": {
    "rate": 0,
    "vat": 0
  },
  "delivery-time": {
    "max-days": 0,
    "min-days": 0
  },
  "fragile-rate": {
    "rate": 0,
    "vat": 0
  },
  "ground-rate": {
    "rate": 0,
    "vat": 0
  },
  "insurance-rate": {
    "rate": 0,
    "vat": 0
  },
  "inventory-rate": {
    "rate": 0,
    "vat": 0
  },
  "notice-payment-method": "CASHLESS",
  "notice-rate": {
    "rate": 0,
    "vat": 0
  },
  "oversize-rate": {
    "rate": 0,
    "vat": 0
  },
  "payment-method": "CASHLESS",
  "sms-notice-recipient-rate": {
    "rate": 0,
    "vat": 0
  },
  "total-rate": 0,
  "total-vat": 0,
  "vsd-rate": {
    "rate": 0,
    "vat": 0
  }
}
```

### Поля ответа

| Поле | Тип | Обязательность | Описание |
| --- | --- | --- | --- |
| `avia-rate` | object | Необязательное | Плата за авиапересылку, коп. |
| `completeness-checking-rate` | object | Необязательное | Плата за проверку комплектности, коп. |
| `contents-checking-rate` | object | Необязательное | Плата за проверку вложений, коп. |
| `delivery-time` | object | Необязательное | Примерные сроки доставки |
| `delivery-time.max-days` | integer | Обязательное | Максимальный срок доставки, дней |
| `delivery-time.min-days` | integer | Необязательное | Минимальный срок доставки, дней |
| `fragile-rate` | object | Необязательное | Надбавка за отметку «Осторожно» |
| `ground-rate` | object | Необязательное | Плата за пересылку, коп. |
| `insurance-rate` | object | Необязательное | Плата за объявленную ценность, коп. |
| `inventory-rate` | object | Обязательное | Плата за опись вложения, коп. |
| `notice-payment-method` | string | Необязательное | [Способ оплаты уведомления](https://otpravka.pochta.ru/specification#/enums-payment-methods) |
| `notice-rate` | object | Необязательное | Надбавка за уведомление о вручении |
| `oversize-rate` | object | Необязательное | Надбавка за негабарит при массе более 10 кг |
| `payment-method` | string | Необязательное | [Способ оплаты](https://otpravka.pochta.ru/specification#/enums-payment-methods) |
| `sms-notice-recipient-rate` | object | Необязательное | Плата за пакет SMS получателю, коп. |
| `total-rate` | integer | Обязательное | Общая плата, коп. |
| `total-vat` | integer | Обязательное | Общая сумма НДС, коп. |
| `vsd-rate` | object | Обязательное | Плата за возврат сопроводительных документов, коп. |

Объекты тарифов (`avia-rate`, `ground-rate` и другие поля с суффиксом `-rate`) имеют общую структуру:

| Поле | Тип | Обязательность | Описание |
| --- | --- | --- | --- |
| `rate` | integer | Обязательное | Тариф без НДС, коп. |
| `vat` | integer | Необязательное | НДС, коп. |
