<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\DoctorInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::query();

        if (request()->has('name')) {
            $doctors->where('fname', 'like', '%' . request('name') . '%')
                ->orWhere('lname', 'like', '%' . request('name') . '%');
        }
        if (request()->has('phone')) {
            $doctors->where('phone', 'like', '%' . request('phone') . '%');
        }

        $doctors = $doctors->where('type', 'doctor')->orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::select('id', 'name')->get();
        $designations = Designation::select('id', 'name')->get();
        return view('backend.pages.doctor.create', compact('departments', 'designations'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255|unique:users',
            'password' => ['required', 'string', 'min:4', 'unique:users'],
            'confirm_password' => 'required|same:password',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'speciality' => 'required|string|max:55',
            'fee' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'type' => 'doctor',
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                // Delete old image if exists
                if ($user->image && file_exists(public_path('backend/assets/images/users/' . $user->image))) {
                    unlink(public_path('backend/assets/images/users/' . $user->image));
                }

                // Upload new image
                $image->move(public_path('backend/assets/images/users'), $imageName);
                $user->image = $imageName;
            }
            $user->save();

            if (!$user) {
                toast('User creation failed', 'error');
                return back();
            }

            $doctor = new DoctorInfo();
            $doctor->doctor_id = $user->id;
            $doctor->department_id = $request->department_id;
            $doctor->designation_id = $request->designation_id;
            $doctor->speciality = $request->speciality;
            $doctor->fee = $request->fee;
            $doctor->save();

            if (!$doctor) {
                toast('Doctor creation failed', 'error');
                return back();
            }
            $user->assignRole('Doctor');

            DB::commit();
            toast('Doctor registration successful', 'success');
            return redirect()->route('doctors.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Registration failed. Please try again.', 'error');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $doctor)
    {
        $departments = Department::select('id', 'name')->get();
        $designations = Designation::select('id', 'name')->get();
        return view('backend.pages.doctor.edit', compact('doctor', 'departments', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $doctor = DoctorInfo::where('doctor_id', $user->id)->firstOrFail();

        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:4|confirmed',
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'speciality' => 'required|string|max:55',
            'fee' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Update User Information
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            // Handle Image Upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();

                // Delete old image if exists
                if ($user->image && file_exists(public_path('backend/assets/images/users/' . $user->image))) {
                    unlink(public_path('backend/assets/images/users/' . $user->image));
                }

                // Upload new image
                $image->move(public_path('backend/assets/images/users'), $imageName);
                $user->image = $imageName;
            }
            $user->save();

            if (!$user) {
                toast('User update failed', 'error');
                return back();
            }

            // Update Doctor Information
            $doctor->department_id = $request->department_id;
            $doctor->designation_id = $request->designation_id;
            $doctor->speciality = $request->speciality;
            $doctor->fee = $request->fee;

            if (!$doctor->save()) {
                toast('Doctor information update failed', 'error');
                return back();
            }

            DB::commit();
            toast('Doctor profile updated successfully', 'success');
            return redirect()->route('doctors.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Update failed. Please try again.', 'error');
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $doctor)
    {
        try {
            DB::beginTransaction();

            $doctorInfo = DoctorInfo::where('doctor_id', $doctor->id)->firstOrFail();

            if ($doctor->image && File::exists(public_path('backend/assets/images/users/' . $doctor->image))) {
                File::delete(public_path('backend/assets/images/users/' . $doctor->image));
            }

            $doctorInfo->delete();
            $doctor->delete();

            DB::commit();
            toast('Doctor deleted successfully', 'success');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Doctor deletion failed', 'error');
            return back();
        }
    }
}
