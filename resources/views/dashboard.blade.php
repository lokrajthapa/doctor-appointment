<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
   @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::user()->user_type === 'doctor' )

                        <div class="flex">

                        @if(isset(Auth::user()->doctor))

                        <a href="{{ route("doctors.edit",Auth::user()->doctor->id) }}">
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Edit Profile
                            </button>
                        </a>



                        @else
                        <a href="{{ route("doctors.create") }}">
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                First fill doctor form
                            </button>
                        </a>


                        @endif

                        <div>
                    @endif

                @if (Auth::user()->user_type === 'patient')
                    <div class="flex">



                       @if(isset(Auth::user()->patient))

                            <a href="{{ route("patients.edit",Auth::user()->patient->id) }}">
                                <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Edit Profile
                                </button>
                            </a>

                        @else

                            <a href="{{ route("patients.create") }}">
                                <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    First fill patient form
                                </button>
                            </a>

                        @endif

                    <div>
                @endif




                    <div class="m-2 gap-4">
                        {{ __("You're logged in!") }}

                    </div>




                </div>

            </div>
        </div>
    </div>

</x-app-layout>
