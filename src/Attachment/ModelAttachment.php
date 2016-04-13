<?php

namespace Tysdever\EloquentAttachment;

trait ModleAttachment
{

    protected $attchedFiles;


     /**
     * Add a new file attachment type to the list of available attachments.
     * This function acts as a quasi constructor for this trait.
     *
     * @param string $name
     * @param array  $options
     */
    public function attacheFile($name, array $options = [])
    {
        $attachment = AttachmentFactory::create($name, $options);
        $attachment->setInstance($this);
        $this->attachedFiles[$name] = $attachment;
    }

    


    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key)) {
            return $this->getAttributeValue($key);
        }

        return $this->getRelationValue($key);
    }

    public function save(array $options = [])
    {
        // before save code
        parent::save($options);

        dd(123);
        // after save code
    }



    /**
     * The "booting" method of the model.
     */
    public static function boot()
    {
        parent::boot();

        dd(new static);

        static::bootStapler();
    }

    /**
     * Register eloquent event handlers.
     * We'll spin through each of the attached files defined on this class
     * and register callbacks for the events we need to observe in order to
     * handle file uploads.
     */
    public static function bootStapler()
    {
        static::saved(function ($instance) {
            foreach ($instance->attachedFiles as $attachedFile) {

                $attachedFile->afterSave($instance);

            }
        });

        static::deleting(function ($instance) {
            foreach ($instance->attachedFiles as $attachedFile) {
                $attachedFile->beforeDelete($instance);
            }
        });

        static::deleted(function ($instance) {
            foreach ($instance->attachedFiles as $attachedFile) {
                $attachedFile->afterDelete($instance);
            }
        });
    }

}
