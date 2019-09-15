<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\RouterStubResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Basic router implementation that do strict match against method & path
 */
class BasicRouter extends AbstractRouter
{
    protected $mounts = [];
    protected $routes = [];
    protected $autoSlash = true;
    protected $methodNotAllowed;

    /**
     * @param RouterStubResolverInterface $stubResolver     The stub resolver.
     * @param mixed                       $notFound         Stub when route is not found.
     * @param mixed                       $methodNotAllowed Stub when route exists but method is mismatch.
     */
    public function __construct(RouterStubResolverInterface $stubResolver, $notFound = null, $methodNotAllowed = null)
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

    /**
     * Register a route
     *
     * @param string $method    The HTTP method.
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function register(string $method, string $path, $routeStub): BasicRouter
    {
        $this->routes[$path][strtolower($method)] = $routeStub;
        return $this;
    }

    /**
     * Register a GET route
     *
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function get(string $path, $routeStub): BasicRouter
    {
        return $this->register('get', $path, $routeStub);
    }


    /**
     * Register a POST route
     *
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function post(string $path, $routeStub): BasicRouter
    {
        return $this->register('post', $path, $routeStub);
    }


    /**
     * Register a PUT route
     *
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function put(string $path, $routeStub): BasicRouter
    {
        return $this->register('put', $path, $routeStub);
    }


    /**
     * Register a DELETE route
     *
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function delete(string $path, $routeStub): BasicRouter
    {
        return $this->register('delete', $path, $routeStub);
    }

    /**
     * Register a PATCH route
     *
     * @param string $path      The full URI path.
     * @param mixed  $routeStub The route.
     * @return $this
     */
    public function patch(string $path, $routeStub): BasicRouter
    {
        return $this->register('patch', $path, $routeStub);
    }
}
