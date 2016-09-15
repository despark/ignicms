<?php

namespace Despark\Cms\Http\Requests\Image;

use Despark\Cms\Http\Requests\File\FileUploadRequest;

class ImageUploadRequest extends FileUploadRequest
{
    public function rules()
    {
        $rules = parent::rules();

//        // We need to get the dimensions
//
//        $rules = array_merge($rules, [
//            'file' => 'required|image|',
//            'fieldName' => 'required',
//            'modelClass' => 'required',
//        ]);

        return $rules;
    }
}
