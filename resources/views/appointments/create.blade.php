<x-app-layout>


    <form x-data="appointmentForm()" class="p-4" action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="department_name" class="block text-sm font-medium text-gray-700">Department Name</label>
            <select name="department_id" x-model="selectedDepartment" @change="filterDoctors"
                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
                <option value="">Select a Department</option>
                @foreach ($departments as $department)
                    <option  value="{{ $department['id']}}">{{ $department['name'] }}</option>
                @endforeach
            </select>
            @error('department_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

          <!-- Hidden input to store department name -->
        <input type="hidden" name="department_name" :value="selectedDepartmentName">

        <div class="form-group">
            <label for="doctor_id" class="block text-sm font-medium text-gray-700">Doctor</label>
            <select name="doctor_id" x-model="selectedDoctor" @change="filterSchedules"
                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
                <option value="">Select a Doctor</option>
                <template x-for="doctor in filteredDoctors" :key="doctor.id">

                    <option :value="doctor.id" x-text="doctor.user.name"></option>
                </template>
            </select>
            @error('doctor_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="schedule" class="block text-sm font-medium text-gray-700">Available Schedules</label>
            <ul class="list-disc pl-5 mt-1">
                <template x-for="schedule in filteredSchedules" :key="schedule.id">
                    <li x-text="`${schedule.day}: ${schedule.start_time} - ${schedule.end_time}`"></li>
                </template>
            </ul>
        </div>
        <div class="form-group">
            <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
            <input type="date" name="appointment_time" id="appointment_time"
                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
            @error('appointment_time')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">

            <input type="hidden" name="patient_id" id="patient_id"
                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                value="{{ Auth::user()->patient->id }}" readonly>
            @error('patient_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Appointment</label>
            <textarea name="reason"
                class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required></textarea>
            @error('reason')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <button type="submit"
            class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Schedule
            Appointment
        </button>
    </form>

    <script>
        function appointmentForm() {
            return {
                selectedDepartment: '',
                selectedDoctor: '',
                departments: @json($departments),
                filteredDoctors: [],
                filteredSchedules: [],
                    // Update department name based on selected department ID
            updateDepartmentName() {
                const department = this.departments.find(dept => dept.id == this.selectedDepartmentId);
                this.selectedDepartmentName = department ? department.name : '';
            },

                filterDoctors() {
                    this.filteredDoctors = this.departments.find(department => department.id == this.selectedDepartment)
                        ?.doctors || [];
                    this.selectedDoctor = '';
                    this.filteredSchedules = [];
                },

                filterSchedules() {
                    const selectedDoctor = this.filteredDoctors.find(doctor => doctor.id == this.selectedDoctor);
                    this.filteredSchedules = selectedDoctor ? selectedDoctor.schedules : [];
                }
            };
        }
    </script>
</x-app-layout>
