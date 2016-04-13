<?php 

namespace Tysdever\EloquentAttachment\Facades;


use Illuminate\Support\Facades\Facade;

class AttachmentFactory extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'attachment-factory';
    }
}
