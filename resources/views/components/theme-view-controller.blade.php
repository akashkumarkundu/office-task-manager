<div x-data="{
    mode: localStorage.getItem('office_tracker_screen_view') || 'desktop',
    updateMode(newMode) {
        this.mode = newMode;
        window.setScreenViewMode(newMode);
    },
    init() {
        if (!localStorage.getItem('office_tracker_screen_view')) {
            this.mode = 'desktop';
            window.setScreenViewMode('desktop');
        }
        window.addEventListener('viewmodechanged', (e) => {
            this.mode = e.detail.mode;
        });
    }
}" class="flex items-center gap-2">
    <!-- 1. Screen View Controller (Desktop & Mobile Segmented Switcher) -->
    <div class="inline-flex items-center p-1 rounded-xl bg-slate-200/90 dark:bg-zinc-800/90 border border-slate-300 dark:border-zinc-700/70 shadow-xs" title="Switch Screen View">
        <!-- Desktop Option -->
        <button 
            type="button" 
            x-on:click="updateMode('desktop')" 
            :class="mode === 'desktop' ? 'bg-white dark:bg-zinc-900 text-blue-600 dark:text-blue-400 shadow-sm font-bold' : 'text-slate-600 dark:text-zinc-400 hover:text-slate-950 dark:hover:text-white font-medium'" 
            class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs transition-all cursor-pointer">
            <flux:icon name="tv" class="size-3.5" />
            <span>Desktop</span>
        </button>

        <!-- Mobile Option -->
        <button 
            type="button" 
            x-on:click="updateMode('mobile')" 
            :class="mode === 'mobile' ? 'bg-white dark:bg-zinc-900 text-purple-600 dark:text-purple-400 shadow-sm font-bold' : 'text-slate-600 dark:text-zinc-400 hover:text-slate-950 dark:hover:text-white font-medium'" 
            class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs transition-all cursor-pointer">
            <flux:icon name="device-phone-mobile" class="size-3.5" />
            <span>Mobile</span>
        </button>
    </div>

    <!-- 2. Brightness & Dark Theme Switcher (Bright & Dark Segmented Switcher) -->
    <div class="inline-flex items-center p-1 rounded-xl bg-slate-200/90 dark:bg-zinc-800/90 border border-slate-300 dark:border-zinc-700/70 shadow-xs" title="Switch Brightness Theme">
        <!-- Bright / Light Option -->
        <button 
            type="button" 
            x-on:click="$flux.appearance = 'light'" 
            class="dark:text-zinc-400 dark:hover:text-white text-amber-700 font-bold bg-white dark:bg-transparent shadow-xs dark:shadow-none flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs transition-all cursor-pointer">
            <flux:icon name="sun" class="size-3.5 text-amber-500" />
            <span>Bright</span>
        </button>

        <!-- Dark Option -->
        <button 
            type="button" 
            x-on:click="$flux.appearance = 'dark'" 
            class="text-slate-600 hover:text-slate-950 dark:text-indigo-400 dark:font-bold dark:bg-zinc-900 dark:shadow-xs flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs transition-all cursor-pointer">
            <flux:icon name="moon" class="size-3.5 text-indigo-400" />
            <span>Dark</span>
        </button>
    </div>
</div>
