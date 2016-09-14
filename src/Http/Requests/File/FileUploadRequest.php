<?php


namespace Despark\Cms\Http\Requests\File;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class FileUploadRequest
 */
class FileUploadRequest extends FormRequest
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file',
        ];
    }

    /**
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        $messages = [];
        foreach ($errors as $error) {
            $messages[] = implode(PHP_EOL, $error);
        }

        return new JsonResponse($messages, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}