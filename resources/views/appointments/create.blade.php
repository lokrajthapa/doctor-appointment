<x-app-layout>

    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Appointment</h2>
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <!-- Patient Selection -->
                <input type="hidden" id="patient_id" name="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ Auth::user()->patient->id }}">
            <!-- Doctor Selection -->
            <div class="mb-4">
                {{-- <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor: </label> --}}
                <input type="hidden" id="doctor_id" name="doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $doctor->id }}">
            </div>

            {{-- Schedule --}}
            <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Doctor : {{ $doctor->user->name }}</h3>

                <!-- Date -->
                <div class="mb-4">
                    <label for="schedule_date" class="block text-sm font-medium text-gray-700">Available date and Time </label>
                    <div id="schedule_date" class="text-lg font-semibold text-gray-900 mt-2">
                      <div class="flex flex-wrap gap-2">
                            @foreach ($doctor->schedules as $schedule)
                                 <li class="bg-green-300">  {{ $schedule->date_format }}  ,  {{ $schedule->date_length }}</li>
                            @endforeach
                      </div>

                    </div>
                </div>

            </div>
            {{-- End Schedule --}}

             <div>
                <p class="text-lg bg-red-300">Note: Doctor will not be availble beside Schedule Time<p>
             </div>
            <!-- Appointment Time -->
            <div class="mb-4">
                <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
                <input type="datetime-local" id="appointment_time" name="appointment_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Department Name -->
            <div class="mb-4">
                <input type="hidden" id="department_name" name="department_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $doctor->department->name }}">
            </div>

            <!-- Reason for Appointment -->
            <div class="mb-6">
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Appointment</label>
                <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Enter the reason for your appointment"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">Book Appointment</button>
            </div>
        </form>
    </div>







</x-app-layout>

