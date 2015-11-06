<?php namespace Lit\Core;

use Lit\Core\Interfaces\IAppAware;
use Lit\Core\Interfaces\IRouter;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * the lit app class
 *
 * @property App $app
 * @property IRouter $router the main router
 */
class App
{
    protected $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container ?: static::config();

        $this->container['app'] = $this->container->protect($this);
    }

    public static function config()
    {
        $container = new Container();

        return $container;
    }

    public function __get($name)
    {
        if (class_exists($name)) {
            return $this->produce($name);
        }
        return $this->container[$name];
    }

    public function __isset($name)
    {
        return isset($this->{$name}) || isset($this->container[$name]);
    }

    public function produce($className)
    {
        if (isset($this->container[$className]) && $this->container[$className] instanceof $className) {
            return $this->container[$className];
        }

        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        $params = $constructor
            ? array_map([$this, 'produceParam'], $constructor->getParameters())
            : [];

        $instance = $class->newInstanceArgs($params);
        if ($instance instanceof IAppAware) {
            $instance->setApp($this);
        }

        if (!isset($this->container[$className])) {
            $this->container[$className] = $instance;
        }

        return $instance;
    }

    public function dispatch(IRouter $router)
    {
        return new DispatcherMiddleware($router);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $middleware = $this->dispatch($this->router);

        return call_user_func($middleware, $request, $response);
    }

    protected function produceParam(\ReflectionParameter $parameter)
    {
        $paramClass = $parameter->getClass();

        if ($paramClass) {
            return $this->produce($paramClass->getName());
        }

        if ($parameter->isOptional()) {
            return $parameter->getDefaultValue();
        }

        if ($parameter->allowsNull()) {
            return null;
        }

        throw new \Exception('failed to produce ' . $parameter->getDeclaringClass()->getName());
    }

    protected function register($className, $fieldName)
    {
        $this->container[$fieldName] = function () use ($className) {
            return $this->produce($className);
        };

        return $this;
    }
}
