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
        $mergeData = [];
        if ($this->has('work_center_code') && $this->work_center_code !== null) {
            $mergeData['work_center_code'] = (string) $this->work_center_code;
        }
        if ($this->has('user_code') && $this->user_code !== null) {
            $mergeData['user_code'] = (string) $this->user_code;
        }
        if ($this->has('manual_work_center_code') && $this->manual_work_center_code !== null) {
            $mergeData['manual_work_center_code'] = (string) $this->manual_work_center_code;
        }
        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
    }

    public function rules()
    {
        return [
            'work_center_code' => 'sometimes|nullable|string|max:50',
            'manual_work_center_code' => 'sometimes|nullable|string|max:50',
            // Con auth:sanctum, el servidor identifica al usuario por el token.
            // user_code puede llegar desde clientes legacy como comprobación adicional.
            'user_code' => 'sometimes|nullable|string|max:50',
            'action' => 'sometimes|string|in:clock_in,clock_out,start,stop,pause,resume_workday,confirm_exceptional_clock_in,exceptional_clock_in',
            'pause_event_id' => 'sometimes|nullable|integer',
            'location' => 'sometimes|nullable|array',
            'location.latitude' => 'sometimes|nullable|numeric|between:-90,90',
            'location.longitude' => 'sometimes|nullable|numeric|between:-180,180',
            'observations' => 'sometimes|nullable|string|max:255',
        ];
    }
}
