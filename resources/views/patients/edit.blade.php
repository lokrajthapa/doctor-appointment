<h1>Edit Patient</h1>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">User</label>
            <input type="text" name="user_id" class="form-control" value="{{ $patient->user_id }}" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ $patient->dob }}" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" class="form-control">
                <option value="">Select Gender</option>
                <option value="male" {{ $patient->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $patient->gender == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ $patient->gender == 'other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $patient->phone }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
