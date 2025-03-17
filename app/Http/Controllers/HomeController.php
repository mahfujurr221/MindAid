<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\AppoinmentDetails;
use App\Models\Department;
use App\Models\Designation;
use App\Models\PaymentInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Zoom;

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
        $doctors = User::where('type', 'doctor')->take(4)->get();
        return view('frontend.layouts.includes.content', compact('aboutUs', 'doctors'));
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
        // $query = User::where('type', 'doctor');

        // // Apply filters if present
        // if ($request->filled('search')) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('fname', 'like', '%' . $request->search . '%')
        //             ->orWhere('lname', 'like', '%' . $request->search . '%')
        //             ->orWhere('email', 'like', '%' . $request->search . '%');
        //     });
        // }

        // if ($request->filled('department')) {
        //     $query->whereHas('doctorInfo.department', function ($q) use ($request) {
        //         $q->where('id', $request->department);
        //     });
        // }

        // if ($request->filled('designation')) {
        //     $query->whereHas('doctorInfo.designation', function ($q) use ($request) {
        //         $q->where('id', $request->designation);
        //     });
        // }

        // $doctors = $query->get();

        // // Fetch departments and designations for filters
        // $departments = Department::all();
        // $designations = Designation::all();

        // return view('frontend.pages.doctor', compact('doctors', 'departments', 'designations'));
        return view('frontend.pages.doctors');
    }

    public function showDoctorProfile()
    {
        // $doctor = User::with('doctorInfo.department', 'doctorInfo.designation')->where('type', 'doctor')->findOrFail($id);
        // return view('frontend.pages.doctor-profile', compact('doctor'));
        return view('frontend.pages.doctor-profile');
    }


    //appointment
    public function appointment()
    {
        // $appointments = AppoinmentDetails::where('patient_id', auth()->user()->id)->latest()->get();
        // return view('frontend.pages.appointment', compact('appointments'));
        return view('frontend.pages.appointment');
    }

    //favorites doctor
    public function favorites()
    {
        // $appointments = AppoinmentDetails::where('patient_id', auth()->user()->id)->latest()->get();
        // return view('frontend.pages.appointment', compact('appointments'));
        return view('frontend.pages.favorites');
    }


    //chat
    public function chat()
    {
        // $appointments = AppoinmentDetails::where('patient_id', auth()->user()->id)->latest()->get();
        // return view('frontend.pages.appointment', compact('appointments'));
        return view('frontend.pages.chat');
    }


    //book appointment
    public function bookAppointment()
    {
        // $doctor = User::find($doctor_id);
        // return view('frontend.pages.book-appointment', compact('doctor'));
        return view('frontend.pages.book-appointment');
    }


    public function storeSession(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:users,id',
            'appoinment_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'appoinment_note' => 'nullable|string|max:100',
        ]);

        // Store data in the session
        session([
            'appointment_data' => $request->all(),
        ]);
        // Redirect to the checkout page
        return redirect()->route('appointments.checkout');
    }

    public function checkout()
    {
        // $appointmentData = session('appointment_data');

        // if (!$appointmentData) {
        //     return redirect()->route('front.doctor')->with('error', 'No appointment data found!');
        // }

        // $doctor = User::find($appointmentData['doctor_id']);
        // return view('frontend.pages.checkout',compact('appointmentData', 'doctor'));

        return view('frontend.pages.checkout');
    }

    //due checkout

    public function dueCheckout($id)
    {
        $appointment = AppoinmentDetails::with('doctor.doctorInfo', 'paymentInfo')->findOrFail($id);

        if ($appointment->payment_status == 1) {
            toast('This appointment is already paid.', 'info');
            return redirect()->route('front.appointment');
        }

        $appointmentData = [
            'id' => $appointment->id,
            'amount' => $appointment->doctor->doctorInfo->fee,
            'phone' => $appointment->paymentInfo->phone,
            'appoinment_date' => $appointment->appoinment_date,
        ];

        $doctor = $appointment->doctor;
        return view('frontend.pages.due-checkout', compact('appointmentData', 'doctor'));
    }


    public function processPayment(Request $request)
    {
        // dd($request->all());
        $validation = $request->validate([
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'appoinment_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'appoinment_note' => 'nullable|string|max:100',
            'amount' => 'required|numeric',
            'phone' => 'required',
        ]);
        $appointmentStart = Carbon::parse($request->appoinment_date);
        $appointmentEnd = $appointmentStart->copy()->addMinutes($request->duration);

        // Check for overlapping appointments for the same doctor
        $conflict = AppoinmentDetails::where('doctor_id', $request->doctor_id)
            ->where(function ($query) use ($appointmentStart, $appointmentEnd) {
                $query->whereBetween('appoinment_date', [$appointmentStart, $appointmentEnd])
                    ->orWhereRaw('? BETWEEN appoinment_date AND DATE_ADD(appoinment_date, INTERVAL duration MINUTE)', [$appointmentStart]);
            })
            ->first();

        if ($conflict) {
            if ($conflict->payment_status != 2) {
                toast('Appointment time is not available!', 'error');
                return redirect()->route('front.book-appointment', ['doctor_id' => $request->doctor_id]);
            }
        }

        try {
            DB::beginTransaction();
        $meetingResponse = Zoom::createMeeting([
            "topic" => $request->appoinment_note ?? 'No Topic Provided',
            "type" => 2,
            "start_time" => Carbon::parse($request->appoinment_date)->format('Y-m-d\TH:i:s'),
            "duration" => $request->duration,
            "timezone" => 'Asia/Dhaka',
            "password" => '123456',
            "template_id" => '',
            "pre_schedule" => false,
            "schedule_for" => 'iconplusbd2024@gmail.com',
            "settings" => [
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => true,
                'waiting_room' => true,
                'audio' => 'both',
                'auto_recording' => 'none',
                'approval_type' => 0,
            ],
        ]);

        $meetingResponse = $meetingResponse['data'];

        $appointment = new AppoinmentDetails();
        $appointment->doctor_id = $request->doctor_id;
        $appointment->patient_id = $request->patient_id;
        $appointment->appoinment_date = $request->appoinment_date;
        $appointment->duration = $request->duration;
        $appointment->appoinment_note = $request->appoinment_note;
        $appointment->status = 0;
        $appointment->zoom_meeting_id = $meetingResponse['id'];
        $appointment->start_url = $meetingResponse['start_url'];
        $appointment->join_url = $meetingResponse['join_url'];
        $appointment->save();


        $payment = new PaymentInfo();
        $payment->appoinment_id = $appointment->id;
        $payment->patient_id = $appointment->patient_id;
        $payment->phone = $request->phone;
        $payment->amount = $request->amount;
        $payment->transaction_id = $request->transaction_id ?? '';
        // $payment->payment_status=0;

        if ($request->transaction_id=='') {
            $payment->payment_status = 2;
        } else {
            $payment->payment_status = 0;
        }

        $payment->save();

        $appointment->payment_status = $payment->payment_status;
        $appointment->transaction_id = $payment->transaction_id;
        $appointment->save();

        //session forget
        session()->forget('appointment_data');

        DB::commit();
        toast('Appointment Booked Successfully!', 'success');
        return redirect()->route('front.appointment');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something Went Wrong!', 'error');
            return back();
        }
    }


    //update due payment
    public function updatePayment(Request $request, $id)
    {
        // dd($request->all(), $id);
        // Validate input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'phone' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Find the appointment and its payment record
            $appointment = AppoinmentDetails::findOrFail($id);

            // dd($appointment);

            $payment = PaymentInfo::where('appoinment_id', $appointment->id)->first();

            if (!$payment) {
                toast('Payment record not found!', 'error');
                return back();
            }

            // Update payment record
            // $payment->update([
            //     'phone' => $request->phone,
            //     'amount' => $request->amount,
            //     'transaction_id' => 'PAY-' . uniqid(),
            //     'payment_status' => 1, // Mark as paid
            // ]);

            $payment->phone = $request->phone;
            $payment->amount = $request->amount;
            $payment->transaction_id = $request->transaction_id ?? '';
            $payment->payment_status = 0;
            $payment->save();

            // Update appointment status
            $appointment->update([
                'payment_status' => 1, // Mark as paid
                'transaction_id' => $payment->transaction_id,
            ]);

            DB::commit();

            toast('Payment updated successfully!', 'success');
            return redirect()->route('front.appointment');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something went wrong: ' . $e->getMessage(), 'error');
            return back();
        }
    }
}
