<div x-data="{
    mode: localStorage.getItem('office_tracker_screen_view') || 'auto',
    updateMode(newMode) {
        this.mode = newMode;
        window.setScreenViewMode(newMode);
    },
    init() {
        window.addEventListener('viewmodechanged', (e) => {
            this.mode = e.detail.mode;
        });
    }
}" class="flex items-center gap-1.5">
    <!-- 1. Theme / Brightness Controller -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1 text-xs text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">
            <span class="dark:hidden flex items-center gap-1">
                <flux:icon name="sun" class="size-4 text-amber-500" />
                <span class="hidden sm:inline font-medium">Bright</span>
            </span>
            <span class="hidden dark:flex items-center gap-1">
                <flux:icon name="moon" class="size-4 text-indigo-400" />
                <span class="hidden sm:inline font-medium">Dark</span>
            </span>
            <flux:icon name="chevron-down" class="size-3 text-zinc-400" />
        </flux:button>

        <flux:menu class="w-40">
            <flux:menu.heading>Theme Mode</flux:menu.heading>
            
            <flux:menu.item x-on:click="$flux.appearance = 'light'" icon="sun" class="cursor-pointer">
                <span>Light / Bright</span>
            </flux:menu.item>
            
            <flux:menu.item x-on:click="$flux.appearance = 'dark'" icon="moon" class="cursor-pointer">
                <span>Dark Mode</span>
            </flux:menu.item>
            
            <flux:menu.item x-on:click="$flux.appearance = 'system'" icon="computer-desktop" class="cursor-pointer">
                <span>System Auto</span>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>

    <!-- 2. Screen View Mode Dropdown -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1 text-xs text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800">
            <template x-if="mode === 'auto'">
                <span class="flex items-center gap-1">
                    <flux:icon name="arrows-pointing-out" class="size-4 text-emerald-500" />
                    <span class="hidden sm:inline font-medium">Auto View</span>
                </span>
            </template>
            <template x-if="mode === 'desktop'">
                <span class="flex items-center gap-1">
                    <flux:icon name="tv" class="size-4 text-sky-500" />
                    <span class="hidden sm:inline font-medium">Desktop</span>
                </span>
            </template>
            <template x-if="mode === 'mobile'">
                <span class="flex items-center gap-1">
                    <flux:icon name="device-phone-mobile" class="size-4 text-violet-500" />
                    <span class="hidden sm:inline font-medium">Mobile</span>
                </span>
            </template>
            <flux:icon name="chevron-down" class="size-3 text-zinc-400" />
        </flux:button>

        <flux:menu class="w-48">
            <flux:menu.heading>Screen View Mode</flux:menu.heading>
            
            <flux:menu.item x-on:click="updateMode('auto')" icon="arrows-pointing-out" class="cursor-pointer">
                <span>Auto (Responsive)</span>
            </flux:menu.item>
            
            <flux:menu.item x-on:click="updateMode('desktop')" icon="tv" class="cursor-pointer">
                <span>Desktop (Full Width)</span>
            </flux:menu.item>
            
            <flux:menu.item x-on:click="updateMode('mobile')" icon="device-phone-mobile" class="cursor-pointer">
                <span>Mobile (Phone Frame)</span>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>
