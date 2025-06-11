<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class BiographiesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow general access for now.
        // TODO: Implement specific authorization logic if needed later (e.g., based on user roles or permissions).
        return true;
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

        // Correctly handle boolean for is_retired
        if ($this->has('is_retired')) {
            $data['is_retired'] = filter_var($this->input('is_retired'), FILTER_VALIDATE_BOOLEAN);
        } else {
            // If 'is_retired' is not present at all, it might be treated as false or unchanged
            // depending on desired behaviour. For now, let's assume if not sent, it's false.
            // Or, remove it from $data if not present to leave it unchanged in DB on PATCH.
            // For a PUT/POST that expects all fields, providing a default is usually better.
            $data['is_retired'] = false;
        }


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