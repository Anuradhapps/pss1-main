<a
    {{ $attributes->merge([
        'class' =>
            'flex items-center w-full px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 transition duration-150 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-primary dark:hover:text-white focus:outline-none focus:bg-slate-100 dark:focus:bg-slate-700',
    ]) }}>
    {{ $slot }}
</a>
