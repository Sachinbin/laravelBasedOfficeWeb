@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-3 fw-bold">Departments</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">Add Department</div>
                <div class="card-body">
                    <form method="POST" action="/departments">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <input name="description" class="form-control">
                        </div>

                        <button class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">Department List</div>
                <div class="card-body p-0">

                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($departments as $index => $d)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->description }}</td>
                                    <td>
                                        <form method="POST" action="/departments/{{ $d->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Del</button>
                                        </form>
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
@endsection
