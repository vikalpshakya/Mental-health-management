@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Available Tests</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Questions</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tests as $test)
                                    <tr>
                                        <td>{{ $test->id }}</td>
                                        <td>{{ $test->title }}</td>
                                        <td>{{ Str::limit($test->description, 100) }}</td>
                                        <td>{{ $test->questions_count }}</td>
                                        <td>{{ $test->expert->name }}</td>
                                        <td>{{ $test->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('expert.take-tests.show', $test) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-pencil-alt"></i> Take Test
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 