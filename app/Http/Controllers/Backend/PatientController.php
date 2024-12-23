<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PatientInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = User::query();

        if (request()->has('name')) {
            $patients->where('fname', 'like', '%' . request('name') . '%')
                ->orWhere('lname', 'like', '%' . request('name') . '%');
        }
        if (request()->has('phone')) {
            $patients->where('phone', 'like', '%' . request('phone') . '%');
        }

        $patients = $patients->where('type', 'patient')->orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.patient.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.patient.create');
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
            'gender' => 'required',
            'age' => 'required',
        ]);

        try {
            DB::beginTransaction();
            if ($request->password != $request->confirm_password) {
                toast('Password and confirm password not matched', 'error');
                return back();
            } else {
                $user = User::create([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'type' => 'patient',
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => bcrypt($request->password),
                ]);

                if (!$user) {
                    toast('User creation failed', 'error');
                    return back();
                }

                $patient = new PatientInfo();
                $patient->patient_id = $user->id;
                $patient->gender = $request->gender;
                $patient->age = $request->age;
                $patient->save();

                if (!$patient) {
                    toast('Patient creation failed', 'error');
                    return back();
                }
                //assign role
                $user->assignRole('Patient');
            }

            DB::commit();
            toast('Registration successful', 'success');
            return redirect()->route('patients.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Registration failed. Please try again.', 'error');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $patient)
    {
        return view('backend.pages.patient.edit', compact('patient'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $patient = PatientInfo::where('patient_id', $user->id)->firstOrFail();

        // Validate the incoming request
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:4|confirmed',
            'gender' => 'required|string|max:55',
            'age' => 'required|string|max:25',
        ]);

        try {
            DB::beginTransaction();
            // Update user details
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            if (!$user->save()) {
                toast('User update failed', 'error');
                return back();
            }

            // Update patient info
            $patient->gender = $request->gender;
            $patient->age = $request->age;

            if (!$patient->save()) {
                toast('Patient information update failed', 'error');
                return back();
            }

            DB::commit();
            toast('Profile updated successfully', 'success');
            return redirect()->route('patients.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Update failed. Please try again.', 'error');
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $patient)
    {
        try {
            DB::beginTransaction();
            $patientInfo = PatientInfo::where('patient_id', $patient->id)->firstOrFail();
            $patientInfo->delete();
            $patient->delete();
            DB::commit();
            toast('Patient deleted successfully', 'success');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Patient deletion failed', 'error');
            return back();
        }
    }
}
