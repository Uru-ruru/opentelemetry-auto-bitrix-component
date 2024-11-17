[![Releases](https://img.shields.io/badge/releases-purple)](https://github.com/Uru-ruru/opentelemetry-auto-bitrix-component/releases)
[![Issues](https://img.shields.io/badge/issues-pink)](https://github.com/Uru-ruru/opentelemetry-auto-bitrix-component/issues)
[![Latest Version](http://poser.pugx.org/Uru-ruru/opentelemetry-auto-bitrix-component/v/unstable)](https://packagist.org/packages/Uru-ruru/opentelemetry-auto-bitrix-component/)
[![Stable](http://poser.pugx.org/Uru-ruru/opentelemetry-auto-bitrix-component/v/stable)](https://packagist.org/packages/Uru-ruru/opentelemetry-auto-bitrix-component/)

# OpenTelemetry Bitrix Framework auto-instrumentation

## Overview
Auto-instrumentation hooks are registered via composer, and spans will automatically be created for:
- `\CBitrixComponent::executeComponent()` - root span

## Extend

You can extent Bitrix standard component class by adding additional method `getRequest` this code example:

```php
use Bitrix\Main\HttpRequest;
use Bitrix\Main\Request;

public function getRequest(): Request|HttpRequest
{
  return $this->request;
}
```
Also you can implement `src/BitrixComponentInterface.php` interface for compatibility or extend `src/BaseComponent.php` class in your components classes.

## Configuration

The extension can be disabled via [runtime configuration](https://opentelemetry.io/docs/instrumentation/php/sdk/#configuration):

```shell
OTEL_PHP_DISABLED_INSTRUMENTATIONS=bitrix.component
```
