<?php 

namespace Tysdever\EloquentAttachment\Facades;


use Illuminate\Support\Facades\Facade;

class EloquentAttachment extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'eloquent-attachment';
    }
}
