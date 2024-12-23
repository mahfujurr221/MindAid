<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\PatientInfo;
use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // dd($request->all());
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
                Alert::error('Error', 'Password and confirm password not matched');
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
                    Alert::error('Error', 'User creation failed');
                    return back();
                }

                $patient = new PatientInfo();
                $patient->patient_id = $user->id;
                $patient->gender = $request->gender;
                $patient->age = $request->age;
                $patient->save();

                if (!$patient) {
                    Alert::error('Error', 'Patient creation failed');
                    return back();
                }
                //assign role
                $user->assignRole('Patient');
            }

            DB::commit();
            Auth::login($user);
            Alert::success('Success', 'Registration successful');
            return redirect()->route('website');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Registration failed. Please try again.');
            return back();
        }
    }
}
