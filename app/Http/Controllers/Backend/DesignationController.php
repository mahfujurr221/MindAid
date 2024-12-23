<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:list-designation', ['only' => ['index']]);
        $this->middleware('can:create-designation', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-designation', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-designation', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $designations = Designation::query();
        if ($request->name) {
            $designations->where('name', 'like', '%' . $request->name . '%');
        }
        $designations = $designations->orderBy('id', 'desc')->paginate(10);
        return view('backend.pages.designation.index', compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Designation::create($validated);

        toast('Designation created successfully!', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designation->update($validated);

        toast('Designation updated successfully!', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();

        toast('Designation deleted successfully!', 'success');
        return back();
    }
}
