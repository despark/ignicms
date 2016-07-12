<?php

namespace Despark\Cms\Admin\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;
use Illuminate\Support\Facades\Request;

trait UploadFilesTrait
{
    public $uploadFileDir = 'uploads';

    public function saveFiles(array $options = [])
    {
        $fileFields = $this->getFileFields();

        $currentUploadDir = $this->getFileCurrentUploadDir();

        foreach ($fileFields as $fieldName => $options) {
            $file = Request::file($fieldName);
            if ($file instanceof UploadedFile) {
                $filename = $file->getClientOriginalName();

                $file->move($this->getFileSavePath($options['dirName']), $filename);

                $this->attributes[$fieldName] = $this->getFileSavePath($options['dirName']).$filename;
            }
        }

        return parent::save($options);
    }

    public function getFileCurrentUploadDir()
    {
        $modelDir = explode('Models', get_class($this));
        $modelDir = str_replace('\\', '_', $modelDir[1]);
        $modelDir = ltrim($modelDir, '_');
        $modelDir = strtolower($modelDir);

        $modelDir = $this->uploadDir.DIRECTORY_SEPARATOR.$modelDir;

        return $modelDir;
    }

    public function getFileSavePath($dirName)
    {
        return $this->getFileCurrentUploadDir().DIRECTORY_SEPARATOR.$dirName.DIRECTORY_SEPARATOR;
    }
}
