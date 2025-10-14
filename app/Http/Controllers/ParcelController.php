<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Branch;
use Session;

class ParcelController extends Controller
{
    public function index()
    {
        Controller::has_ability('View_Parcel');
        $data['parcels'] = Parcel::with(['fromBranch', 'toBranch'])->get();
        return view('parcels.index', $data);
    }

    public function create()
    {
        Controller::has_ability('Create_Parcel');
        $data['branches'] = Branch::all();
        return view('parcels.create', $data);
    }

    public function store(Request $request)
    {
        Controller::has_ability('Create_Parcel');

        $this->validate($request, [
            'reference_number' => 'required|string|max:100|unique:parcels',
            'sender_name' => 'required|string',
            'sender_address' => 'required|string',
            'sender_contact' => 'required|string',
            'recipient_name' => 'required|string',
            'recipient_address' => 'required|string',
            'recipient_contact' => 'required|string',
            'type' => 'required|in:1,2',
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id',
            'weight' => 'required|string',
            'height' => 'required|string',
            'width' => 'required|string',
            'length' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Parcel::create($request->all());
        Session::flash('alert-success', 'Parcel has been created successfully.');
        return redirect('parcels');
    }

    public function edit($id)
    {
        Controller::has_ability('Edit_Parcel');
        $data['parcel'] = Parcel::findOrFail($id);
        $data['branches'] = Branch::all();
        return view('parcels.edit', $data);
    }

    public function update(Request $request, $id)
    {
        Controller::has_ability('Edit_Parcel');

        $parcel = Parcel::findOrFail($id);

        $this->validate($request, [
            'status' => 'nullable|integer',
        ]);

        $parcel->update($request->all());
        Session::flash('alert-success', 'Parcel has been updated successfully.');
        return redirect('parcels');
    }

    public function destroy($id)
    {
        Controller::has_ability('Delete_Parcel');
        Parcel::findOrFail($id)->delete();
        Session::flash('alert-danger', 'Parcel has been deleted.');
        return redirect('parcels');
    }
}
