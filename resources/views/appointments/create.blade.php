<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Appointment') }}
        </h2>
    </x-slot>




<div class="content-center bg-green-300">
<h1 class="text-3xl font-semibold mb-6 text-gray-800">Schedule Appointment</h1>

</div>
<form action="{{ route('appointments.store') }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
    @csrf
    <div class="form-group">
        <label for="department_name" class="block text-sm font-medium text-gray-700">Department Name</label>
        <select name="department_name" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>

        @foreach ( $departments as $department)
             <option value="{{$department->name   }}">{{$department->name   }}</option>
          @endforeach
        </select>
        @error('department_name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    </div>
{{-- @dd() --}}
    <div class="form-group">
        <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
        <select name="doctor_id" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
             @foreach ( $doctors as $doctor)
               <option value="{{$doctor->id }}">{{$doctor->user->name}}</option>
             @endforeach
        </select>
        @error('doctor_id')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
    <div class="form-group">
        <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
        <input type="date" name="appointment_time" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        @error('appointment_time')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
    <div class="form-group">
        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient ID</label>
        <input type="text" name="patient_id" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{  Auth::user()->patient->id }}" readonly>
        @error('patient_id')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
    <div class="form-group">
        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Appointment</label>
        <textarea name="reason" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
    @error('reason')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    </div>
    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Schedule Appointment</button>
</form>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const departmentSelect = document.getElementById('department_id');
        const doctorSelect = document.getElementById('doctor_id');

        const doctors = @json(
            $departments->mapWithKeys(function ($department) {
                return [$department->id => $department->doctors->pluck('doctors.id', 'id')];
            }));

        departmentSelect.addEventListener('change', function() {
            const departmentId = departmentSelect.value;
            const doctorsOptions = doctors[departmentId] || {};

            doctorSelect.innerHTML = '<option value="">Select a Doctor</option>';

            Object.keys(doctorsOptions).forEach(function(doctorId) {
                const option = document.createElement('option');
                option.value = doctorId;
                option.textContent = doctorsOptions[doctorId];
                doctorSelect.appendChild(option);
            });
        });
    });
</script> --}}


</x-app-layout>





