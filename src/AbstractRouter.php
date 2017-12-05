<?php namespace Lit\Core;

use Interop\Http\Server\RequestHandlerInterface;
use Lit\Core\Interfaces\RouterInterface;
use Lit\Core\Interfaces\RouterStubResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

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
    public function __construct(RouterStubResolverInterface $stubResolver, $notFound)
    {
        $this->notFound = $notFound;
        $this->stubResolver = $stubResolver;
    }

    public function route(ServerRequestInterface $request): RequestHandlerInterface
    {
        $stub = $this->findStub($request);

        return $stub ? $this->resolve($stub) : $this->resolve($this->notFound);
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
