<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Submitted Disaster Reports') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create New Report Button -->
        <div class="mb-4">
            <a href="{{ route('disaster_reports.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add New Report</a>
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('disaster_reports.index') }}" class="mb-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by disaster type or damage status..."
                class="border rounded px-3 py-2 w-1/3"
            />
            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded ml-2">Search</button>
        </form>

        @if($reports->isEmpty())
            <p class="text-gray-700">No disaster reports submitted yet.</p>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- Report ID no sort -->
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Report ID</th>

                            <!-- Sortable Columns -->
                            @php
                                $columns = [
                                    'disaster_type' => 'Disaster Type',
                                    'date' => 'Date of Disaster',
                                    'reported_at' => 'Reported Date',
                                    'damage_status' => 'Damage Status',
                                    'reporter' => 'Submitted By',
                                ];
                            @endphp

                            @foreach($columns as $columnKey => $columnLabel)
                                @php
                                    $isSorted = ($sortBy == $columnKey);
                                    $nextSortOrder = ($isSorted && $sortOrder == 'asc') ? 'desc' : 'asc';
                                @endphp
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('disaster_reports.index', array_merge(request()->all(), ['sortBy' => $columnKey, 'sortOrder' => $nextSortOrder])) }}" class="hover:underline flex items-center justify-center space-x-1">
                                        <span>{{ $columnLabel }}</span>
                                        @if($isSorted)
                                            @if($sortOrder == 'asc')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            @endif
                                        @endif
                                    </a>
                                </th>
                            @endforeach

                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Damage Report</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $report->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center capitalize">{{ $report->disaster_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ \Carbon\Carbon::parse($report->date)->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ \Carbon\Carbon::parse($report->reported_at)->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $report->damage_status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-left">{{ $report->damage_report }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $report->reporter->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center space-x-2">
                                    <a href="{{ route('disaster_reports.edit', $report) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('disaster_reports.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-3">
                    {{ $reports->links() }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
