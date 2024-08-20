<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Departments') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold mb-6">Choose Departments</h3>


                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($departments as $department)
                        <div class="p-6 bg-green-50 rounded-lg shadow-md hover:bg-green-100 transition duration-200">
                            <p class="text-lg text-green-800 dark:text-green-400 font-medium mb-4">{{ $department->name }}</p>
                            <a href="{{ route('departments.show',$department->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                Find Doctors
                            </a>
                            <div class="flex gap-y-4 gap-x-4 mt-4">
                                <!-- Edit Button -->
                                <a href="{{ route('departments.edit',$department) }}">
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('departments.destroy',$department) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure you want to delete this department? This action cannot be undone.')"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
s
