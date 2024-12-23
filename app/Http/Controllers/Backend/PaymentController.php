<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $PaymentInfo = PaymentInfo::orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.payment.index', compact('PaymentInfo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('type', 'student')->orderBy('id', 'desc')->get();
        return view('backend.pages.payment.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'payment_by' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'payment_from' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'transaction_id' => 'required|string|max:100|unique:PaymentInfo,transaction_id',
            'discount' => 'nullable|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:completed,failed,cancelled',
        ]);

        try {
            DB::beginTransaction();
            $payment = PaymentInfo::create([
                'payment_by' => $request->payment_by,
                'course_id' => $request->course_id,
                'payment_from' => $request->payment_from,
                'phone' => $request->phone,
                'transaction_id' => $request->transaction_id,
                'discount' => $request->discount ?? 0.00,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);
            DB::commit();
            toast('Payment Created Successfully!', 'success');
            return redirect()->route('PaymentInfo.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentInfo $payment)
    {
        $users = User::where('type', 'patient')->orderBy('id', 'desc')->get();
        return view('backend.pages.payment.edit', compact('payment', 'users', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentInfo $payment)
    {
        $request->validate([
            'payment_by' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'payment_from' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'transaction_id' => 'required|string|max:100|unique:PaymentInfo,transaction_id,' . $payment->id,
            'discount' => 'nullable|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:completed,failed,cancelled',
        ]);

        try {
            DB::beginTransaction();
            $payment->update([
                'payment_by' => $request->payment_by,
                'course_id' => $request->course_id,
                'payment_from' => $request->payment_from,
                'phone' => $request->phone,
                'transaction_id' => $request->transaction_id,
                'discount' => $request->discount ?? 0.00,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);

            DB::commit();

            toast('Payment Updated Successfully!', 'success');
            return redirect()->route('PaymentInfo.index');
        } catch (\Exception $e) {
            DB::rollBack();
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentInfo $payment)
    {
        try {
            $payment->delete();
            toast('Payment Deleted Successfully!', 'success');
            return redirect()->route('PaymentInfo.index');
        } catch (\Exception $e) {
            toast('Something went wrong! Please try again.', 'error');
            return redirect()->back();
        }
    }
}
