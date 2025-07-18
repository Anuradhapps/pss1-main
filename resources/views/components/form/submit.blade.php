<x-button type="submit" id="submit"
    {{ $attributes->merge([
        'class' =>
            'inline-flex items-center justify-center gap-2 mt-2 px-4 py-2 text-sm font-medium text-white transition duration-300 bg-blue-700 shadow-md hover:bg-blue-900 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed w-full',
    ]) }}>
    {{ $slot }}
</x-button>
