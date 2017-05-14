<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Lit\Core\Interfaces\IStubResolver;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractRouter implements IRouter
{
    protected $notFound;
    /**
     * @var IStubResolver
     */
    protected $stubResolver;

    /**
     * @param IStubResolver $stubResolver
     * @param mixed $notFound stub for notFoundMiddleware
     */
    public function __construct(IStubResolver $stubResolver, $notFound)
    {
        $this->notFound = $notFound;
        $this->stubResolver = $stubResolver;
    }

    public function route(ServerRequestInterface $request)
    {
        $stub = $this->findStub($request);

        return $stub ? $this->resolve($stub) : $this->resolve($this->notFound);
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    abstract protected function findStub(ServerRequestInterface $request);

    protected function resolve($stub)
    {
        return $this->stubResolver->resolve($stub);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function autoPrependSlash($path)
    {
        if ($path === '' || $path{0} !== '/') {
            return "/$path";
        } else {
            return $path;
        }
    }
}
