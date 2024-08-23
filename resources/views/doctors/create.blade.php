<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- script  --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <div class="content-center bg-green-300">
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Complete Doctor Form in order to login</h1>
    </div>


<form action="{{ route('doctors.store') }}" method="POST"
    class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
    @csrf

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"
            class="mt-1 block w-full p-3  border @error('user_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            readonly>
        @error('user_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror

    <div class="form-group">
        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
        <select name="department_id" class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            <option value="">Select Department</option>
            @foreach ( $departments as $department)
              <option value="{{$department->id   }}">{{$department->name   }}</option>
            @endforeach

            <!-- Add more departments as needed -->
        </select>
    </div>
    <div class="form-group">
        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
        <textarea name="bio"
            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required></textarea>
    </div>
    <div class="form-group">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" name="address"
            class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
    </div>
    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
</form>
</body>
</html>
