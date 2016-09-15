<?php

namespace Despark\Cms\Helpers;

/**
 * Class FileHelper.
 */
/**
 * Class FileHelper.
 */
class FileHelper
{
    /**
     * @param $filename
     * @return string
     */
    public static function sanitizeFilename($filename)
    {
        $pathParts = pathinfo($filename);

        return str_slug($pathParts['filename']).'.'.filter_var(strtolower($pathParts['extension']));
    }

    /**
     * @param $filename
     * @return string
     */
    public static function generateUniqueName($filename)
    {
        $pathParts = pathinfo($filename);
        $filename = $pathParts['filename'].uniqid('-').'.'.$pathParts['extension'];

        return self::sanitizeFilename($filename);
    }

    /**
     * @return mixed
     */
    public static function getTempDirectory()
    {
        $dir = storage_path(config('ignicms.files.temporary_directory', 'upload_temp'));
        if (! is_dir($dir)) {
            \File::makeDirectory($dir);
        }

        return $dir;
    }
}
