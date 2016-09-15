<?php

namespace Despark\Cms\Http\Controllers\Admin;

use Despark\Cms\Helpers\FileHelper;
use Despark\Cms\Http\Controllers\Controller;
use Despark\Cms\Http\Requests\Image\ImageUploadRequest;
use Despark\Cms\Models\File\Temp;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * Class ImageUploadController.
 */
class ImageController extends Controller
{
    /**
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function upload(ImageUploadRequest $request, \Flow\File $file, \Flow\Request $flowRequest)
    {
        // We switch to flow.js
        if ($request->getMethod() === 'GET') {
            if (! $file->checkChunk()) {
                return \Response::make('', 204);
            }
        } else {
            if ($file->validateChunk()) {
                $file->saveChunk();
            } else {
                return \Response::make('', 400);
            }
        }

        $filename = FileHelper::generateUniqueName($flowRequest->getFileName());
        $destination = FileHelper::getTempDirectory().DIRECTORY_SEPARATOR.$filename;

        if ($file->validateFile() && $file->save($destination)) {
            $tempFile = Temp::createFromFile($destination, $flowRequest->getFileName());

            return new JsonResponse(['id' => $tempFile->getKey()]);
        }
    }

    /**
     * @param $id
     * @param Temp $tempModel
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function preview($id, Temp $tempModel)
    {
        try {
            /** @var Temp $tempImage */
            $tempImage = $tempModel->findOrFail($id);
        } catch (ModelNotFoundException $exc) {
            abort(404);
        }

        $image = \Image::make($tempImage->getTempPath());
        $width = config('ignicms.images.admin_thumb_width');
        $height = config('ignicms.images.admin_thumb_height');
        $image->fit($width, $height);

        return $image->response();
    }
}
