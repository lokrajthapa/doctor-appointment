<h1>Edit doctor</h1>
    <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">User</label>
            <input type="text" name="user_id" class="form-control" value="{{ $doctor->user_id }}" required>
        </div>
        <div class="form-group">
            <label for="department_id">Department</label>
            <input type="text" name="department_id" class="form-control" value="{{ $doctor->department_id }}" required>
        </div>
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control" required>{{ $doctor->bio }}</textarea>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $doctor->address }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
