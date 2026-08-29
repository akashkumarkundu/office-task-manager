<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Office Application Name
    |--------------------------------------------------------------------------
    |
    | Used in the navigation header, browser title, and welcome banner.
    |
    */
    'office_app_name' => env('OFFICE_APP_NAME', 'ASTGD Task Tracker'),

    /*
    |--------------------------------------------------------------------------
    | Company / Organization Name
    |--------------------------------------------------------------------------
    |
    | Displayed in the dashboard hero, workspace badge, and footer copyright.
    |
    */
    'company_name' => env('COMPANY_NAME', 'ASTGD'),

    /*
    |--------------------------------------------------------------------------
    | Company Contact Email
    |--------------------------------------------------------------------------
    |
    | Displayed in footer, contact links, and about sections.
    |
    */
    'company_email' => env('COMPANY_EMAIL', 'info@astgd.com'),

    /*
    |--------------------------------------------------------------------------
    | Tasks Pagination Limit
    |--------------------------------------------------------------------------
    |
    | Controls how many tasks are fetched and displayed per page in TaskController.
    |
    */
    'tasks_per_page' => (int) env('TASKS_PER_PAGE', 10),

    /*
    |--------------------------------------------------------------------------
    | Enable Task CSV Export
    |--------------------------------------------------------------------------
    |
    | Determines whether CSV export functionality is available and rendered.
    |
    */
    'enable_task_export' => filter_var(env('ENABLE_TASK_EXPORT', true), FILTER_VALIDATE_BOOLEAN),

];
