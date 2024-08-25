<h1>doctors</h1>
<a href="{{ route('doctors.create') }}" class="btn btn-primary">Add doctor</a>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Department</th>
            <th>Bio</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($doctors as $doctor)
        <tr>
            <td>{{ $doctor->id }}</td>
            <td>{{ $doctor->user->name }}</td>
            <td>{{ $doctor->department->name }}</td>
            <td>{{ $doctor->bio }}</td>
            <td>{{ $doctor->address }}</td>
            <td>
                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
