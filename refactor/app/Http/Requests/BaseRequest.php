<?php

namespace App\Http\Requests;

use App\Filters\Filter;
use App\Filters\Lowercase;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    use Filter;

    /**
     * @var array $filter
     */
    private array $filter;

    /**
     * @return mixed
     */
    abstract public function getDTO();

    /**
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $requestData = array_merge($this->all(), $this->route()->parameters());

        $this->filterValues($requestData, [
            'username' => [new Lowercase()],
            'email'    => [new Lowercase()]
        ]);

        $this->merge($requestData);
    }
}
