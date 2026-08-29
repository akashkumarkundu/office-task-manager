<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased flex flex-col transition-colors duration-300">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200/80 bg-white/90 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/90 shadow-xs">
            <flux:sidebar.header class="pb-2">
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav class="mt-4">
                <flux:sidebar.group :heading="__('Workspace')" class="grid gap-1">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate class="font-medium rounded-xl">
                        {{ __('Home') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="squares-2x2" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="font-medium rounded-xl">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="view-columns" :href="route('tasks.kanban')" :current="request()->routeIs('tasks.kanban')" wire:navigate class="font-medium rounded-xl">
                        {{ __('Kanban Board') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-list" :href="route('tasks.index')" :current="request()->routeIs('tasks.index') || request()->routeIs('tasks.show') || request()->routeIs('tasks.edit')" wire:navigate class="font-medium rounded-xl">
                        {{ __('Task Management') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <!-- Mode & Preferences Control Group in Sidebar -->
            <div class="px-3 py-3 border-t border-zinc-100 dark:border-zinc-800/80 rounded-2xl bg-zinc-50/50 dark:bg-zinc-800/40 mb-3">
                <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-400 mb-2 px-1">
                    Mode & Density
                </div>
                <x-theme-view-controller />
            </div>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Quick Links')" class="grid gap-1">
                    <flux:sidebar.item icon="plus-circle" :href="route('tasks.create')" :current="request()->routeIs('tasks.create')" wire:navigate class="text-indigo-600 dark:text-indigo-400 font-medium">
                        {{ __('New Task') }}
                    </flux:sidebar.item>
                    @if(config('tracker.enable_task_export'))
                        <flux:sidebar.item icon="arrow-down-tray" :href="route('tasks.export')" class="text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200">
                            {{ __('Export CSV') }}
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            @auth
                <x-desktop-user-menu class="hidden lg:block border-t border-zinc-100 dark:border-zinc-800 pt-3" :name="auth()->user()->name" />
            @else
                <div class="hidden lg:flex flex-col gap-2 border-t border-zinc-100 dark:border-zinc-800 pt-3">
                    <flux:button href="{{ route('login') }}" variant="subtle" size="sm" icon="arrow-right-end-on-rectangle" class="w-full justify-start">
                        {{ __('Sign In') }}
                    </flux:button>
                    @if (Route::has('register'))
                        <flux:button href="{{ route('register') }}" variant="primary" size="sm" icon="user-plus" class="w-full justify-start">
                            {{ __('Register') }}
                        </flux:button>
                    @endif
                </div>
            @endauth
        </flux:sidebar>

        <!-- Mobile & Top Header -->
        <flux:header class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 px-4 py-2">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="font-bold text-sm text-zinc-900 dark:text-zinc-100 ml-2 hidden sm:block">
                {{ config('tracker.office_app_name', 'Office Task Tracker') }}
            </div>

            <flux:spacer />

            <!-- Top Header Theme & View Controller -->
            <div class="flex items-center gap-3">
                <x-theme-view-controller />

                @auth
                    <flux:dropdown position="top" align="end">
                        <flux:profile
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevron-down"
                        />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <flux:avatar
                                            :name="auth()->user()->name"
                                            :initials="auth()->user()->initials()"
                                        />

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                            <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item
                                    as="button"
                                    type="submit"
                                    icon="arrow-right-start-on-rectangle"
                                    class="w-full cursor-pointer"
                                    data-test="logout-button"
                                >
                                    {{ __('Log out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                @else
                    <div class="flex items-center gap-2">
                        <flux:button href="{{ route('login') }}" size="xs" variant="ghost">Sign In</flux:button>
                        @if (Route::has('register'))
                            <flux:button href="{{ route('register') }}" size="xs" variant="primary">Register</flux:button>
                        @endif
                    </div>
                @endauth
            </div>
        </flux:header>

        <!-- Main Content Area -->
        <div class="flex-1">
            {{ $slot }}
        </div>

        <!-- Corporate Productivity Footer -->
        <footer class="mt-auto border-t border-zinc-200/80 bg-white/60 dark:bg-zinc-900/60 dark:border-zinc-800 py-4 px-6 text-center text-xs text-zinc-500 dark:text-zinc-400">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2 flex-wrap">
                    <span>&copy; {{ date('Y') }} <strong class="font-semibold text-zinc-700 dark:text-zinc-300">{{ config('tracker.company_name', 'ASTGD') }}</strong>. All rights reserved.</span>
                    <span>&bull;</span>
                    <a href="mailto:{{ config('tracker.company_email', 'info@astgd.com') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        {{ config('tracker.company_email', 'info@astgd.com') }}
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1">
                        <span class="size-2 rounded-full bg-emerald-500"></span>
                        <span>{{ config('tracker.office_app_name', 'ASTGD Task Tracker') }}</span>
                    </span>
                    @if(app()->environment('local'))
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-800/80 font-mono text-[10px] font-semibold">
                            Environment: Development
                        </span>
                    @endif
                </div>
            </div>
        </footer>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
