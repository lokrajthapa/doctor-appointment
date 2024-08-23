<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctors') }}
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold mb-6">Choose doctors </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($department->doctors as $doctor)

                <div class="max-w-sm mx-auto bg-white rounded-xl shadow-lg overflow-hidden transition transform hover:-translate-y-1 hover:shadow-2xl">
                    <div class="flex items-center p-6 bg-gradient-to-r from-blue-500 to-purple-500">
                        <img class="w-20 h-20 rounded-full border-4 border-white shadow-md"  src="{{ $doctor->user->image ? asset('storage/profile_images/' . $doctor->user->image) : asset('storage/profile_images/default.png') }}" alt="Profile Image">
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-white">{{ $doctor->user->name }}</h2>
                            <p class="text-blue-200">{{ $department->name  }}</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.</p>
                    </div>


                    <div class="p-6 bg-gray-100">
                        <a href="{{ route('doctor.to.appointment', $doctor->id ) }}" class="inline-block bg-blue-600 text-white font-semibold text-center px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 w-full">
                            Book Appointment
                        </a>
                    </div>
                </div>

                     @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
s
