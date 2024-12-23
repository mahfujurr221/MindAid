<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:list-department', ['only' => ['index']]);
        $this->middleware('can:create-department', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-department', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-department', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::query();
        if ($request->name) {
            $departments->where('name', 'like', '%' . $request->name . '%');
        }
        $departments = $departments->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.department.index', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Department::create($validated);

        toast('Department created successfully!', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department->update($validated);

        toast('Department updated successfully!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        toast('Department deleted successfully!', 'success');
        return back();
    }
}
