<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employees.index', [
            'employees' => Employee::with('department')->get(),
            'departments' => Department::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'age'           => 'required|integer|min:18',
            'department_id' => 'required',
            'country'       => 'required',
            'state'         => 'required',
            'city'          => 'required'
        ]);

        Employee::create($request->all());

        return back()->with('success', 'Employee added!');
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return back()->with('success', 'Employee deleted.');
    }
}

