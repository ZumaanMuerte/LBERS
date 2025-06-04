<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Add Disaster Report</h2>

        <form action="{{ route('disaster_reports.store') }}" method="POST" class="space-y-4">
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
                <label class="block mb-1">Disaster Type</label>
                <select name="disaster_type" class="w-full border p-2 rounded" required>
                    <option value="earthquake">Earthquake</option>
                    <option value="wind">Wind</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Disaster ID</label>
                <input type="number" name="disaster_id" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1">Damage Status</label>
                <select name="damage_status" class="w-full border p-2 rounded" required>
                    @foreach(['Minimal','Moderate','Severe','Worst','Catastrophic'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Damage Report</label>
                <textarea name="damage_report" class="w-full border p-2 rounded" required></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
