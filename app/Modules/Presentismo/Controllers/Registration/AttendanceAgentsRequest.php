<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Helpers\Calculation;
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
//            'shifts.*' => 'exists:turnos,id',
            'areas' => 'nullable|array',
//            'areas.*' => 'exists:areas,id',
            'roles' => 'nullable|array',
//            'roles.*' => 'exists:funciones,id',
        ];
    }

    public function dateFrom(): \DateTime
    {
        return new \DateTime($this->input('date_from'));
    }

    public function dateTo(): \DateTime
    {
        $dateFrom = $this->dateFrom();
        $dateTo = new \DateTime($this->input('date_to'));

        if ($dateFrom->diff($dateTo)->days > Calculation::MAX_DIFF_BETWEEN_DATES) {
            return (clone $dateFrom)->modify('+' . Calculation::MAX_DIFF_BETWEEN_DATES . ' days');
        }

        return $dateTo;
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
