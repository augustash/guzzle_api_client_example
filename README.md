# Guzzle API Client Example

## Overview

Just a quick example of how to use [**Guzzle 6**](https://github.com/guzzle/guzzle) (see [**docs**](http://docs.guzzlephp.org/en/latest/index.html)) as a PHP HTTP client to consume HTTP web services.

I've purposely committed the `vendor` directory for easier setup if you do not already have `composer` installed on your machine. If you don't have composer, please consider installing it by following the [instructions](https://getcomposer.org/doc/00-intro.md) provided by http://getcomposer.org.

## Requirements

+ PHP 5.3.2+ (PHP 5.6.x or 7.0.x preferred)

## Examples

You can refer to the `say_hello.php` script as a very basic example of how to make simple request to a non-existant API. You'll want to pass valid URL values for the `base_uri` and `url` options.

### Say Hello

In this example, we simply assume we can pass a name to an HTTP web service and that we get a valid response back (i.e., `Hello :name`)

```php
<?php

require 'vendor/autoload.php';
require_once './Api/Example/HttpClient.php';

$client = new \Augustash\Api\Example\HttpClient(['base_uri' => 'http://foo.dev/api', 'url' => 'bar']);

$dataFormat = 'xml'; // or 'json'
$response = $client->sayHello('Josh', $dataFormat);

$code = $response->getStatusCode(); // 200
$reason = $response->getReasonPhrase(); // OK

echo $response->getBody();
```
