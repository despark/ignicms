<?php


namespace Despark\Cms\Models\File;


use Despark\Cms\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class Temp
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

    protected $file;

    /**
     * @param UploadedFile $file
     * @param $filename
     * @return static
     */
    public static function createFromFile(File $file, $filename)
    {
        $model = new static;

        return $model->create([
            'filename' => $filename,
            'temp_filename' => $file->getFilename(),
            'file_type' => $file->getMimeType(),
        ]);
    }

    /**
     * @return mixed|File
     * @throws FileNotFoundException
     */
    public function getFile()
    {
        if (! isset($this->file)) {
            $this->file = new File(FileHelper::getTempDirectory().$this->temp_filename);
        }

        return $this->file;
    }

}