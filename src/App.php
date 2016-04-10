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
    /**
     * @var Container
     */
    protected $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container ?: static::config();

        $this->container[static::class] = $this->container['app'] = $this->container->protect($this);
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

    public function produce($className, $parameters = [])
    {
        if (isset($this->container[$className])) {
            return $this->container[$className];
        }

        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();

        $params = $constructor
            ? array_map(
                function (\ReflectionParameter $parameter, $idx) use ($className, $parameters) {
                    if (isset($parameters[$idx])) {
                        return $parameters[$idx];
                    }

                    $parameterClass = $parameter->getClass()->getName();
                    if (isset($parameters[$parameterClass])) {
                        return $parameters[$parameterClass];
                    }

                    $parameterName = $parameter->getName();
                    if (isset($parameters[$parameterName])) {
                        return $parameters[$parameterName];
                    }

                    return $this->produceParam($className, $idx, $parameter);
                },
                $params = $constructor->getParameters(),
                array_keys($params)
            )
            : [];

        $instance = $class->newInstanceArgs($params);
        if ($instance instanceof IAppAware) {
            $instance->setApp($this);
        }

        $this->container[$className] = is_callable($instance)
            ? $this->container->protect($instance)
            : $instance;

        return $instance;
    }

    protected function produceParam($className, $idx, \ReflectionParameter $parameter)
    {
        $paramClass = $parameter->getClass();
        $paramName = $parameter->getName();

        if (isset($this->container["$className:$paramName"])) {
            return $this->container["$className:$paramName"];
        }

        if (isset($this->container["$className:$idx"])) {
            return $this->container["$className:$idx"];
        }

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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $middleware = new DispatcherMiddleware($this->router);

        return call_user_func($middleware, $request, $response);
    }


    protected function register($className, $fieldName)
    {
        $this->container[$fieldName] = function () use ($className) {
            return $this->produce($className);
        };

        return $this;
    }
}
