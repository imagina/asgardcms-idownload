<?php

namespace Modules\Idownload\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSuscriptorRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'g-recaptcha-response' => 'required|captcha',
          'full_name' => 'required',
          'email' => 'required|email',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
