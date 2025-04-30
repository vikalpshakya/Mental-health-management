@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Expert Details</h1>
        <div>
            <a href="{{ route('admin.experts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Experts
            </a>
            <a href="{{ route('admin.experts.edit', $expert) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Expert
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="h4 mb-3">Personal Information</h3>
                    <table class="table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $expert->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $expert->email }}</td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td>{{ ucfirst($expert->role) }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $expert->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $expert->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 