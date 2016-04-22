<?php

namespace Tysdever\EloquentAttachment;

use File;
use InvalidArgumentException;
use Tysdever\EloquentAttachment\EloquentAttachment;
use Tysdever\EloquentAttachment\Filesystem\UploadedFile;
use Tysdever\EloquentAttachment\MimeResolver;
use UnexpectedValueException;

class AttachmentFactory
{

    /**
     * Driver by mime resolver
     *
     * @var MimeResolver
     */
    protected $resolver;

    /**
     * ELoquent attachment object
     * 
     * @var EloquentAttachment
     */
    protected $attachment;

    /**
     * Factory constructor
     *
     * @param MimeResolver $resolver [description]
     */
    public function __construct(MimeResolver $resolver, EloquentAttachment $attachment)
    {
        $this->resolver = $resolver;

        $this->attachment = $attachment;
    }

    /**
     * Attachment file factory.
     *
     * @param string $path tmp file path
     * @throws InvalidArgumentException
     * @return Attachment
     */
    public function factory($path)
    {
        try {
            $file = $this->buildFile($path);
        } catch (UnexpectedValueException $e) {
            //avoid Call to a member function on null Error Exception
            $className = __NAMESPACE__ . '\Attachment\AttachmentNotExists';

            //return empty attachment
            return new $className();
        }

        $driver = $this->resolver->getFileDriver($file);

        $className = __NAMESPACE__ . '\Attachment\\' . ucfirst($driver);

        if (class_exists($className)) {
            return new $className($file);
        }

        throw new InvalidArgumentException('Missing attachment class.');
    }

    /**
     * Build file object from tmp file
     *
     * @param  string $path
     * @throws Exception
     * @return UploadedFile
     */
    protected function buildFile($path)
    {
        //all possible places
        // $paths = [
        //     $path,
        //     ltrim($this->attachment->getUrlPath() . $path, '/'),
        //     $this->attachment->getUrlPath() . $path,
        //     ltrim($this->attachment->getTempPath() . $path),
        //     $this->attachment->getTempPath() . $path
        // ];


        //find file
       // foreach($paths as $path){
            if (File::exists($path)) {
                return new UploadedFile($path, '');
            }    
      //  }
         

        throw new UnexpectedValueException("Fiel not found for path: $path");
    }
}
