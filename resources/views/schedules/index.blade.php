<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Schedules') }}
        </h2>
    </x-slot>



    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Auth::user()->user_type === 'doctor')
                <a href="{{ route('schedules.create') }}"> <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add
                        Schedule
                    </button> </a>
            @endif



        </div>
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex gap-y-4 gap-x-2">
            @foreach ($schedules as $schedule)
                 <div class="max-w-sm  bg-white border border-gray-300 rounded-lg shadow-md p-4">
                    <div class="text-center mb-4">
                        <!-- Day -->
                        <div class="text-lg font-bold text-blue-600">
                            {{ $schedule->day }}
                        </div>



                        <div class="text-sm font-bold text-blue-600">
                            {{ $schedule->date_length }}
                        </div>


                    </div>

                    <div class="flex gap-y-4">
                        <!-- Edit Button -->
                          <a href="{{ route('schedules.edit', $schedule) }}">
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Edit
                            </button>
                        </a>
                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Delete
                            </button>
                         </form>
                    </div>
                </div>

            @endforeach



            <div>

            </div>
        </div>
</x-app-layout>
