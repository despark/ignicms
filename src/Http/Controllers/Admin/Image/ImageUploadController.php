<?php


namespace Despark\Cms\Http\Controllers\Admin\Image;


use Despark\Cms\Helpers\FileHelper;
use Despark\Cms\Http\Controllers\Controller;
use Despark\Cms\Http\Requests\Image\ImageUploadRequest;
use Despark\Cms\Models\File\Temp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ImageUploadController
 */
class ImageUploadController extends Controller
{

    /**
     * @param ImageUploadRequest $request
     * @return JsonResponse
     */
    public function upload(ImageUploadRequest $request)
    {
        // We need to move the image.
        $file = $request->file('file');

        // Sanitize filename
        $filename = FileHelper::sanitizeFilename($file->getClientOriginalName());

        $tmpDir = FileHelper::getTempDirectory();

        if (! is_dir($tmpDir)) {
            \File::makeDirectory($tmpDir);
        }

        // We save it with a temp name and we will rename it on move.
        try {
            $file = $file->move($tmpDir, FileHelper::generateUniqueName($filename));
        } catch (\Exception $exc) {
            return new JsonResponse(['Cannot save the file.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tempFile = Temp::createFromFile($file, $filename);

        return new JsonResponse(['id' => $tempFile->getKey()]);
    }

}