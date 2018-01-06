<?php namespace Lit\Core;

use Lit\Core\Interfaces\RouterStubResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

class BasicRouter extends AbstractRouter
{
    protected $mounts = [];
    protected $routes = [];
    protected $autoSlash = true;
    protected $methodNotAllowed;

    /**
     * @param RouterStubResolverInterface $stubResolver
     * @param mixed $notFound stub for notFoundMiddleware
     * @param mixed $methodNotAllowed stub for methodNotAllowedMiddleware
     */
    public function __construct(RouterStubResolverInterface $stubResolver, $notFound, $methodNotAllowed = null)
    {
        parent::__construct($stubResolver, $notFound);
        
        $this->methodNotAllowed = $methodNotAllowed ?: $notFound;
    }

    protected function findStub(ServerRequestInterface $request)
    {
        $method = strtolower($request->getMethod());
        $path = $request->getUri()->getPath();
        $path = self::autoPrependSlash($path);

        $routes = $this->routes;

        if (isset($routes[$path][$method])) {
            return $routes[$path][$method];
        } elseif (isset($routes[$path]) && isset($this->methodNotAllowed)) {
            return $this->methodNotAllowed;
        } else {
            return $this->notFound;
        }
    }

    public function register(string $method, string $path, $routeStub): BasicRouter
    {
        $this->routes[$path][strtolower($method)] = $routeStub;
        return $this;
    }

    public function get(string $path, $routeStub): BasicRouter
    {
        return $this->register('get', $path, $routeStub);
    }

    public function post(string $path, $routeStub): BasicRouter
    {
        return $this->register('post', $path, $routeStub);
    }

    public function put(string $path, $routeStub): BasicRouter
    {
        return $this->register('put', $path, $routeStub);
    }

    public function delete(string $path, $routeStub): BasicRouter
    {
        return $this->register('delete', $path, $routeStub);
    }

    public function patch(string $path, $routeStub): BasicRouter
    {
        return $this->register('patch', $path, $routeStub);
    }
}
