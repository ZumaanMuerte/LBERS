<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4">

        <h1 class="text-2xl font-black mb-6">Winds</h1>

        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded shadow">

            <form method="GET" class="flex space-x-2 items-center">
                <input
                    type="text"
                    name="search"
                    placeholder="Search by location"
                    value="{{ request('search') }}"
                    class="border p-6 rounded w-64"
                />
                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Search
                </button>
            </form>

            <div class="space-x-2">
                <a href="{{ route('winds.print') }}" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                    Print PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @php
                // Map wind signals to intensity (1 to 5 scale)
                $signalIntensityMap = [
                    'Tropical Depression' => 1,
                    'Tropical Storm' => 2,
                    'Severe Tropical Storm' => 3,
                    'Typhoon' => 4,
                    'Super Typhoon' => 5,
                ];
            @endphp

            @foreach ($winds as $wind)
                @php
                    $intensity = $signalIntensityMap[$wind->wind_signal] ?? 1;
                    // Calculate opacity: higher intensity = darker (opacity 0.15 to 0.6)
                    $opacity = 0.15 + ($intensity - 1) * 0.1125;
                    // Base blue with opacity for overlay
                    $overlayColor = "rgba(30, 64, 175, {$opacity})";
                @endphp

                <div
                    class="relative rounded-lg shadow-lg overflow-hidden cursor-pointer transform transition duration-300 hover:scale-105 hover:shadow-2xl"
                    style="background-image: url('{{ asset('images/typhoon_bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                >
                    <div style="background-color: {{ $overlayColor }};" class="p-5 h-full flex flex-col justify-center text-black backdrop-blur-sm">
                        <p class="font-semibold text-lg mb-3">{{ \Carbon\Carbon::parse($wind->date)->format('F j, Y') }}</p>
                        <p class="text-md mb-1"><strong>Location:</strong> {{ $wind->location }}</p>
                        <p class="text-md"><strong>Wind Signal:</strong> {{ $wind->wind_signal }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $winds->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>
