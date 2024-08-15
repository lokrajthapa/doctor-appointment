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
        <form action="{{ route('schedules.update',$schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">

                <input type="hidden" name="doctor_id" id="doctor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  value={{ Auth::user()->doctor->id }}>
                 @error('doctor_id')
                  <p class="text-red-500 text-xs italic">{{ $message }}</p>
                 @enderror
            </div>

            <div class="mb-4">
                <label for="day" class="block text-gray-700 text-sm font-bold mb-2">Days</label>

                <select name="day" id="day" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option selected > {{ $schedule->day }}</option>
                        <option value="sunday">Sunday</option>
                        <option value="monday">Monday</option>
                        <option value="tuesday">Tuesday</option>
                        <option value="wednesday">Wednesday</option>
                        <option value="thursday">Thursday</option>
                        <option value="friday">Friday</option>
                        <option value="saturday">Saturday</option>
                </select>
                @error('day')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>



            <div class="mb-4">
                <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $schedule->start_time }}">
                @error('start_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                <input type="time" name="end_time" id="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $schedule->end_time }}">
                @error('end_time')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Schedule
                </button>
            </div>
        </form>
    </div>





</x-app-layout>
