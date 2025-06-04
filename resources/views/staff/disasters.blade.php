<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Disasters to Report') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($earthquakes->isEmpty() && $winds->isEmpty())
            <p class="text-gray-700">No new disasters to report.</p>
        @endif

        {{-- Earthquakes --}}
        @if($earthquakes->isNotEmpty())
            <h3 class="text-lg font-semibold mt-6 mb-2">Earthquakes</h3>
            @foreach($earthquakes as $eq)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <p><strong>Date:</strong> {{ $eq->date ? \Carbon\Carbon::parse($eq->date)->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ $eq->location }}</p>
                    <p><strong>Magnitude:</strong> {{ $eq->intensity_scale ?? 'N/A' }}</p>

                    <form method="POST" action="{{ route('staff.disasters.report', ['disasterType' => 'earthquake', 'disasterId' => $eq->id]) }}" class="mt-4">
                        @csrf
                        <label class="block mb-1" for="damage_status_{{ $eq->id }}">Damage Status</label>
                        <select id="damage_status_{{ $eq->id }}" name="damage_status" required
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mb-3">
                            <option value="">Select Status</option>
                            <option value="Minimal">Minimal</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe">Severe</option>
                            <option value="Worst">Worst</option>
                            <option value="Catastrophic">Catastrophic</option>
                        </select>

                        <label class="block mb-1" for="damage_report_{{ $eq->id }}">Damage Report</label>
                        <input type="text" id="damage_report_{{ $eq->id }}" name="damage_report" maxlength="255" required
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mb-3"
                               placeholder="Describe the damage...">

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Report
                        </button>
                    </form>
                </div>
            @endforeach
        @endif

        {{-- Winds --}}
        @if($winds->isNotEmpty())
            <h3 class="text-lg font-semibold mt-6 mb-2">Winds</h3>
            @foreach($winds as $wind)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <p><strong>Date:</strong> {{ $wind->date ? \Carbon\Carbon::parse($wind->date)->format('Y-m-d') : 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ $wind->location }}</p>
                    <p><strong>Wind Speed:</strong> {{ $wind->wind_signal ?? 'N/A' }}</p>

                    <form method="POST" action="{{ route('staff.disasters.report', ['disasterType' => 'wind', 'disasterId' => $wind->id]) }}" class="mt-4">
                        @csrf
                        <label class="block mb-1" for="damage_status_wind_{{ $wind->id }}">Damage Status</label>
                        <select id="damage_status_wind_{{ $wind->id }}" name="damage_status" required
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mb-3">
                            <option value="">Select Status</option>
                            <option value="Minimal">Minimal</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Severe">Severe</option>
                            <option value="Worst">Worst</option>
                            <option value="Catastrophic">Catastrophic</option>
                        </select>

                        <label class="block mb-1" for="damage_report_wind_{{ $wind->id }}">Damage Report</label>
                        <input type="text" id="damage_report_wind_{{ $wind->id }}" name="damage_report" maxlength="255" required
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full mb-3"
                               placeholder="Describe the damage...">

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Submit Report
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
