<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AppoinmentDetails;
use App\Models\PaymentInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    //constructor
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:list-payment', ['only' => ['index']]);
        $this->middleware('can:create-payment', ['only' => ['create', 'store']]);
        $this->middleware('can:edit-payment', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete-payment', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PaymentInfo::query();
        if (auth()->user()->hasRole('Patient')) {
            $query->where('patient_id', auth()->id());
        }
        // Apply filters
        if (!empty($request->phone)) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if (!empty($request->transaction_id)) {
            $query->where('transaction_id', 'like', '%' . $request->transaction_id . '%');
        }

        if (!is_null($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }
        // Order and paginate
        $paymentInfo = $query->orderBy('id', 'desc')->paginate(20);
        $filters = $request->only(['phone', 'transaction_id', 'payment_status']);

        return view('backend.pages.payment.index', compact('paymentInfo', 'filters'));
    }



    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        toast('This module is under construction', 'info');
        return redirect()->back();
        // $users = User::where('type', 'patient')->get();
        // return view('backend.pages.payment.create', compact('users'));
    }


    public function updateStatus(Request $request, $id)
    {
        $payment = PaymentInfo::findOrFail($id);
        $payment->payment_status = $request->status;
        $payment->save();

        if ($request->status != 3) {
            $appointment = AppoinmentDetails::findOrFail($payment->appoinment_id);
            $appointment->payment_status = $request->status;
            $appointment->save();
        }else{
            $appointment = AppoinmentDetails::findOrFail($payment->appoinment_id);
            $appointment->status = 3;
            $appointment->save();
        }

        toast('Payment status updated successfully', 'success');
        return redirect()->back();
    }
}
