<footer class="border-t border-zinc-200/80 dark:border-zinc-800 py-6 text-center text-xs text-zinc-500 dark:text-zinc-400 mt-16">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="flex items-center gap-2 flex-wrap justify-center sm:justify-start">
            <span>&copy; {{ date('Y') }} <strong class="font-semibold text-zinc-700 dark:text-zinc-300">{{ config('tracker.company_name', 'ASTGD') }}</strong>. All rights reserved.</span>
            <span>&bull;</span>
            <a href="mailto:{{ config('tracker.company_email', 'office@example.com') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                {{ config('tracker.company_email', 'office@example.com') }}
            </a>
        </div>
        <div class="flex items-center gap-3 justify-center sm:justify-end">
            <span class="inline-flex items-center gap-1.5">
                <span class="size-2 rounded-full bg-emerald-500"></span>
                <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ config('tracker.office_app_name', 'ASTGD Task Tracker') }}</span>
            </span>
            @if(app()->environment('local'))
                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-800/80 font-mono text-[10px] font-semibold">
                    Environment: Development
                </span>
            @endif
        </div>
    </div>
</footer>
