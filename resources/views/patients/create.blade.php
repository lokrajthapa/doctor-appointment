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
        <h1 class="text-3xl font-semibold mb-6 text-gray-800">Complete Patient Form in order to login</h1>
    </div>
    <form action="{{ route('patients.store') }}" method="POST"
        class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
        @csrf



            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"
                class="mt-1 block w-full p-3  border @error('user_id') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
            @error('user_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

        <div class="form-group">
            <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob') }}"
                class="mt-1 block w-full p-3 border @error('dob') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required>
            @error('dob')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <select name="gender"
                class="mt-1 block w-full p-3 border @error('gender') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="mt-1 block w-full p-3 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @error('phone')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="w-full py-3 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
    </form>
</body>

</html>
