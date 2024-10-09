<?php

namespace Detit\Polipeople\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \detit\Polipeople\Polipeople
 */
class Polipeople extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Detit\Polipeople\Polipeople::class;
    }
}
