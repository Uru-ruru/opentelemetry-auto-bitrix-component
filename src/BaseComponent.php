<?php

namespace OpenTelemetry\Contrib\Instrumentation\Bitrix;

use Bitrix\Main\HttpRequest;
use Bitrix\Main\Request;

class BaseComponent extends \CBitrixComponent implements BitrixComponentInterface
{

    public function executeComponent()
    {
    }
    public function getRequest(): Request|HttpRequest
    {
        return $this->request;
    }
}
