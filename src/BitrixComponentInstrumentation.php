<?php

namespace OpenTelemetry\Contrib\Instrumentation\Bitrix;

use Bitrix\Main\HttpRequest;
use OpenTelemetry\API\Globals;
use OpenTelemetry\API\Instrumentation\CachedInstrumentation;
use OpenTelemetry\API\Trace\Span;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use OpenTelemetry\SemConv\TraceAttributes;

use function OpenTelemetry\Instrumentation\hook;

class BitrixComponentInstrumentation
{
    public const NAME = 'bitrix.component';
    public const CODE_RESULT = self::NAME.'.response.result';
    public const PARAMS = self::NAME.'.array.params';
    public const RESULT = self::NAME.'.array.result';
    public const REQUEST_PAGE = self::NAME.'.request.page';
    public const REQUEST_PAGE_DIR = self::NAME.'.request.directory';
    public const REQUEST_QUERY = self::NAME.'.request.query';
    public const REQUEST_COOKIES = self::NAME.'.request.cookies';

    public static function register(): void
    {
        $instrumentation = new CachedInstrumentation(
            'io.opentelemetry.contrib.php.'.self::NAME,
            null,
            'https://opentelemetry.io/schemas/1.25.0'
        );
        hook(
            class: \CBitrixComponent::class,
            function: 'executeComponent',
            pre: static function (\CBitrixComponent $component, array $params, string $class, string $function, ?string $filename, ?int $lineno) use ($instrumentation) {
                $request = (method_exists($component, 'getRequest') && $component->getRequest() instanceof HttpRequest) ? $component->getRequest() : null;
                $builder = $instrumentation->tracer()
                    ->spanBuilder($component->getName())
                    ->setSpanKind(SpanKind::KIND_SERVER)
                    ->setAttribute(TraceAttributes::CODE_FUNCTION, $function)
                    ->setAttribute(TraceAttributes::CODE_NAMESPACE, $class)
                    ->setAttribute(TraceAttributes::CODE_FILEPATH, $filename)
                    ->setAttribute(TraceAttributes::CODE_LINENO, $lineno)
                ;

                if (is_array($component->arResult) && count($component->arResult) > 0) {
                    $builder->setAttribute(self::RESULT, @json_encode($component->arResult));
                }
                if (is_array($component->arParams) && count($component->arParams) > 0) {
                    $builder->setAttribute(self::PARAMS, @json_encode($component->arParams));
                }

                $parent = Context::getCurrent();
                if ($request) {
                    $parent = Globals::propagator()->extract($request);
                    $span = $builder
                        ->setParent($parent)
                        ->setAttribute(self::REQUEST_PAGE, $request->getRequestedPage())
                        ->setAttribute(self::REQUEST_PAGE_DIR, $request->getRequestedPageDirectory())
                        ->setAttribute(self::REQUEST_QUERY, @json_encode($request->getQueryList()->toArray()))
                        ->setAttribute(self::REQUEST_COOKIES, @json_encode($request->getCookieList()->toArray()))
                        ->startSpan()
                    ;
                } else {
                    $span = $builder->startSpan();
                }

                Context::storage()->attach($span->storeInContext($parent));
            },
            post: static function (\CBitrixComponent $component, array $params, $response, ?\Throwable $exception) {
                $scope = Context::storage()->scope();
                if (!$scope) {
                    return $response;
                }
                $scope->detach();
                $span = Span::fromContext($scope->context());
                if ($exception) {
                    $span->recordException($exception, [TraceAttributes::EXCEPTION_ESCAPED => true]);
                    $span->setStatus(StatusCode::STATUS_ERROR, $exception->getMessage());
                }
                if ($response) {
                    $span->setAttribute(self::CODE_RESULT, @json_encode($response));
                }
                $span->end();
            }
        );
    }
}
