@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Office Management Dashboard</h2>

    <div class="d-flex gap-3">
        <a href="/departments" class="btn btn-primary btn-lg">Manage Departments</a>
        <a href="/employees" class="btn btn-success btn-lg">Manage Employees</a>
    </div>
</div>
@endsection

