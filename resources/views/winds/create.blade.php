<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Add New Wind Report</h2>

        <form action="{{ route('winds.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Date</label>
                <input type="date" name="date" class="w-full border border-gray-300 px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Location</label>
                <input type="text" name="location" class="w-full border border-gray-300 px-3 py-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Wind Signal</label>
                <select name="wind_signal" class="w-full border border-gray-300 px-3 py-2 rounded" required>
                    @foreach(['Tropical Depression', 'Tropical Storm', 'Severe Tropical Storm', 'Typhoon', 'Super Typhoon'] as $signal)
                        <option value="{{ $signal }}">{{ $signal }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
