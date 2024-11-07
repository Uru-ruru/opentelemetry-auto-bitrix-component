[![Releases](https://img.shields.io/badge/releases-purple)](https://github.com/Uru-ruru/opentelemetry-auto-bitrix-component/releases)
[![Issues](https://img.shields.io/badge/issues-pink)](https://github.com/Uru-ruru/opentelemetry-auto-bitrix-component/issues)
[![Latest Version](http://poser.pugx.org/Uru-ruru/opentelemetry-auto-bitrix-component/v/unstable)](https://packagist.org/packages/Uru-ruru/opentelemetry-auto-bitrix-component/)
[![Stable](http://poser.pugx.org/Uru-ruru/opentelemetry-auto-bitrix-component/v/stable)](https://packagist.org/packages/Uru-ruru/opentelemetry-auto-bitrix-component/)

# OpenTelemetry Bitrix Framework auto-instrumentation

## Overview
Auto-instrumentation hooks are registered via composer, and spans will automatically be created for:
- `\CBitrixComponent::executeComponent()` - root span

## Configuration

The extension can be disabled via [runtime configuration](https://opentelemetry.io/docs/instrumentation/php/sdk/#configuration):

```shell
OTEL_PHP_DISABLED_INSTRUMENTATIONS=bitrix.component
```
