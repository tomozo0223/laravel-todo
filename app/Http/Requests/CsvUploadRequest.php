<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'csv_file' => 'required|mimetypes:text/plain,text/csv'
        ];
    }

    public function messages()
    {
        return [
            'csv_file.mimetypes' => 'csvファイルを選択してください。',
        ];
    }
}
