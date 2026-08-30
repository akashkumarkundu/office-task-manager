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
}" class="flex items-center gap-1.5 sm:gap-2">
    <!-- 1. Screen View Dropdown Menu -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/80 border border-slate-300/80 dark:border-zinc-700/60 bg-white/90 dark:bg-zinc-900/90 shadow-2xs cursor-pointer">
            <template x-if="mode === 'desktop'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="tv" class="size-3.5 text-blue-600 dark:text-blue-400" />
                    <span>View</span>
                </span>
            </template>
            <template x-if="mode === 'mobile'">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="device-phone-mobile" class="size-3.5 text-purple-600 dark:text-purple-400" />
                    <span>View</span>
                </span>
            </template>
            <template x-if="mode === 'auto' || !['desktop', 'mobile'].includes(mode)">
                <span class="flex items-center gap-1.5">
                    <flux:icon name="computer-desktop" class="size-3.5 text-blue-600 dark:text-blue-400" />
                    <span>View</span>
                </span>
            </template>
            <flux:icon name="chevron-down" class="size-3 text-slate-400 dark:text-zinc-500" />
        </flux:button>

        <flux:menu class="w-48">
            <flux:menu.heading>Screen View</flux:menu.heading>
            
            <flux:menu.item x-on:click="updateMode('desktop')" icon="tv" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>Desktop View</span>
                    <span x-show="mode === 'desktop'" class="text-blue-600 dark:text-blue-400 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>

            <flux:menu.item x-on:click="updateMode('mobile')" icon="device-phone-mobile" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>Mobile View</span>
                    <span x-show="mode === 'mobile'" class="text-purple-600 dark:text-purple-400 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>

            <flux:menu.item x-on:click="updateMode('auto')" icon="arrows-pointing-out" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>Auto (Responsive)</span>
                    <span x-show="mode === 'auto'" class="text-emerald-600 dark:text-emerald-400 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>

    <!-- 2. Theme Mode Dropdown Menu -->
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" size="sm" class="rounded-xl flex items-center gap-1.5 text-xs font-semibold text-slate-700 dark:text-zinc-300 hover:bg-slate-100 dark:hover:bg-zinc-800/80 border border-slate-300/80 dark:border-zinc-700/60 bg-white/90 dark:bg-zinc-900/90 shadow-2xs cursor-pointer">
            <span class="dark:hidden flex items-center gap-1.5">
                <flux:icon name="sun" class="size-3.5 text-amber-500" />
                <span>Theme</span>
            </span>
            <span class="hidden dark:flex items-center gap-1.5">
                <flux:icon name="moon" class="size-3.5 text-indigo-400" />
                <span>Theme</span>
            </span>
            <flux:icon name="chevron-down" class="size-3 text-slate-400 dark:text-zinc-500" />
        </flux:button>

        <flux:menu class="w-44">
            <flux:menu.heading>Appearance Theme</flux:menu.heading>
            
            <flux:menu.item x-on:click="$flux.appearance = 'light'" icon="sun" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>Bright Mode</span>
                    <span x-show="$flux.appearance === 'light'" class="text-amber-500 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>

            <flux:menu.item x-on:click="$flux.appearance = 'dark'" icon="moon" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>Dark Mode</span>
                    <span x-show="$flux.appearance === 'dark'" class="text-indigo-400 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>

            <flux:menu.item x-on:click="$flux.appearance = 'system'" icon="computer-desktop" class="cursor-pointer">
                <div class="flex items-center justify-between w-full">
                    <span>System Auto</span>
                    <span x-show="$flux.appearance === 'system'" class="text-emerald-500 font-bold text-xs">✓</span>
                </div>
            </flux:menu.item>
        </flux:menu>
    </flux:dropdown>
</div>
