@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Details</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">ID</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ $user->id }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Created At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Updated At</label>
                        <div class="col-sm-9">
                            <p class="form-control-plaintext">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 