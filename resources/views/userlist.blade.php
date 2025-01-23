@extends('layouts.app', ['pageSlug' => 'userlist'])

@section('content')
    <div class="container">
        <div class="option-container">
            <h4>User List</h4>
            <button class="btn btn-primary animation-on-hover" type="button" onclick="openModal()">
                <i class="tim-icons icon-simple-add"></i>Add User
            </button>
        </div>

        <x-modal-component />

        <table class="table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="td-actions">
                        <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                            <i class="tim-icons icon-single-02"></i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE') <!-- Add this line -->
                            <button type="submit" rel="tooltip" class="btn btn-danger btn-sm btn-icon" onclick="return confirm('Are you sure you want to delete this user?');">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>
@endsection

<style>
    .option-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .option-container h4 {
        font-size: 16px;
    }

    .option-container button {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .option-container button i {
        font-size: 14px;
        margin-bottom: 2px;
    }
</style>
