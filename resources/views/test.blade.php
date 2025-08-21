<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Pest Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Header -->
        <div
            class="flex items-center justify-between mb-6 p-4 bg-gradient-to-r from-primary-700 to-primary-800 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="bg-white p-3 rounded-full mr-4 shadow-sm">
                    <i class="fas fa-bug text-primary-700 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Create Pest Data</h1>
            </div>
            <a href="{{ route('pestdata.view', $collectorId) }}"
                class="flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <form method="POST" action="{{ route('pestdata.store', $collectorId) }}" class="p-6">
                @csrf

                <!-- Basic Information Card -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-primary-100 p-2 rounded-full mr-3">
                            <i class="fas fa-info-circle text-primary-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Basic Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-calendar-day text-primary-500 mr-1"></i> Data Collecting Date
                            </label>
                            <input type="date" name="date_collected" value="{{ old('date_collected') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-seedling text-primary-500 mr-1"></i> Growth Stage Code
                            </label>
                            <select name="growth_s_c"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                                @php
                                    $growthStageCode = [
                                        'Germination',
                                        'Seedling',
                                        'Tillering',
                                        'Stem Elongation',
                                        'Booting',
                                        'Heading',
                                        'Milk Stage',
                                        'Dough Stage',
                                        'Mature Grain',
                                    ];
                                @endphp
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ old('growth_s_c') == $i ? 'selected' : '' }}>
                                        {{ $i }} - {{ $growthStageCode[$i - 1] }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-temperature-high text-primary-500 mr-1"></i> Temperature (°C)
                            </label>
                            <input type="number" name="temperature" value="{{ old('temperature') }}"
                                placeholder="Enter Temperature in celsius" min="-50" max="50"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-cloud-rain text-primary-500 mr-1"></i> Number of Rainy Days (Within the
                                week)
                            </label>
                            <select name="numbrer_r_day"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                                @for ($i = 0; $i <= 7; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('numbrer_r_day') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Information Alert -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-medium">Note:</span> If you have identified the pest, please click on
                                the pest name and enter the value.
                            </p>
                            <p class="text-xs text-blue-600 mt-1 italic">
                                * SP - Sample point
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pest Data Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-primary-100 p-2 rounded-full mr-3">
                            <i class="fas fa-bug text-primary-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Pest Data Collection</h2>
                    </div>

                    <!-- Number Of Tillers -->
                    <div class="mb-5">
                        <div
                            class="bg-gray-100 p-4 rounded-t-lg border border-gray-200 cursor-pointer toggleButton flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-down text-primary-600 mr-2 toggle-icon"></i>
                                <h3 class="font-semibold text-gray-800">Number Of Tillers</h3>
                            </div>
                            <span
                                class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-full">10
                                sample points</span>
                        </div>
                        <div class="hidden p-5 border border-t-0 border-gray-200 rounded-b-lg toggleDiv bg-gray-50">
                            <input type="text" hidden name="Number_Of_Tillers" value="Number_Of_Tillers">
                            <div
                                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-4">
                                @for ($i = 1; $i <= 10; $i++)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1 text-center">SP
                                            {{ $i }}</label>
                                        <input type="number" name="Number_Of_Tillers_location_{{ $i }}"
                                            value="{{ old('Number_Of_Tillers_location_' . $i) }}" min="0"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition text-center">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Pest List -->
                    @foreach ($pests as $pest)
                        @if ($pest->name == 'Thrips')
                            <div class="mb-5">
                                <div
                                    class="bg-gray-100 p-4 rounded-t-lg border border-gray-200 cursor-pointer toggleButton flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-down text-primary-600 mr-2 toggle-icon"></i>
                                        <h3 class="font-semibold text-gray-800">{{ $pest->name }}</h3>
                                    </div>
                                    <span
                                        class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Damage
                                        scale</span>
                                </div>
                                <div
                                    class="hidden p-5 border border-t-0 border-gray-200 rounded-b-lg toggleDiv bg-gray-50">
                                    <input type="text" hidden name="{{ $pest->name }}"
                                        value="{{ $pest->name }}">
                                    <div class="max-w-md mx-auto">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-list-ol text-primary-500 mr-1"></i> Damage Code:
                                        </label>
                                        <select name="{{ $pest->id }}all_location"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                                            <option value="0"
                                                {{ old($pest->id . 'all_location') == 0 ? 'selected' : '' }}>0 - No
                                                damage.</option>
                                            <option value="1"
                                                {{ old($pest->id . 'all_location') == 1 ? 'selected' : '' }}>1 -
                                                Rolling of terminal 1/3 of upper leaf only.</option>
                                            <option value="3"
                                                {{ old($pest->id . 'all_location') == 3 ? 'selected' : '' }}>3 -
                                                Rolling of terminal 1/3 to 1/2 of terminal 2 leaves.</option>
                                            <option value="5"
                                                {{ old($pest->id . 'all_location') == 5 ? 'selected' : '' }}>5 -
                                                Rolling and scorching of terminal 2 leaves.</option>
                                            <option value="7"
                                                {{ old($pest->id . 'all_location') == 7 ? 'selected' : '' }}>7 -
                                                Rolling of entire length of all leaves and prominent scorching and
                                                wilting of leaves</option>
                                            <option value="9"
                                                {{ old($pest->id . 'all_location') == 9 ? 'selected' : '' }}>9 -
                                                Pronounced wilting and drying of seedlings</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-5">
                                <div
                                    class="bg-gray-100 p-4 rounded-t-lg border border-gray-200 cursor-pointer toggleButton flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-down text-primary-600 mr-2 toggle-icon"></i>
                                        <h3 class="font-semibold text-gray-800">{{ $pest->name }}</h3>
                                    </div>
                                    <span
                                        class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-full">10
                                        sample points</span>
                                </div>
                                <div
                                    class="hidden p-5 border border-t-0 border-gray-200 rounded-b-lg toggleDiv bg-gray-50">
                                    <input type="text" hidden name="{{ $pest->name }}"
                                        value="{{ $pest->name }}">

                                    <div class="mb-3">
                                        @switch($pest->name)
                                            @case('Gall Midge')
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <i class="fas fa-info-circle mr-1.5"></i> No of silver shoots
                                                </div>
                                            @break

                                            @case('Leaffolder')
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <i class="fas fa-info-circle mr-1.5"></i> No of damaged tillers
                                                </div>
                                            @break

                                            @case('Yellow Stem Borer')
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <i class="fas fa-info-circle mr-1.5"></i> No of dead hearts + white heads
                                                </div>
                                            @break

                                            @case('BPH+WBPH')
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <i class="fas fa-info-circle mr-1.5"></i> No of adults and nymphs
                                                </div>
                                            @break

                                            @case('Paddy Bug')
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <i class="fas fa-info-circle mr-1.5"></i> No of adults and nymphs
                                                </div>
                                            @break

                                            @default
                                        @endswitch
                                    </div>

                                    <div
                                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-4">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1 text-center">SP
                                                    {{ $i }}</label>
                                                <input type="number"
                                                    name="{{ $pest->id }}_location_{{ $i }}"
                                                    value="{{ old($pest->id . '_location_' . $i) }}" min="0"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition text-center">
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Additional Information -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="bg-primary-100 p-2 rounded-full mr-3">
                            <i class="fas fa-sticky-note text-primary-600"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Additional Information</h2>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment-dots text-primary-500 mr-1"></i> Other information within the AI
                            Range:
                        </label>
                        <textarea name="otherinfo" rows="3"
                            placeholder="Example: Any insects damage (% damage or extent), Any disease, Any weeds"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">{{ old('otherinfo') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="flex items-center bg-primary-600 hover:bg-primary-700 text-white font-medium px-5 py-2.5 rounded-lg transition-colors shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggleButton').forEach(button => {
            button.addEventListener('click', () => {
                const toggleDiv = button.nextElementSibling;
                const icon = button.querySelector('.toggle-icon');

                toggleDiv.classList.toggle('hidden');

                if (toggleDiv.classList.contains('hidden')) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });
    </script>
</body>

</html>
