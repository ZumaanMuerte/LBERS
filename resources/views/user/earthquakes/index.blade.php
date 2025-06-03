<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4">

        <h1 class="text-2xl font-black mb-6">Earthquakes</h1>

        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded shadow">

            <form method="GET" class="flex space-x-2 items-center">
                <input
                    type="text"
                    name="search"
                    placeholder="Search by location"
                    value="{{ request('search') }}"
                    class="border p-2 rounded w-64"
                />
                <button type="submit" class="bg-gray-600 text-black px-4 py-2 rounded hover:bg-gray-700">
                    Search
                </button>
            </form>

            <div class="space-x-2">
                <a href="{{ route('earthquakes.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">
                    Add Earthquake
                </a>
                <a href="{{ route('earthquakes.print') }}" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                    Print PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @php
                // Map roman numeral intensity scale to numeric 1-10
                $romanMap = ['I'=>1,'II'=>2,'III'=>3,'IV'=>4,'V'=>5,'VI'=>6,'VII'=>7,'VIII'=>8,'IX'=>9,'X'=>10];
            @endphp

            @foreach ($earthquakes as $eq)
                @php
                    $intensityNumeric = $romanMap[strtoupper($eq->intensity_scale)] ?? 1;
                    $opacity = 0.1 + ($intensityNumeric - 1) * 0.1; // from 0.1 to 1.0 approx
                    $overlayColor = "rgba(101, 67, 33, {$opacity})"; // brown with opacity
                @endphp

                <div
                    class="relative rounded-lg shadow-lg overflow-hidden cursor-pointer transform transition duration-300 hover:scale-105 hover:shadow-2xl"
                    style="background-image: url('{{ asset('images/earthquake_bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;"
                >
                    <div style="background-color: {{ $overlayColor }};" class="p-5 h-full flex flex-col justify-center text-black backdrop-blur-sm">
                        <p class="font-semibold text-lg mb-3">{{ \Carbon\Carbon::parse($eq->date)->format('F j, Y') }}</p>
                        <p class="text-md mb-1"><strong>Location:</strong> {{ $eq->location }}</p>
                        <p class="text-md"><strong>Intensity:</strong> {{ strtoupper($eq->intensity_scale) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $earthquakes->withQueryString()->links() }}
        </div>

    </div>
</x-app-layout>
