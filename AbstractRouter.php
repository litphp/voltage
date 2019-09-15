<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\RouterInterface;
use Lit\Voltage\Interfaces\RouterStubResolverInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Base class for a typical router implementation
 */
abstract class AbstractRouter implements RouterInterface
{
    /**
     * @var mixed
     */
    protected $notFound;
    /**
     * @var RouterStubResolverInterface
     */
    protected $stubResolver;

    /**
     * @param RouterStubResolverInterface $stubResolver The stub resolver.
     * @param mixed                       $notFound     Stub to be used when no stub is found.
     */
    public function __construct(RouterStubResolverInterface $stubResolver, $notFound = null)
    {
        $this->notFound = $notFound;
        $this->stubResolver = $stubResolver;
    }

    public function route(ServerRequestInterface $request): RequestHandlerInterface
    {
        $stub = $this->findStub($request);

        return $this->resolve($stub ?: $this->notFound);
    }

    /**
     * Find a stub for incoming request. The stub will later be resolved by $this->stubResolver
     *
     * @param ServerRequestInterface $request The incoming request.
     * @return mixed
     */
    abstract protected function findStub(ServerRequestInterface $request);

    protected function resolve($stub): RequestHandlerInterface
    {
        return $this->stubResolver->resolve($stub);
    }

    /**
     * Create a request handler with this router.
     *
     * @return RequestHandlerInterface
     */
    public function makeDispatcher(): RequestHandlerInterface
    {
        return new RouterDispatchHandler($this);
    }

    /**
     * Prepend slash to a path if there isn't leading slash
     *
     * @param string $path The uri path.
     * @return string
     */
    public static function autoPrependSlash(string $path): string
    {
        if ($path === '' || $path{0} !== '/') {
            return "/$path";
        } else {
            return $path;
        }
    }
}
