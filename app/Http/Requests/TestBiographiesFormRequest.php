<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TestBiographiesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'string|min:1|max:255|nullable',
            'age' => 'numeric|nullable',
            'biography' => 'string|min:1|nullable',
            'sport' => 'string|min:1|nullable',
            'gender' => 'string|min:1|nullable',
            'colors' => 'string|min:1|nullable',
            'is_retired' => 'boolean|nullable',
            'photo' => ['file','nullable'],
            'range' => 'string|min:1|nullable',
            'month' => 'string|min:1|nullable',
        ];

        return $rules;
    }
    
    /**
     * Get the request's data from the request.
     *
     * 
     * @return array
     */
    public function getData()
    {
        $data = $this->only(['name', 'age', 'biography', 'sport', 'gender', 'colors', 'is_retired', 'range', 'month']);
        if ($this->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($this->hasFile('photo')) {
            $data['photo'] = $this->moveFile($this->file('photo'));
        }

        $data['is_retired'] = $this->has('is_retired');


        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }
        
        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

}