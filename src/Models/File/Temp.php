<?php

namespace Despark\Cms\Models\File;

use Despark\Cms\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Temp.
 */
class Temp extends Model
{
    /**
     * @var string
     */
    protected $table = 'temp_files';

    /**
     * @var array
     */
    protected $fillable = ['filename', 'temp_filename', 'file_type'];

    /**
     * @var File
     */
    protected $file;

    /**
     * @param $path
     * @param $filename
     * @return static
     */
    public static function createFromFile($path, $filename)
    {
        $model = new static;

        return $model->create([
            'filename' => $filename,
            'temp_filename' => \File::basename($path),
            'file_type' => \File::mimeType($path),
        ]);
    }

    /**
     * @return mixed|File
     * @throws FileNotFoundException
     */
    public function getFile()
    {
        if (! isset($this->file)) {
            $this->file = new File($this->getTempPath());
        }

        return $this->file;
    }

    /**
     * @return string
     */
    public function getTempPath()
    {
        return self::getTempDirectory().DIRECTORY_SEPARATOR.$this->temp_filename;
    }

    /**
     * @return mixed
     */
    public static function getTempDirectory()
    {
        return FileHelper::getTempDirectory();
    }
}
