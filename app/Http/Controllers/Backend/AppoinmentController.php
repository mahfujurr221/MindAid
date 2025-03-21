<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppoinmentDetails;
use App\Models\PrescriptionInfo;
use App\Models\TestInfo;
use App\Models\User;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jubaer\Zoom\Zoom as ZoomZoom;
use Zoom;


class AppoinmentController extends Controller
{
    //constructor
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:list-appointment', ['only' => ['index']]);
        $this->middleware('can:create-appointment', ['only' => ['createMeeting', 'create']]);
        $this->middleware('can:edit-appointment', ['only' => ['edit', 'updateMeeting']]);
        $this->middleware('can:delete-appointment', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $appointments = AppoinmentDetails::query();
        if ($request->appointment_id) {
            $appointments = $appointments->where('id', $request->appointment_id);
        }
        if ($request->note) {
            $appointments = $appointments->where('note', 'like', '%' . $request->note . '%');
        }
        if ($request->start_date) {
            $appointments = $appointments->where('start_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $appointments = $appointments->where('end_date', '<=', $request->end_date);
        }
        if ($request->status !== null) { 
            $appointments = $appointments->where('status', $request->status);
        }
        if ($request->doctor_id) {
            $appointments = $appointments->where('doctor_id', $request->doctor_id);
        }
        if ($request->patient_id) {
            $appointments = $appointments->where('patient_id', $request->patient_id);
        }
        if (auth()->user()->hasRole('Doctor')) {
            $appointments = $appointments->where('doctor_id', auth()->id());
        } elseif (auth()->user()->hasRole('Patient')) {
            $appointments = $appointments->where('patient_id', auth()->id());
        }
        $appointments = $appointments->orderBy('id', 'desc')->where('status', '!=', '3')->paginate(10);
        return view('backend.pages.appointment.index', compact('appointments'));
    }

    //canceled appointments
    public function canceledAppointments(Request $request)
    {
        $appointments = AppoinmentDetails::query();
        if ($request->appointment_id) {
            $appointments = $appointments->where('id', $request->appointment_id);
        }
        if ($request->note) {
            $appointments = $appointments->where('note', 'like', '%' . $request->note . '%');
        }
        if ($request->start_date) {
            $appointments = $appointments->where('start_date', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $appointments = $appointments->where('end_date', '<=', $request->end_date);
        }
        if ($request->doctor_id) {
            $appointments = $appointments->where('doctor_id', $request->doctor_id);
        }
        if ($request->patient_id) {
            $appointments = $appointments->where('patient_id', $request->patient_id);
        }
        if (auth()->user()->hasRole('Doctor')) {
            $appointments = $appointments->where('doctor_id', auth()->id());
        } elseif (auth()->user()->hasRole('Patient')) {
            $appointments = $appointments->where('patient_id', auth()->id());
        }
        $appointments = $appointments->orderBy('id', 'desc')->where('status', '3')->paginate(10);
        return view('backend.pages.appointment.canceled', compact('appointments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::where('type', 'doctor')->orderBy('id', 'desc')->get();
        $patients = User::where('type', 'patient')->orderBy('id', 'desc')->get();
        return view('backend.pages.appointment.create', compact('doctors', 'patients'));
    }

    /**
     * Store a newly created resource in storage using Zoom meeting.
     */
    public function createMeeting(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'appoinment_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'appoinment_note' => 'nullable|string|max:100',
            'comment' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            // Create the Zoom meeting
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

            // Create the appointment
            $appointment = AppoinmentDetails::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
                'appoinment_date' => $request->appoinment_date,
                'duration' => $request->duration,
                'appoinment_note' => $request->appoinment_note,
                'comment' => $request->comment ?? '',
                'status' => '0',
                'zoom_meeting_id' => $meetingResponse['id'],
                'start_url' => $meetingResponse['start_url'],
                'join_url' => $meetingResponse['join_url'],
            ]);

            DB::commit();

            toast('Appointment created successfully!', 'success');
            if ($request->has('from')) {
                // return redirect()->route('checkout');
                Alert::success('Success', 'Appointment created successfully!');
                return redirect()->route('front.appointment');
            }
            return redirect()->route('appointments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $appointment = AppoinmentDetails::findOrFail($id);
        return view('backend.pages.appointment.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'appoinment_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'appoinment_note' => 'nullable|string|max:100',
            'comment' => 'nullable|string|max:255',
        ]);

        $appointment = AppoinmentDetails::findOrFail($id);

        try {
            DB::beginTransaction();
            $meetingResponse = Zoom::deleteMeeting($appointment->zoom_meeting_id);

            if ($meetingResponse['status'] == true) {
                $meetingResponse = Zoom::createMeeting([
                    "topic" => $request->appoinment_note ?? 'No Topic Provided',
                    "type" => 2,
                    "start_time" => Carbon::parse($request->start_time)->format('Y-m-d\TH:i:s'),
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
            }
            $meetingResponse = $meetingResponse['data'];
            // dd($meetingResponse);

            $appointment->update([
                'appoinment_date' => $request->appoinment_date,
                'duration' => $request->duration,
                'appoinment_note' => $request->appoinment_note,
                'comment' => $request->comment,
                'zoom_meeting_id' => $meetingResponse['id'],
                'start_url' => $meetingResponse['start_url'],
                'join_url' => $meetingResponse['join_url'],
            ]);

            DB::commit();

            toast('Appointment updated successfully!', 'success');
            return redirect()->route('appointments.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $appointment = AppoinmentDetails::findOrFail($id);
            //delete all tests and prescriptions related to this appointment

            $appointment->tests()->delete();
            $appointment->prescriptions()->delete();

            $appointment->delete();
            toast('Appointment deleted successfully!', 'success');
            return redirect()->route('appointments.index');
        } catch (\Exception $e) {
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $meeting = AppoinmentDetails::findOrFail($id);
        if ($request->status == '2') {
            $zoom = Zoom::endMeeting($meeting->zoom_meeting_id);
            if ($zoom) {
                $meeting->status = '2';
                $meeting->save();
                toast('Meeting Ended Successfully!', 'success');
                return back();
            }
        } else {
            $meeting->status = $request->status;
            $meeting->save();
            toast('Meeting Started Successfully!', 'success');
            return back();
        }
    }

    //Store Test 
    public function storeTest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'appointment_id' => 'required|exists:appoinment_details,id',
            'test_name' => 'required|string|max:255',
            'test_result' => 'nullable|string|max:255',
            'test_note' => 'nullable|string|max:255',
            'test_link' => 'nullable|url',
        ]);

        TestInfo::create([
            'appoinment_id' => $request->appointment_id,
            'test_name' => $request->test_name,
            'test_result' => $request->test_result,
            'test_note' => $request->test_note,
            'test_link' => $request->test_link,
            'date' => now(),
        ]);

        toast('Test added successfully!', 'success');
        return redirect()->back();
    }

    //Store Prescription
    public function storePrescription(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'prescription_link' => 'nullable|url',
            'description' => 'required|string|max:255',
        ]);

        PrescriptionInfo::create([
            'appoinment_id' => $request->appointment_id,
            'prescription_link' => $request->prescription_link,
            'description' => $request->description,
            'date' => now(),
            'status' => 1,
        ]);

        toast('Prescription added successfully!', 'success');
        return redirect()->back();
    }


    public function showPrescriptions($appointmentId)
    {
        $appointment = AppoinmentDetails::with('prescriptions')->findOrFail($appointmentId);

        return view('backend.pages.appointment.files.prescription', compact('appointment'));
    }

    public function showTests($appointmentId)
    {
        $appointment = AppoinmentDetails::with('tests')->findOrFail($appointmentId);

        return view('backend.pages.appointment.files.test', compact('appointment'));
    }
}
