@props(['name'])

<a x-on:click="tab = '{{ $name }}'"
    x-bind:class="{ '   border-blue-300 hover:border-blue-400 text-blue-300 hover:text-blue-400': tab === '{{ $name }}' }"
    @click.prevent="tab = '{{ $name }}'; window.location.hash = '{{ $name }}'" href="#"
    {{ $attributes->merge(['class' => 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-gray-300 hover:text-gray-400 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']) }}>
    {{ $slot }}
</a>
