<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Lit\Core\Interfaces\IView;
use Nimo\AbstractMiddleware;
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

        $this->request = $this->request
            ->withAttribute(self::REQ_ATTR_APP, $this);

        return call_user_func($this->beforeStack, $this->request, $this->response, [$this, 'dispatch']);
    }

    protected function dispatch(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        $action = $this->router->route($this->request);
        return call_user_func($action, $this->request, $this->response, [$this, 'afterDispatch']);
    }

    protected function afterDispatch(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        return call_user_func($this->afterStack, $this->request, $this->response, $this->next);
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
