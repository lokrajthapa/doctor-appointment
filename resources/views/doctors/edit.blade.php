<x-app-layout>


<h1 class="text-2xl font-bold mb-6">Edit Doctor</h1>
<form action="{{ route('doctors.update', $doctor->id) }}" method="POST" class="space-y-6 m-4">
    @csrf
    @method('PUT')

    <!-- User ID Field -->
    <div class="form-group">

        <input type="hidden" name="user_id" id="user_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $doctor->user_id }}" required>
    </div>

    <!-- Department ID Field -->
    <div class="form-group">
        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
        <input type="text" name="department_id" id="department_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $doctor->department_id }}" required>
    </div>

    <!-- Bio Field -->
    <div class="form-group">
        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea name="bio" id="bio" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ $doctor->bio }}</textarea>
    </div>

    <!-- Address Field -->
    <div class="form-group">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" name="address" id="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $doctor->address }}" required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Update
    </button>
</form>
</x-app-layout>

