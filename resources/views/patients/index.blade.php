<h1>Patients</h1>
<a href="{{ route('patients.create') }}" class="btn btn-primary">Add Patient</a>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patients as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->user->name }}</td>
            <td>{{ $patient->dob }}</td>
            <td>{{ $patient->gender }}</td>
            <td>{{ $patient->phone }}</td>
            <td>
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info">View</a>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
