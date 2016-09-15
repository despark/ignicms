<?php

namespace Despark\Cms\Http\Controllers;

use Despark\Cms\Models\File\Temp;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * Class FileController.
 */
class FileController extends Controller
{
    /**
     * @param $fileId
     * @param Temp $temp
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function get($fileId, Temp $temp)
    {
        /** @var Temp $fileModel */
        $fileModel = $temp->findOrFail($fileId);

        try {
            $file = $fileModel->getFile();
        } catch (FileNotFoundException $exc) {
            abort(404);
        }

        return response()->download($file);
    }

    /**
     * @param $fileId
     * @param $fieldName
     * @param $modelClass
     */
    public function getFileFormHtml($fileId, $fieldName, $modelClass)
    {
    }
}
