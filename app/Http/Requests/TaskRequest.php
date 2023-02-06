<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    /** @return array<string,array<int,mixed>> */
    public function rules(): array {
        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                Rule::enum(TaskStatus::class),
            ],
            'deadline_until' => [
                'required',
                'date'
            ],
            'categories' => [
                'nullable',
                'array',
            ],
        ];
    }
}
