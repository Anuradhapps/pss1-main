<div class="flex flex-col items-center min-h-screen pt-6 text-white bg-gray-700 sm:justify-center sm:pt-0">
    <section class="container max-w-screen-lg mx-auto text-center hero">
        @php
            //cache the logo setting to reduce calling the database
            $loginLogo = Cache::rememberForever('loginLogo', function () {
                return \App\Models\Setting::where('key', 'loginLogo')->value('value');
            });

            $loginLogoDark = Cache::rememberForever('loginLogoDark', function () {
                return \App\Models\Setting::where('key', 'loginLogoDark')->value('value');
            });
        @endphp

        <a href="{{ url('admin') }}">
            @if (storage_exists($loginLogo))
                <picture>
                    <source srcset="{{ Storage::url($loginLogoDark) }}" media="(prefers-color-scheme: dark)">
                    <img class="mx-auto" src="{{ Storage::url($loginLogo) }}" alt="{{ config('app.name') }}">
                </picture>
            @else
                <h1>{{ config('app.name') }}</h1>
            @endif
        </a>
    </section>
    <div class="w-full px-6 py-4 mt-6 mb-10 bg-gray-900 overflow-hiddenshadow-md sm:max-w-md sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
