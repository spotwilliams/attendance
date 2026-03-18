<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceAgentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string|array<string>>
     */
    public function rules(): array
    {
        return [
            'base_id' => 'required|exists:bases,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'shifts' => 'nullable|array',
            'areas' => 'nullable|array',
            'roles' => 'nullable|array',
        ];
    }

    public function dateFrom(): \DateTime
    {
        return new \DateTime($this->input('date_from'));
    }

    public function dateTo(): \DateTime
    {
        return new \DateTime($this->input('date_to'));
    }

    /**
     * @return array<int>
     */
    public function shiftIds(): array
    {
        return $this->input('shifts', []);
    }

    /**
     * @return array<int>
     */
    public function areaIds(): array
    {
        return $this->input('areas', []);
    }

    /**
     * @return array<int>
     */
    public function roleIds(): array
    {
        return $this->input('roles', []);
    }
}
