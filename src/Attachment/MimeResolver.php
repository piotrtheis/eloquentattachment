<?php

namespace Tysdever\EloquentAttachment;


use Illuminate\Http\UploadedFile;

class MimeResolver
{

    /**
     * Mapping MIME type to media name
     * @var array
     */
    protected $mimes = [
        'archive' => [
            'application/x-7z-compressed',
            'application/x-zip',
            'application/zip',
            'application/x-zip-compressed',
            'application/x-compress',
            'application/x-gtar',
            'application/x-gzip',
            'application/rar',
            'application/x-tar',
            'application/x-tar',
            'application/vnd.ms-cab-compressed',
        ],
        'doc'     => [
            'text/x-comma-separated-values',
            'application/vnd.ms-excel',
            'text/comma-separated-values',
            'text/csv',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/excel',
            'application/vnd.ms-excel',
            'application/excel',
            'application/vnd.ms-excel',
            'application/excel',
            'application/vnd.ms-excel',
            'application/excel',
            'application/vnd.ms-excel',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/excel',
            'application/vnd.ms-excel',
            'application/msword',
            'application/octet-stream',
            'application/vnd.ms-powerpoint',
            'application/vnd.ms-powerpoint',
            'application/powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.oasis.opendocument.text',
            'application/rtf',
            'application/vnd.oasis.opendocument.spreadsheet',
        ],
        'pdf'     => [
            'application/pdf',
            'application/x-download',
        ],
        'image'   => [
            'image/bmp',
            'image/gif',
            'image/x-icon',
            'image/vnd.microsoft.icon',
            'image/jpeg',
            'image/pjpeg',
            'image/jpeg',
            'image/pjpeg',
            'image/jpeg',
            'image/pjpeg',
            'image/x-portable-bitmap',
            'image/png', 'image/x-png',
            'image/x-rgb',
            'image/tiff',
            'image/tiff',
            'image/x-xwindowdump',
            'image/x-xpixmap',
            'image/x-xbitmap',
            'image/xcf',
        ],
        'audio'   => [
            'audio/x-aiff',
            'audio/x-aiff',
            'audio/x-aiff',
            'audio/mpeg',
            'audio/midi',
            'audio/midi',
            'audio/x-matroska',
            'audio/mpeg',
            'audio/mpeg',
            'application/mp4',
            'audio/mp4',
            'video/mp4',
            'audio/mpeg',
            'audio/ogg',
            'audio/x-realaudio',
            'audio/x-realaudio',
            'audio/x-pn-realaudio',
            'audio/x-pn-realaudio',
            'audio/x-pn-realaudio-plugin',
            'application/x-redhat-package-manager',
            'audio/x-wav',
            'audio/x-ms-wax',
            'audio/x-ms-wma',
        ],
        'video'   => [
            'video/x-ms-asf',
            'video/x-ms-asf',
            'video/x-ms-asf',
            'video/avi',
            'video/msvideo',
            'video/x-msvideo',
            'video/divx',
            'video/flc',
            'video/fli',
            'video/x-flv',
            'video/mp4v-es',
            'video/mp4',
            'application/mp4',
            'audio/mp4',
            'video/mp4',
            'video/x-matroska',
            'video/quicktime',
            'video/x-sgi-movie',
            'video/mpeg',
            'video/mpeg',
            'video/mpeg',
            'video/mpeg',
            'video/mp4',
            'video/x-matroska',
            'video/mpeg',
            'video/ogg',
            'video/quicktime',
            'video/vnd.rn-realvideo',
            'video/x-xvid',
            'video/x-ms-wm',
            'video/x-ms-wmv',
            'application/octet-stream',
            'video/x-ms-wmx',
            'video/x-ms-wvx',
        ],

    ];



    /**
     * Find file driver for attachment factory.
     * 
     * @param  UploadedFile $file
     * @throws InvalidFileMimeException 
     * @return string
     */
    public function getFileDriver(UploadedFile $file)
    {
    	//file mime
    	$mime = $file->getMimeType();
    	
    	foreach ($this->mimes as $driver => $mimes) {
            if(in_array($mime, $mimes))
            {
                return $driver;
            }
        }
    	
    	throw new InvalidFileMimeException("No attachment driver for given file", 409);
    }


}
