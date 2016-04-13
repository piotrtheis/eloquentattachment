<?php

namespace Tysdever\EloquentAttachment;

use File;
use Tysdever\EloquentAttachment\Filesystem\UploadedFile;

class Attachment
{

	/**
	 * Media file
	 * @var UploadedFile
	 */
    protected $uploadedFile;


    /**
     * Attachment constructor.
     *
     * @param UploadedFile $file tmp file object
     */
    public function __construct(UploadedFile $file)
    {
        $this->uploadedFile = $file;
    }

    public function getSize()
    {
        return $this->uploadedFile->getSize();
    }

    public function getExtension()
    {
        return $this->uploadedFile->getExtension();
    }

    public function getMime()
    {
        return $this->uploadedFile->getMimeType();
    }

    public function __toString()
    {
        return $this->url($this->uploadedFile->getPathname());
    }

    protected function url($path)
    {
        return str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);

    }
}
