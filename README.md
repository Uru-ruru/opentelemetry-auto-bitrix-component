[![Latest Stable Version](https://poser.pugx.org/uru/opentelemetry-auto-bitrix-component/v)](//packagist.org/packages/uru/opentelemetry-auto-bitrix-component)
[![Total Downloads](https://poser.pugx.org/uru/opentelemetry-auto-bitrix-component/downloads)](//packagist.org/packages/uru/opentelemetry-auto-bitrix-component)
[![Latest Unstable Version](https://poser.pugx.org/uru/opentelemetry-auto-bitrix-component/v/unstable)](//packagist.org/packages/uru/digital-river-models)
[![License](https://poser.pugx.org/uru/opentelemetry-auto-bitrix-component/license)](//packagist.org/packages/uru/opentelemetry-auto-bitrix-component)

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
