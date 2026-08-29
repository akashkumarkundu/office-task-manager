<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Office Task Tracker Custom Configuration
    |--------------------------------------------------------------------------
    |
    | All custom environment variables are mapped here to adhere to Laravel's
    | best practice of never calling env() directly inside application views
    | or controllers, ensuring complete config caching support.
    |
    */

    'app_name' => env('OFFICE_APP_NAME', 'Office Task Tracker'),

    'company_name' => env('COMPANY_NAME', 'Zenith Core Ltd.'),

    'company_email' => env('COMPANY_EMAIL', 'support@zenithcore.com'),

    'tasks_per_page' => (int) env('TASKS_PER_PAGE', 10),

    'enable_task_export' => (bool) env('ENABLE_TASK_EXPORT', true),
];
