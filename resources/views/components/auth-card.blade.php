<div class="flex flex-col items-center min-h-screen pt-2 text-white bg-gray-600 sm:justify-center sm:pt-0">


    <div class="w-full max-w-md py-1 mt-2">


        {{-- <x-logo-light></x-logo-light> --}}

        <x-logo-dark></x-logo-dark>

    </div>
    <!-- Form Slot -->
    <div class="w-full max-w-md px-6 py-4 mt-2 mb-2 bg-gray-900  shadow-md">
        {{ $slot }}
    </div>
</div>
