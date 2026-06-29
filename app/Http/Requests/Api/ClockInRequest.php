<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ClockInRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'work_center_code' => $this->has('work_center_code') && $this->work_center_code !== null ? (string) $this->work_center_code : null,
            'user_code' => $this->has('user_code') && $this->user_code !== null ? (string) $this->user_code : null,
            'manual_work_center_code' => $this->has('manual_work_center_code') && $this->manual_work_center_code !== null ? (string) $this->manual_work_center_code : null,
        ]);
    }

    public function rules()
    {
        return [
            'work_center_code' => 'sometimes|string|max:50',
            'manual_work_center_code' => 'sometimes|string|max:50',
            // Con auth:sanctum, el servidor identifica al usuario por el token.
            // user_code puede llegar desde clientes legacy como comprobación adicional.
            'user_code' => 'sometimes|string|max:50',
            'action' => 'sometimes|string|in:clock_in,clock_out,start,stop,pause,resume_workday,confirm_exceptional_clock_in,exceptional_clock_in',
            'pause_event_id' => 'sometimes|integer',
            'location' => 'sometimes|array',
            'location.latitude' => 'sometimes|numeric|between:-90,90',
            'location.longitude' => 'sometimes|numeric|between:-180,180',
            'observations' => 'sometimes|string|max:255',
        ];
    }
}
