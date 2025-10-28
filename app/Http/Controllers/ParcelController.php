<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Branch;
use Session;

class ParcelController extends Controller
{
    /*public function index()
    {
        Controller::has_ability('View_Parcel');
        $data['parcels'] = Parcel::with(['fromBranch', 'toBranch'])->get();
        return view('parcels.index', $data);
    }*/

    public function index()
    {
         Controller::has_ability('View_Parcel');
        $parcels = Parcel::with(['fromBranch', 'toBranch'])->get();

        $statusCounts = [
            'ordered'    => Parcel::where('status', 0)->count(),
            'dispatched' => Parcel::where('status', 1)->count(),
            'delivered'  => Parcel::where('status', 2)->count(),
            'received'   => Parcel::where('status', 3)->count(),
            'returned'   => Parcel::where('status', 4)->count(),
        ];

        return view('parcels.index', compact('parcels', 'statusCounts'));
    }


    public function create()
    {
        Controller::has_ability('Create_Parcel');
        $data['branches'] = Branch::all();
        return view('parcels.create', $data);
    }

    /*public function store(Request $request)
    {
        Controller::has_ability('Create_Parcel');

        $this->validate($request, [
            'reference_number' => 'required|string|max:100|unique:parcels',
            'sender_name' => 'required|string',
            //'sender_address' => 'required|string',
            'sender_contact' => 'required|string',
            'recipient_name' => 'required|string',
            //'recipient_address' => 'required|string',
            'recipient_contact' => 'required|string',
            'type' => 'required|in:1,2',
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id',
           // 'weight' => 'required|string',
           // 'height' => 'required|string',
           // 'width' => 'required|string',
           // 'length' => 'required|string',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
           // 'price' => 'required|numeric',
        ]);

        Parcel::create($request->all());
        Session::flash('alert-success', 'Parcel has been created successfully.');
        return redirect('parcels');
    }*/
    public function store(Request $request)
    {
        Controller::has_ability('Create_Parcel');

        $this->validate($request, [
            'sender_name' => 'required|string',
            'sender_contact' => 'required|string',
            'recipient_name' => 'required|string',
            'recipient_contact' => 'required|string',
            'type' => 'required|in:1,2',
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
        ]);

        // Step 1: Get from_branch code
        $fromBranch = \App\Models\Branch::find($request->from_branch_id);
        $branchCode = strtoupper($fromBranch->branch_code);

        // Step 2: Get the last reference number starting with this branch code
        $lastParcel = \App\Models\Parcel::where('reference_number', 'like', $branchCode . '%')
                        ->orderBy('id', 'desc')
                        ->first();

        // Step 3: Extract the numeric part and increment
        if ($lastParcel) {
            $lastNumber = intval(substr($lastParcel->reference_number, strlen($branchCode)));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        // Step 4: Generate final reference number
        $referenceNumber = $branchCode . $newNumber;

        // Step 5: Save Parcel
        $parcel = new \App\Models\Parcel($request->all());
        $parcel->reference_number = $referenceNumber;
        $parcel->save();

        \Session::flash('alert-success', "Parcel created successfully with Ref #{$referenceNumber}");
        return redirect('parcels');
    }

   /* public function generateReference($branchId)
    {
        $branch = \App\Models\Branch::find($branchId);

        if (!$branch) {
            return response()->json(['error' => 'Invalid branch ID'], 404);
        }

        $branchCode = strtoupper($branch->branch_code);

        // Get last parcel reference for this branch
        $lastParcel = \App\Models\Parcel::where('reference_number', 'like', $branchCode . '%')
                        ->orderBy('id', 'desc')
                        ->first();

        if ($lastParcel) {
            $lastNumber = intval(substr($lastParcel->reference_number, strlen($branchCode)));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $referenceNumber = $branchCode . $newNumber;

        return response()->json(['reference_number' => $referenceNumber]);
    }
*/
    public function generateReference($branchId)
    {
        $branch = Branch::find($branchId);

        if (!$branch) {
            return response()->json(['error' => 'Invalid branch ID'], 404);
        }

        $branchCode = strtoupper($branch->branch_code);
        $lastParcel = Parcel::where('reference_number', 'like', $branchCode . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastParcel) {
            $lastNumber = intval(substr($lastParcel->reference_number, strlen($branchCode)));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $referenceNumber = $branchCode . $newNumber;

        //return response()->json(['reference_number' => $referenceNumber]);
        return response()->json(['reference_number' => $referenceNumber], 200, ['Content-Type' => 'application/json']);

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
