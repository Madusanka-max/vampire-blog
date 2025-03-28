<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Posts</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="role" onchange="this.form.submit()">
                        @foreach(['admin', 'editor', 'reader'] as $role)
                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </td>
            <td>{{ $user->posts_count }}</td>
            <td>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>