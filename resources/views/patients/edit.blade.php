<h1 class="text-2xl font-bold mb-6">Edit Patient</h1>
<form action="{{ route('patients.update', $patient->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
        <input type="text" name="user_id" id="user_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $patient->user_id }}" required>
    </div>

    <div class="form-group">
        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $patient->dob }}" required>
    </div>

    <div class="form-group">
        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
        <select name="gender" id="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">Select Gender</option>
            <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ $patient->gender == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" name="phone" id="phone" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $patient->phone }}">
    </div>

    <div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Update
        </button>
    </div>
</form>
