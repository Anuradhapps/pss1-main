<x-guest-layout>

    @if (Route::has('login'))
        <div class="fixed top-0 right-0 hidden px-6 py-4 sm:block">
            @auth
                <a href="{{ route('admin') }}" class="text-sm text-gray-200 underline">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-200 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-200 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="flex flex-col items-center min-h-screen pt-6 text-white bg-gray-700 sm:justify-center sm:pt-0">
        @php
            //cache the logo setting to reduce calling the database
            $loginLogo = Cache::rememberForever('loginLogo', function () {
                return \App\Models\Setting::where('key', 'loginLogo')->value('value');
            });
        @endphp

        @if (storage_exists($loginLogo))
            <picture>
                <source srcset="{{ storage_url($loginLogo) }}" media="(prefers-color-scheme: dark)">
                <img class="mx-auto" src="{{ storage_url($loginLogo) }}" alt="{{ config('app.name') }}">
            </picture>
        @else
            <h1>{{ config('app.name') }}</h1>
        @endif
    </div>

</x-guest-layout>
