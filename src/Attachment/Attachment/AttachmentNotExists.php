<?php

namespace Tysdever\EloquentAttachment\Attachment;


class AttachmentNotExists 
{

    public function __call($name, $arguments)
    {
    	return null;
    }
    

    public function __toString()
    {
    	return '';
    }

}
