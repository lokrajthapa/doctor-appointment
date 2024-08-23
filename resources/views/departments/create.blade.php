
<x-app-layout>


    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-10 p-6">
        <h1 class="text-2xl font-semibold text-gray-700 mb-4">Create Department</h1>
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="Department Name" class="block text-sm font-medium text-gray-600">Department Name:</label>
                <input type="text" name="name" id="department_name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    required>
                @error('department_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Create</button>
        </form>
    </div>

</x-app-layout>
