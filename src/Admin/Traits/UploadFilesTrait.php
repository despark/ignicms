<?php

namespace Despark\Cms\Admin\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;
use Illuminate\Support\Facades\Request;

trait UploadFilesTrait
{
    public $uploadDir = 'uploads';

    public function save(array $options = [])
    {
        $fileFields = $this->getFileFields();

        $currentUploadDir = $this->getCurrentUploadDir();

        foreach ($fileFields as $fieldName => $options) {
            if (array_get($this->attributes, $fieldName) instanceof UploadedFile) {
                $file = Request::file($fieldName);
                $filename = $file->getClientOriginalName();

                $file->move($this->getSavePath($options['dirName']), $filename);

                $this->attributes[$fieldName] = $this->getSavePath($options['dirName']).$filename;
            }
        }

        return parent::save($options);
    }

    public function getCurrentUploadDir()
    {
        $modelDir = explode('Models', get_class($this));
        $modelDir = str_replace('\\', '_', $modelDir[1]);
        $modelDir = ltrim($modelDir, '_');
        $modelDir = strtolower($modelDir);

        $modelDir = $this->uploadDir.DIRECTORY_SEPARATOR.$modelDir;

        return $modelDir;
    }

    public function getSavePath($dirName)
    {
        return $this->getCurrentUploadDir().DIRECTORY_SEPARATOR.$dirName.DIRECTORY_SEPARATOR;
    }
}
