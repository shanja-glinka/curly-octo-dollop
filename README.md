# curly-octo-dollop


# Требования к срерверу

For usage:
* PHP 7.1-x64
* MySQL 5.6-x64


В MySQL требуется отключить строгий режим `sql_mode= ""`

# Использование

SBER Success:
```http
  GET /https://trvlne.cc/payment/1/callback/success?orderId=51858812-8013-0b1f-5129-61246a7184c7
```
SBER Fail:
```http
  GET /https://trvlne.cc/payment/1/callback/fail?orderId=51858812-8013-0b1f-5129-61246a7184c7
```


# Установка
Конфигурационный файл находится в дирректории `/assets/data/`

```bash
  /assets/data/config.php
```

Для соединения с бд измени ключ `connection` 


Загрузи базу данных из дирректории `/assets/data/`

```bash
  /assets/data/ex-test-pa-app.sql
```

В MySQL требуется отключить строгий режим `sql_mode= ""`


# Примечание
Я не смогу получить userName и password от Sber Api теста, поэтмоу использовал примеры ответов и запросов их документации

Файл app\system\utils\payments\SberPayment.php -> makeRequest(... | строка 53
```json
{
    "errorCode":"0",
    "orderId":"51858812-8013-0b1f-5129-61246a7184c7",
    "formUrl":"https://3dsec.sberbank.ru/payment/merchants/test/payment_ru.html?mdOrder=51858812-8013-0b1f-5129-61246a7184c7"
}
```
