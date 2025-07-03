<a
    {{ $attributes->merge([
        'class' =>
            'block w-full px-4 py-2 text-sm font-medium text-gray-200 transition duration-150 rounded-md hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500',
    ]) }}>
    {{ $slot }}
</a>
