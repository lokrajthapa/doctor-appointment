
<x-app-layout>

    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Reschedule Appointment</h2>
        <form action="{{ route('appointments.update',$appointment->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <!-- Appointment Time -->
            <div class="mb-4">
                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
                <input type="datetime-local" id="appointment_time" name="appointment_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{$appointment->appointment_time }}">
            </div>


            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">Update Schedule</button>
            </div>
        </form>
    </div>



</x-app-layout>




