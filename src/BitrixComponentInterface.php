<?php

namespace OpenTelemetry\Contrib\Instrumentation\Bitrix;

interface BitrixComponentInterface
{
    public function executeComponent();

    public function getRequest();
}
