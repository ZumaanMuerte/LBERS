<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Edit Disaster Report</h2>

        <form action="{{ route('disaster_reports.update', $report) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Date</label>
                <input type="date" name="date" value="{{ $report->date }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Location</label>
                <input type="text" name="location" value="{{ $report->location }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Disaster Type</label>
                <select name="disaster_type" class="w-full border p-2 rounded" required>
                    <option value="earthquake" {{ $report->disaster_type == 'earthquake' ? 'selected' : '' }}>Earthquake</option>
                    <option value="wind" {{ $report->disaster_type == 'wind' ? 'selected' : '' }}>Wind</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Disaster ID</label>
                <input type="number" name="disaster_id" value="{{ $report->disaster_id }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Damage Status</label>
                <select name="damage_status" class="w-full border p-2 rounded" required>
                    @foreach(['Minimal','Moderate','Severe','Worst','Catastrophic'] as $status)
                        <option value="{{ $status }}" {{ $report->damage_status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
