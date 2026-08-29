<div x-data="{
    theme: localStorage.getItem('office_tracker_theme') || 'system',
    viewMode: localStorage.getItem('office_tracker_view_mode') || 'desktop',
    init() {
        this.applyTheme(this.theme);
        this.applyViewMode(this.viewMode);
    },
    setTheme(newTheme) {
        this.theme = newTheme;
        localStorage.setItem('office_tracker_theme', newTheme);
        this.applyTheme(newTheme);
    },
    applyTheme(t) {
        if (t === 'dark') {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else if (t === 'light') {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
        }
    },
    setViewMode(mode) {
        this.viewMode = mode;
        localStorage.setItem('office_tracker_view_mode', mode);
        this.applyViewMode(mode);
    },
    applyViewMode(mode) {
        const container = document.querySelector('main');
        if (!container) return;
        if (mode === 'mobile') {
            container.classList.add('max-w-md', 'mx-auto', 'px-2', 'transition-all', 'duration-300');
            container.classList.remove('max-w-7xl');
        } else {
            container.classList.remove('max-w-md', 'mx-auto');
            container.classList.add('transition-all', 'duration-300');
        }
    }
}" class="flex items-center gap-2">
    <!-- Theme & Brightness Dropdown -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">
            <template x-if="theme === 'light'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="sun" class="size-4 text-amber-500" />
                    <span class="hidden sm:inline">Bright</span>
                </span>
            </template>
            <template x-if="theme === 'dark'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="moon" class="size-4 text-indigo-400" />
                    <span class="hidden sm:inline">Dark</span>
                </span>
            </template>
            <template x-if="theme === 'system'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="computer-desktop" class="size-4 text-zinc-400" />
                    <span class="hidden sm:inline">Auto</span>
                </span>
            </template>
            <flux:icon name="chevron-down" class="size-3 text-zinc-400" />
        </flux:button>

        <flux:menu class="w-44">
            <flux:menu.heading>Theme & Brightness</flux:menu.heading>
            
            <flux:menu.item @click="setTheme('light')" icon="sun" class="cursor-pointer">
                <span>Light / Bright</span>
            </flux:menu.item>
            
            <flux:menu.item @click="setTheme('dark')" icon="moon" class="cursor-pointer">
                <span>Dark Mode</span>
            </flux:menu.item>
            
            <flux:menu.item @click="setTheme('system')" icon="computer-desktop" class="cursor-pointer">
                <span>System / Auto</span>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>

    <!-- Display View Mode (Desktop vs Mobile layout) -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">
            <template x-if="viewMode === 'desktop'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="tv" class="size-4 text-sky-500" />
                    <span class="hidden sm:inline">Desktop</span>
                </span>
            </template>
            <template x-if="viewMode === 'mobile'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="device-phone-mobile" class="size-4 text-violet-500" />
                    <span class="hidden sm:inline">Mobile</span>
                </span>
            </template>
            <flux:icon name="chevron-down" class="size-3 text-zinc-400" />
        </flux:button>

        <flux:menu class="w-48">
            <flux:menu.heading>Display Layout</flux:menu.heading>
            
            <flux:menu.item @click="setViewMode('desktop')" icon="tv" class="cursor-pointer">
                <span>Desktop Mode (Wide)</span>
            </flux:menu.item>
            
            <flux:menu.item @click="setViewMode('mobile')" icon="device-phone-mobile" class="cursor-pointer">
                <span>Mobile Mode (Compact)</span>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>
