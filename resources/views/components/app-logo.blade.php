@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('tracker.office_app_name', config('app.name'))" {{ $attributes }}>
        <x-slot name="logo" class="flex items-center justify-center rounded-xl bg-white p-1 shadow-xs border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <img src="{{ asset('images/astgd-logo.png') }}" alt="ASTGD Logo" class="h-6 w-auto object-contain" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('tracker.office_app_name', config('app.name'))" {{ $attributes }}>
        <x-slot name="logo" class="flex items-center justify-center rounded-xl bg-white p-1 shadow-xs border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <img src="{{ asset('images/astgd-logo.png') }}" alt="ASTGD Logo" class="h-6 w-auto object-contain" />
        </x-slot>
    </flux:brand>
@endif
