<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'assigned_to' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'tags' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'in:Low,Medium,High,Urgent'],
            'status' => ['required', 'in:Pending,In Progress,Completed'],
            'due_date' => ['required', 'date'],
            'estimated_hours' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'spent_hours' => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'is_pinned' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'assigned_to.required' => 'Please select or enter the person responsible for this task.',
            'priority.required' => 'Priority is required.',
            'priority.in' => 'Priority must be Low, Medium, High, or Urgent.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be Pending, In Progress, or Completed.',
            'due_date.required' => 'Due date is required.',
            'due_date.date' => 'Please provide a valid due date.',
        ];
    }
}
