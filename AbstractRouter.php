<?php

declare(strict_types=1);

namespace Lit\Core;

use Lit\Core\Interfaces\RouterInterface;
use Lit\Core\Interfaces\RouterStubResolverInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
     * @param RouterStubResolverInterface $stubResolver
     * @param RequestHandlerInterface $notFound
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
     * @param ServerRequestInterface $request
     * @return mixed
     */
    abstract protected function findStub(ServerRequestInterface $request);

    protected function resolve($stub): RequestHandlerInterface
    {
        return $this->stubResolver->resolve($stub);
    }

    public function makeDispatcher(): RequestHandlerInterface
    {
        return new RouterDispatchHandler($this);
    }

    /**
     * @param string $path
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
