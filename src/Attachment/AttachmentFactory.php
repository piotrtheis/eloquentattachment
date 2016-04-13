<?php

namespace Tysdever\EloquentAttachment;

use InvalidArgumentException;
use UnexpectedValueException;
use Tysdever\EloquentAttachment\MimeResolver;
use Tysdever\EloquentAttachment\EloquentAttachment;
use Tysdever\EloquentAttachment\Filesystem\UploadedFile;
use File;


class AttachmentFactory
{

    /**
     * Driver by mime resolver
     *
     * @var MimeResolver
     */
    protected $resolver;


    /**
     * Factory constructor
     * 
     * @param MimeResolver $resolver [description]
     */
    public function __construct(MimeResolver $resolver, EloquentAttachment $attachment)
    {
        $this->resolver = $resolver;
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
        try{
            $file = $this->buildFile($path);
        } catch (UnexpectedValueException $e){
            //avoid Call to a member function on null Error Exception
            $className = __NAMESPACE__ . '\Attachment\AttachmentNotExists';
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
    	 if (File::exists($path)) {
    	 	return new UploadedFile($path, '');
        }

        
    	throw new UnexpectedValueException("Fiel not found for path: $path");
    }
}
