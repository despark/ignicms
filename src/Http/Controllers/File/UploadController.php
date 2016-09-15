<?php

namespace Despark\Cms\Http\Controllers\File;

use Despark\Cms\Http\Controllers\Controller;
use Despark\Cms\Http\Requests\File\FileUploadRequest;

class UploadController extends Controller
{
    public function upload(FileUploadRequest $request)
    {
        // We need to save the file as a temp file.
    }
}
