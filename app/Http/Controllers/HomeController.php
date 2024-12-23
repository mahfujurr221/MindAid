<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\AppoinmentDetails;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('backend.pages.dashboard');
    }

    public function front_index()
    {
        $aboutUs = About::select('id', 'title', 'sub_title', 'short_description', 'description', 'about_course_desc')->first();
        $doctors=User::where('type','doctor')->take(4)->get();
        return view('frontend.layouts.includes.content', compact('aboutUs','doctors'));
    }

    public function about()
    {
        $aboutUs = About::select('title', 'sub_title', 'short_description', 'description', 'about_course_desc')->first();
        return view('frontend.pages.about', compact('aboutUs'));
    }
  

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function doctor(Request $request)
{
    $query = User::where('type', 'doctor');

    // Apply filters if present
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('fname', 'like', '%' . $request->search . '%')
                ->orWhere('lname', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('department')) {
        $query->whereHas('doctorInfo.department', function ($q) use ($request) {
            $q->where('id', $request->department);
        });
    }

    if ($request->filled('designation')) {
        $query->whereHas('doctorInfo.designation', function ($q) use ($request) {
            $q->where('id', $request->designation);
        });
    }

    $doctors = $query->get();

    // Fetch departments and designations for filters
    $departments = Department::all();
    $designations = Designation::all();

    return view('frontend.pages.doctor', compact('doctors', 'departments', 'designations'));
}


    //appointment
    public function appointment()
    {
        $appointments = AppoinmentDetails::where('patient_id', operator: auth()->user()->id)->get();
        return view('frontend.pages.appointment', compact('appointments'));
    }

}
