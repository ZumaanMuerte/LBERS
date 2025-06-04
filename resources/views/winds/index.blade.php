<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-black"><strong>Wind Reports</strong></h1>
        <div class="flex justify-between items-center mb-4 p-4 bg-white">
            <div>
    <form method="GET" class="mb-4">
                    <input type="text" name="search" placeholder="Search by location or signal" value="{{ request('search') }}" class="border p-2 rounded w-50%">
                    <button type="submit" class="bg-gray-600 text- px-4 py-2 rounded">Search</button>
                </form>

            </div>


            <div class="space-x-2">
                 <button class='bg-white'>
                <a href="{{ route('winds.create') }}" class="bg-blue-500 text-black px-4 py-1 rounded hover:bg-blue-600">Add Wind</a>
                </button>
                 <button class="bg-green-600">
                <a href="{{ route('winds.print') }}" class="bg-green-500 text-black px-4 py-1 rounded hover:bg-green-600">Print PDF</a>
                </button>
            </div>
        </div>


        <table class="w-full table-auto border-collapse bg-white ">
            <thead class="bg-indigo-900 text-white text-center">
                <tr>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Location</th>
                    <th class="border px-4 py-2">Wind Signal</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($winds as $wind)
                    <tr>
                        <td class="border px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">{{ $wind->date }}</td>
                        <td class="border px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">{{ $wind->location }}</td>
                        <td class="border px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">{{ $wind->wind_signal }}</td>
                        <td class="border px-4 py-2 whitespace-nowrap text-sm text-gray-900 text-center">
                            <div class="flex space-x-2">
                                <button class="bg-grey-600 text-black px-2 py-1 rounded hover:bg-black-900">
                                <a href="{{ route('winds.edit', $wind) }}" class="bg-green-700 text-black px-2 py-1 rounded hover:bg-green-900">Edit</a>
                                </button>
                                <form action="{{ route('winds.destroy', $wind) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-black px-2 py-1 rounded hover:bg-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $winds->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
