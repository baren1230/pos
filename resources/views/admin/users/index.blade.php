@extends('layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            @include('admin.users.partials.breadcrumb', [
                'breadcrumbActive' => 'Kelola Pengguna',
            ])
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="row">
                    <!-- [ sample-page ] start -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addUserModal">
                                    Create User
                                </button>

                                @include('admin.users.partials.add_user_modal')

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <!-- Image column removed -->
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <!-- Removed Status column -->
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <!-- Image display removed -->
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->role }}</td>
                                                    <!-- Removed status display -->
                                                    <td>
                                                        <!-- Edit button triggers modal -->
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editUserModal{{ $user->id }}">
                                                            Edit
                                                        </button>

                                                        @include('admin.users.partials.edit_user_modal', [
                                                            'user' => $user,
                                                            'roles' => $roles,
                                                        ])
                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No users found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ sample-page ] end -->
                </div>
            </div>
        </div>
    </div>
@endsection
