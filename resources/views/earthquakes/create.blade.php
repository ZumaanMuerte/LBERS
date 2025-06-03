<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Add New Earthquake</h2>

        <form action="{{ route('earthquakes.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Date</label>
                <input type="date" name="date" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Location</label>
                <input type="text" name="location" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Intensity Scale</label>
                <select name="intensity_scale" class="w-full border p-2 rounded" required>
                    @foreach (['I','II','III','IV','V','VI','VII','VIII','IX','X'] as $scale)
                        <option value="{{ $scale }}">{{ $scale }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
