<?php

namespace OpenTelemetry\Contrib\Instrumentation\Bitrix;

class ResponseProvider
{
    public static function provide($response): int
    {
        return match ($response) {
            0 => 500,
            3 => 400,
            default => 200,
        };
    }

}