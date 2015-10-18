<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Lit\Core\Interfaces\IView;
use Nimo\AbstractMiddleware;
use Nimo\MiddlewareErrorException;
use Nimo\MiddlewareStack;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * the lit app class
 *
 * @property IRouter router
 * @property IView view
 */
class App extends AbstractMiddleware
{
    protected $container;
    protected $beforeStack;
    protected $afterStack;
    protected $error = null;

    const REQ_ATTR_APP = self::class;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->beforeStack = new MiddlewareStack();
        $this->afterStack = new MiddlewareStack();
    }

    public function __get($name)
    {
        return $this->container[$name];
    }

    public static function config()
    {
        $container = new Container();

        return $container;
    }

    protected function main()
    {
        if ($this->request->getAttribute(self::REQ_ATTR_APP)) {
            throw new \Exception(__METHOD__ . '/' . __LINE__);
        }

        $next = $this->next;

        $this->next = function (
            ServerRequestInterface $request = null,
            ResponseInterface $response = null,
            $error = null
        ) {
            if (isset($request)) {
                $this->request = $request;
            }

            if (isset($response)) {
                $this->response = $response;
            }

            if (isset($error)) {
                throw MiddlewareErrorException::wrap($error);
            }

            return $this->response;
        };

        $this->request = $this->request
            ->withAttribute(self::REQ_ATTR_APP, $this);

        $this->response = $this->invokeCallback($this->beforeStack);

        $action = $this->router->route($this->request);

        $this->response = $this->invokeCallback($action);

        $this->response = $this->invokeCallback($this->afterStack);

        $this->next = $next;

        return $this->next();
    }

    public function append($middleware)
    {
        $this->afterStack->append($middleware);

        return $this;
    }

    public function prepend($middleware)
    {
        $this->beforeStack->prepend($middleware);

        return $this;
    }
}
