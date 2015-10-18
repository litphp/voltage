<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Nimo\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;

abstract class Action extends AbstractMiddleware
{
    const REQ_ATTR_APP = App::class;

    /**
     * @var App
     */
    protected $app;

    protected function main()
    {
        $this->app = $this->request->getAttribute(static::REQ_ATTR_APP);
        if (!$this->app instanceof App) {
            throw new \Exception(__METHOD__ . '/' . __LINE__);
        }

        return $this->run();
    }

    /**
     * run this action and return the response
     *
     * @return ResponseInterface
     */
    abstract protected function run();

    protected function renderView(IView $view, array $data = [])
    {
        return $view->render($data, $this->response);
    }
}
