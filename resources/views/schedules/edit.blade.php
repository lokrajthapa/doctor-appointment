<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Schedules') }}
        </h2>
    </x-slot>




    <div class="content-center bg-green-300">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Edit Schedule </h1>

    </div>
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <form action="{{ route('schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">

                <input type="hidden" name="doctor_id" id="doctor_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value={{ Auth::user()->doctor->id }}>
                @error('doctor_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input name="date" type="date" class="block  text-gray-700 " value="{{ $schedule->date }}">

                @error('date')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>





            <div class="mb-4">
                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                <input type="time" name="start_time" id="start_time"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ $schedule->start_time }}">
                @error('start_time')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                <input type="time" name="end_time" id="end_time"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ $schedule->end_time }}">
                @error('end_time')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>





</x-app-layout>
