<?php


namespace Despark\Cms\Http\Controllers\Admin\Image;


use Despark\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{

    public function upload(Request $request)
    {
        dd($request->files);
    }

}