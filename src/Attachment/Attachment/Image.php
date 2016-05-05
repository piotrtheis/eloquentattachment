<?php

namespace Tysdever\EloquentAttachment\Attachment;

use Intervention\Image\ImageManagerStatic as ImageManager;
use Tysdever\EloquentAttachment\Attachment;
use Tysdever\EloquentAttachment\Filesystem\UploadedFile;

class Image extends Attachment
{

    public $image;

    public function __construct(UploadedFile $file)
    {
        parent::__construct($file);

        $this->image = ImageManager::make($this->uploadedFile->getPathname());

    }

    public function __call($name, $arguments)
    {
    	dump($arguments);

    	if((bool)$arguments)
    	{

    	}
    	dd($name);	
    }
    

    public function get($style)
    {
    	return $this->url($this->image->dirname . '/' . 'smal_' . $this->image->basename);
    }
    

    public function afterSave()
    {
    	$savePath = $this->image->dirname . '/' . 'smal_' . $this->image->basename;

        $this->image->resize(100, 100)->save($savePath);
        
    }

    public function beforeDelete()
    {

    }

    protected function thumbnalis()
    {

    }

    protected function transformations()
    {

    }

}
