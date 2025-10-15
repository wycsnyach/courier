<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Paymentmode;
use App\Models\Parcel;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Session;

class PaymentController extends Controller
{
    public function index()
    {
        Controller::has_ability('View_Payment');
        $data['payments'] = Payment::with(['parcel', 'paymentMode'])->get();
        return view('payments.index', $data);
    }

   /* public function create()
    {
        Controller::has_ability('Create_Payment');
        $data['paymentmodes'] = Paymentmode::all();
        $data['parcels'] = Parcel::where('status', '!=', 2)->get(); // Exclude delivered parcels
        return view('payments.create', $data);
    }*/

    public function create()
    {
        Controller::has_ability('Create_Payment');
        $data['paymentmodes'] = PaymentMode::all();
        
        // Only get parcels with Pending status (status = 0)
        $data['parcels'] = Parcel::where('status', 0)->get();
        
        return view('payments.create', $data);
    }

    public function store(Request $request)
    {
        Controller::has_ability('Create_Payment');

        $this->validate($request, [
            'parcel_id' => 'required|exists:parcels,id',
            'paymentmode_id' => 'required|exists:paymentmodes,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_reference' => 'nullable|string',
            'payment_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {
            // Get the parcel
            $parcel = Parcel::findOrFail($request->parcel_id);
            
            // Create the payment
            $payment = Payment::create($request->all());
            
            // Create payment history record
            PaymentHistory::create([
                'payment_id' => $payment->id,
                'amount_paid' => $request->amount,
                'payment_mode_id' => $request->paymentmode_id,
                'transaction_reference' => $request->transaction_reference,
                'payment_date' => $request->payment_date ?? now(),
                'notes' => 'Initial payment'
            ]);
            
            // Calculate total payments for this parcel
            $totalPaid = Payment::where('parcel_id', $parcel->id)->sum('amount');
            
            // Check if full payment is made
            if ($totalPaid >= $parcel->price) {
                // Update parcel status to "In Transit" (status = 1)
                $parcel->update(['status' => 1]);
                
                // Add note to payment history
                PaymentHistory::create([
                    'payment_id' => $payment->id,
                    'amount_paid' => 0, // This is just a status update record
                    'payment_mode_id' => $request->paymentmode_id,
                    'transaction_reference' => 'SYSTEM',
                    'payment_date' => now(),
                    'notes' => 'Full payment received. Parcel status updated to In Transit.'
                ]);
            }
        });

        Session::flash('alert-success', 'Payment has been created successfully.');
        return redirect('payments');
    }

    public function edit($id)
    {
        Controller::has_ability('Edit_Payment');
        $data['payment'] = Payment::findOrFail($id);
        $data['paymentmodes'] = Paymentmode::all();
        $data['parcels'] = Parcel::all();
        return view('payments.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Controller::has_ability('Edit_Payment');

        $payment = Payment::findOrFail($id);

        $this->validate($request, [
            'amount' => 'required|numeric|min:0.01',
            'paymentmode_id' => 'required|exists:paymentmodes,id',
        ]);

        $payment->update($request->all());
        Session::flash('alert-success', 'Payment has been updated.');
        return redirect('payments');
    }

    public function destroy($id)
    {
        Controller::has_ability('Delete_Payment');
        
        DB::transaction(function () use ($id) {
            $payment = Payment::findOrFail($id);
            $parcelId = $payment->parcel_id;
            
            // Delete payment histories first
            PaymentHistory::where('payment_id', $id)->delete();
            
            // Delete the payment
            $payment->delete();
            
            // Recalculate parcel status
            $this->updateParcelStatus($parcelId);
        });
        
        Session::flash('alert-danger', 'Payment has been deleted.');
        return redirect('payments');
    }

    public function getParcelPrice($parcel_id)
    {
        $parcel = Parcel::find($parcel_id);
        
        if ($parcel) {
            // Calculate remaining amount
            $totalPaid = Payment::where('parcel_id', $parcel_id)->sum('amount');
            $remaining = $parcel->price - $totalPaid;
            
            return response()->json([
                'success' => true,
                'price' => $parcel->price,
                'total_paid' => $totalPaid,
                'remaining' => max(0, $remaining),
                'status' => $parcel->status,
                'status_text' => $parcel->status_text
            ]);
        }
        
        return response()->json([
            'success' => false,
            'price' => 0,
            'total_paid' => 0,
            'remaining' => 0
        ]);
    }

    public function paymentHistory($payment_id)
    {
        Controller::has_ability('View_Payment');
        $payment = Payment::with(['parcel', 'paymentMode', 'histories'])->findOrFail($payment_id);
        return view('payments.history', compact('payment'));
    }

    /**
     * Update parcel status based on payments
     */
    private function updateParcelStatus($parcelId)
    {
        $parcel = Parcel::find($parcelId);
        if ($parcel) {
            $totalPaid = Payment::where('parcel_id', $parcelId)->sum('amount');
            
            if ($totalPaid >= $parcel->price) {
                $parcel->update(['status' => 1]); // In Transit
            } else {
                $parcel->update(['status' => 0]); // Back to Pending
            }
        }
    }
}