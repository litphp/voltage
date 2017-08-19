<?php namespace Lit\Core;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MountedMiddleware extends AbstractMiddleware
{
    const ATTR_PREFIX = self::class;
    protected $autoSlash = true;
    /**
     * @var MiddlewareInterface
     */
    protected $middleware;
    /**
     * @var string
     */
    protected $prefix;

    public function __construct(MiddlewareInterface $middleware, $prefix)
    {
        if (empty($prefix)) {
            throw new \InvalidArgumentException;
        }
        $this->middleware = $middleware;
        $this->prefix = $prefix;
    }

    public static function getOriginPath(ServerRequestInterface $request)
    {
        return $request->getAttribute(static::ATTR_PREFIX . '.originPath');
    }

    /**
     * @param boolean $autoSlash
     * @return MountedMiddleware
     */
    public function setAutoSlash($autoSlash)
    {
        $this->autoSlash = $autoSlash;
        return $this;
    }

    protected function main():ResponseInterface
    {
        $uri = $this->request->getUri();
        $originPath = $uri->getPath();
        $prefixLen = strlen($this->prefix);
        if (substr($originPath, 0, $prefixLen) !== $this->prefix) {
            throw new \Exception(__METHOD__ . '/' . __LINE__);
        }

        $path = substr($originPath, $prefixLen) ?: '';
        if ($this->autoSlash) {
            $path = AbstractRouter::autoPrependSlash($path);
        }
        $uri = $uri->withPath($path);
        /**
         * @var ServerRequestInterface $request
         */
        $request = $this->request->withUri($uri);

        $key = static::ATTR_PREFIX . '.originPath';
        if (!$request->getAttribute($key)) {
            $request = $request->withAttribute($key, $originPath);
        }

        return $this->middleware->process($request, $this->delegate);
    }

}
