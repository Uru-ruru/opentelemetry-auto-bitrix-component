<?php

declare(strict_types=1);

use OpenTelemetry\Contrib\Instrumentation\Bitrix\BitrixComponentInstrumentation;
use OpenTelemetry\SDK\Common\Configuration\Configuration;
use OpenTelemetry\SDK\Sdk;

if (class_exists(Sdk::class) && true === Sdk::isInstrumentationDisabled(BitrixComponentInstrumentation::NAME)) {
    return;
}

if (false === extension_loaded('opentelemetry')) {
    trigger_error(
        'The opentelemetry extension must be loaded in order to autoload the OpenTelemetry Bitrix Framework auto-instrumentation',
        E_USER_WARNING
    );

    return;
}
$legacySupport = Configuration::getBoolean(BitrixComponentInstrumentation::LEGACY_SUPPORT, false);

BitrixComponentInstrumentation::register($legacySupport);
