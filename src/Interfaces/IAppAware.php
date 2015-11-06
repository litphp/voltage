<?php namespace Lit\Core\Interfaces;

use Lit\Core\App;

interface IAppAware
{
    public function setApp(App $app);
}