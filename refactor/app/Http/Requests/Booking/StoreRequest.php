<?php

namespace App\Http\Requests\Booking;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use App\DTOs\BookingController\StoreRequestDTO;

class StoreRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'from_language_id'       => ['required', 'integer'],
            'immediate'              => ['required', 'string', Rule::in(['yes','no'])],
            'due_date'               => ['required', 'string'],
            'due_time'               => ['required', 'string'],
            'customer_phone_type'    => ['required', 'string', Rule::in(['yes','no'])],
            'duration'               => ['required', 'string'],
            'customer_physical_type' => ['required', 'string', Rule::in(['yes','no'])],
            'job_for'                => ['required', 'array', Rule::in(['male','female', 'normal', 'certified', 'certified_in_law', 'certified_in_helth'])],
            'by_admin'               => ['required', 'string']
        ];
    }

    /**
     * @return StoreRequestDTO
     */
    public function getDTO(): StoreRequestDTO
    {
        $validated = $this->validated();
        return new StoreRequestDTO($validated);
    }
}