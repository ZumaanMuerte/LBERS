<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Disaster Reports</h2>

        <form method="GET" class="mb-4 flex space-x-4">
            <input type="date" name="search_date" value="{{ request('search_date') }}" class="border px-4 py-2 rounded" placeholder="Search by date">
            <input type="text" name="search_location" value="{{ request('search_location') }}" class="border px-4 py-2 rounded" placeholder="Search by location">
            <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded">Search</button>
        </form>


        <table class="w-full border-collapse bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Location</th>
                    <th class="border px-4 py-2">Disaster Type</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td class="border px-4 py-2">{{ $report->date }}</td>
                        <td class="border px-4 py-2">{{ $report->location }}</td>
                        <td class="border px-4 py-2 capitalize">{{ $report->disaster_type }}</td>
                        <td class="border px-4 py-2">{{ $report->damage_status }}</td>
                        <td class="border px-4 py-2 flex space-x-2">
                            <button class="bg-grey-600 text-black px-2 py-1 rounded hover:bg-black-900">
                            <a href="{{ route('disaster_reports.edit', $report) }}" class="text-blue-600 hover:underline">Edit</a>
                            </button>
                            <form action="{{ route('disaster_reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Delete this report?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 flex justify-between items-center">
            <a href="{{ route('disaster_reports.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600">Add Report</a>
            <a href="{{ route('disaster_reports.print') }}" class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">Preview Report PDF</a>
            <div>{{ $reports->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
