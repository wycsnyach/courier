<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentMode;
use App\Models\Parcel;
use Session;

class PaymentController extends Controller
{
    public function index()
    {
        Controller::has_ability('View_Payment');
        $data['payments'] = Payment::with(['parcel', 'paymentMode'])->get();
        return view('payments.index', $data);
    }

    public function create()
    {
        Controller::has_ability('Create_Payment');
        $data['paymentmodes'] = PaymentMode::all();
        $data['parcels'] = Parcel::all();
        return view('payments.create', $data);
    }

    public function store(Request $request)
    {
        Controller::has_ability('Create_Payment');

        $this->validate($request, [
            'parcel_id' => 'required|exists:parcels,id',
            'paymentmode_id' => 'required|exists:paymentmodes,id',
            'amount' => 'required|numeric',
            'transaction_reference' => 'nullable|string',
            'payment_date' => 'nullable|date',
        ]);

        Payment::create($request->all());
        Session::flash('alert-success', 'Payment has been created.');
        return redirect('payments');
    }

    public function edit($id)
    {
        Controller::has_ability('Edit_Payment');
        $data['payment'] = Payment::findOrFail($id);
        $data['paymentmodes'] = PaymentMode::all();
        $data['parcels'] = Parcel::all();
        return view('payments.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Controller::has_ability('Edit_Payment');

        $payment = Payment::findOrFail($id);

        $this->validate($request, [
            'amount' => 'required|numeric',
            'paymentmode_id' => 'required|exists:paymentmodes,id',
        ]);

        $payment->update($request->all());
        Session::flash('alert-success', 'Payment has been updated.');
        return redirect('payments');
    }

    public function destroy($id)
    {
        Controller::has_ability('Delete_Payment');
        Payment::findOrFail($id)->delete();
        Session::flash('alert-danger', 'Payment has been deleted.');
        return redirect('payments');
    }
}
