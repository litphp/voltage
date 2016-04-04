<?php namespace Lit\Core;

use Lit\Core\Interfaces\IAppAware;
use Lit\Core\Interfaces\IRouter;
use Lit\Core\Traits\AppAwareTrait;
use Psr\Http\Message\ServerRequestInterface;

class SimpleRouter implements IRouter, IAppAware
{
    use AppAwareTrait;

    protected $mounts = [];
    protected $routes = [];
    protected $autoSlash = true;
    protected $notFound;
    protected $methodNotAllowed;

    /**
     * @param callable|string $notFound
     * @param callable|string|null $methodNotAllowed
     */
    public function __construct($notFound, $methodNotAllowed = null)
    {
        $this->notFound = $notFound;
        $this->methodNotAllowed = $methodNotAllowed ?: $notFound;
    }

    public function route(ServerRequestInterface $request)
    {
        $method = strtolower($request->getMethod());
        $path = $request->getUri()->getPath();
        if (empty($path)) {
            $path = '/';
        } elseif ($path{0} !== '/') {
            $path = "/$path";
        }

        $routes = $this->routes;

        if (isset($routes[$path][$method])) {
            return $this->wrap($routes[$path][$method]);
        } elseif (isset($routes[$path])) {
            return $this->wrap($this->methodNotAllowed);
        } elseif ($result = $this->findMountedMiddleware($path)) {
            list($prefix, $middleware) = $result;
            return (new MountedMiddleware($this->wrap($middleware), $prefix))
                ->setAutoSlash($this->autoSlash);
        } else {
            return $this->wrap($this->notFound);
        }
    }

    public function register($method, $path, $middleware)
    {
        $this->routes[$path][strtolower($method)] = $middleware;
        return $this;
    }

    public function mount($prefix, $middleware)
    {
        $this->mounts[$prefix] = $middleware;

        return $this;
    }

    public function get($path, $middleware)
    {
        return $this->register('get', $path, $middleware);
    }

    public function post($path, $middleware)
    {
        return $this->register('post', $path, $middleware);
    }

    public function put($path, $middleware)
    {
        return $this->register('put', $path, $middleware);
    }

    public function delete($path, $middleware)
    {
        return $this->register('delete', $path, $middleware);
    }

    /**
     *
     * @param boolean $autoSlash
     * @return $this
     */
    public function setAutoSlash($autoSlash)
    {
        $this->autoSlash = $autoSlash;

        return $this;
    }

    protected function findMountedMiddleware($path)
    {
        if (empty($this->mounts)) {
            return null;
        }

        $pattern = implode('|', array_map(function ($prefix) {
            return preg_quote($prefix, '#');
        }, array_keys($this->mounts)));

        $count = preg_match("#^(?P<prefix>{$pattern})#", $path, $matches);
        if ($count === 0) {
            return null;
        }

        return [$matches['prefix'], $this->mounts[$matches['prefix']]];
    }

    protected function wrap($middleware)
    {
        if (is_callable($middleware)) {
            return $middleware;
        }

        if (is_string($middleware) && class_exists($middleware)) {
            return $this->app->produce($middleware);
        }

        throw new \InvalidArgumentException('illegal middleware');
    }
}
