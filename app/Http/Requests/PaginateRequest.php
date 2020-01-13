<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PaginateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function toArray(): array
    {
        return [
            'page' => $this->get('page') ? (int) $this->get('page') : null,
            'per_page' => $this->get('per_page') ? (int) $this->get('per_page') : null,
            'sort' => $this->get('sort'),
            'direction' => $this->get('direction'),
        ];
    }
}
