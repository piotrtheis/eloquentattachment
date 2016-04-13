<?php

namespace Tysdever\EloquentAttachment\Filesystem;

use Illuminate\Http\UploadedFile as BaseUploadedFile;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Tysdever\EloquentAttachment\Exceptions\ConfigurationMismatchException;
use Tysdever\EloquentAttachment\Exceptions\SecurityVulnerabilitiesException;

class UploadedFile extends BaseUploadedFile
{

    /**
     * File validator
     * @var Validator
     */
    protected $validator;

    // public function __construct($path, $originalName = null, $mimeType = null, $size = null, $error = null, $test = false)
    // {
    // 	return parent::__construct($path, null);
    // }

    /**
     * Moves the file to a new location.
     *
     * @param string $directory The destination folder
     * @param string $name      The new file name
     *
     * @return File A File object representing the new file
     *
     * @throws FileException if, for any reason, the file could not have been moved
     * @throws FileException if file is executable
     * @throws SecurityVulnerabilitiesException if php.ini open_basedir is empty
     * @throws ConfigurationMismatchException if sys temp dir is not in open_basedir
     */
    public function move($directory, $name = null)
    {
        if ($this->isExecutable()) {
            throw new FileException('Illegal file type');
        }

        if (ini_get('open_basedir') == "") {
            throw new SecurityVulnerabilitiesException("Reconfigure php.ini open_basedir value, limit the files that can be opened by PHP!!!");
        } else {
            if (!(bool) strstr(ini_get('open_basedir'), sys_get_temp_dir())) {
                throw new ConfigurationMismatchException("Reconfigure php.ini open_basedir value, add tmp dir as allowed");
            }
        }

        return parent::move($directory, $name);
    }

    public function getValidator()
    {
        return $this->validator;
    }

    protected function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

}

//     //wykrywanie ../ albo ..\ see http://www.sans.org/reading-room/whitepapers/logging/detecting-attacks-web-applications-log-files-2074
//     // /(\.|(%|%25)2E)(\.|(%|%25)2E)(\/|(%|%25)2F|\\|(%|%25)5C)/g
//     // chown -R apache:apache /var/www/html/
//     // chmod -R 0444 /var/www/html/ read only
//     // open_basedir
//     // AddType application/x-httpd-php .jpg
//     Strict-Transport-Security, X-Content-Type-Options, X-Frame-Options, X-XSS-Protection, Content-Security-Policy.)

//     //$blacklist = array(".php","html","shtml",".phtml", ".php3", ".php4");
//     //to upper
//     ////to loweer
//     // && case insensitive rex
//     # Block double extensions from being uploaded or accessed, including htshells
// <FilesMatch ".*\.([^.]+)\.([^.]+)$">
// Order Deny,Allow
// Deny from all
// </FilesMatch>
// assign 770 permission.
