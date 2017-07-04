<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Psr\Http\Message\ResponseInterface;
use Zend\Stratigility\MiddlewarePipe;

/**
 * the lit app class
 */
class App extends MiddlewarePipe
{
    /**
     * @var IRouter
     */
    protected $router;

    /**
     * App constructor.
     * @param IRouter $router
     */
    public function __construct(IRouter $router, ResponseInterface $responsePrototype)
    {
        parent::__construct();

        $this->setResponsePrototype($responsePrototype);
        $this->router = $router;

        $this->pipeMiddlewares();
    }

    protected function pipeMiddlewares()
    {
        $this->pipe(new DispatcherMiddleware($this->router));
    }
}
