<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('id', 'desc')->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Department::create($request->only('name', 'description'));

        return back()->with('success', 'Department added!');
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Department deleted.');
    }
}

