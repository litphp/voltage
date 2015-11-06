<?php namespace Lit\Core\Traits;

use Lit\Core\App;

trait AppAwareTrait
{
    /**
     * @var App
     */
    protected $app;

    public function setApp(App $app)
    {
        $this->app = $app;
    }
}