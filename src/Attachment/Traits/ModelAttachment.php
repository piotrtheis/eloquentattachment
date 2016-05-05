<?php

namespace Tysdever\EloquentAttachment\Traits;

use AttachmentFactory;
use EloquentAttachment;

trait ModelAttachment
{

 	 /**
     * The "booting" method of the model.
     */
    public static function boot()
    {
        parent::boot();

        static::bootAttachment();
    }


    public static function bootAttachment()
    {
        static::saved(function ($instance) {
            foreach ($instance->attachedFiles as $attachedFile) {
                AttachmentFactory::factory($instance->getAttributeValue($attachedFile))->afterSave();
            }
        });

        static::deleting(function ($instance) {
            foreach ($instance->attachedFiles as $attachedFile) {
                AttachmentFactory::factory($instance->getAttributeValue($attachedFile))->beforeDelete();
            }
        });

    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {



    	$tempPath = EloquentAttachment::getUrlPath();
    	$fileSuffix = EloquentAttachment::getUpdatedFileSuffix();

        foreach ($this->attachedFiles as $file) {
            if (array_key_exists($file . $fileSuffix, $attributes)) {
                $attributes[$file] =  ltrim($tempPath . str_replace($tempPath, '', $attributes[$file . $fileSuffix]), '/');
            }
        }

        parent::fill($attributes);


        return $this;
    }

    /**
     * Handle the dynamic retrieval of attachment objects.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {

        if (in_array($key, $this->attachedFiles)) {
            return AttachmentFactory::factory($this->getAttributeValue($key));
        }

        return parent::getAttribute($key);
    }
}
