@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-3">Employees</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">Add Employee</div>

                <div class="card-body">

                    <form method="POST" action="/employees">
                        @csrf

                        <div class="mb-2">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Age</label>
                            <input name="age" type="number" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Department</label>
                            <select name="department_id" class="form-select">
                                <option>Select</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- COUNTRY --}}
                        <div class="mb-2">
                            <label>Country</label>
                            <select id="country" name="country" class="form-select"></select>
                        </div>

                        {{-- STATE --}}
                        <div class="mb-2">
                            <label>State</label>
                            <select id="state" name="state" class="form-select"></select>
                        </div>

                        {{-- CITY --}}
                        <div class="mb-2">
                            <label>City</label>
                            <select id="city" name="city" class="form-select"></select>
                        </div>

                        <button class="btn btn-success w-100">Add</button>
                    </form>

                </div>
            </div>

        </div>

        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header fw-bold">Employee List</div>
                <div class="card-body p-0">

                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Dept</th>
                                <th>Location</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($employees as $i => $e)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $e->name }}</td>
                                    <td>{{ $e->email }}</td>
                                    <td>{{ $e->department->name }}</td>
                                    <td>{{ $e->city }}, {{ $e->state }}, {{ $e->country }}</td>
                                    <td>
                                        <form method="POST" action="/employees/{{ $e->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Del</button>
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

@section('scripts')
<script>
    async function loadCountries() {
        let res = await fetch("/countries");
        let data = await res.json();

        let select = document.getElementById("country");
        select.innerHTML = "<option>Select Country</option>";

        data.forEach(c => {
            select.innerHTML += `<option value="${c.country}">${c.country}</option>`;
        });
    }

    async function loadStates(country) {
        let res = await fetch("/states", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ country })
        });

        let states = await res.json();
        let select = document.getElementById("state");
        select.innerHTML = "<option>Select State</option>";

        states.forEach(s => {
            select.innerHTML += `<option value="${s.name}">${s.name}</option>`;
        });
    }

    async function loadCities(country, state) {
        let res = await fetch("/cities", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ country, state })
        });

        let cities = await res.json();
        let select = document.getElementById("city");
        select.innerHTML = "<option>Select City</option>";

        cities.forEach(c => {
            select.innerHTML += `<option>${c}</option>`;
        });
    }

    // INIT
    loadCountries();

    document.getElementById("country").addEventListener("change", e => {
        loadStates(e.target.value);
    });

    document.getElementById("state").addEventListener("change", e => {
        loadCities(
            document.getElementById("country").value,
            e.target.value
        );
    });
</script>
@endsection
