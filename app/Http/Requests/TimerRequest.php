<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimerRequest extends FormRequest
{

    public function rules()
    {

        return [
            'time_start' => 'required',
        ];
    }
}
