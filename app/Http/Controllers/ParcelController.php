<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Branch;

use App\Models\ParcelBatch;
use Illuminate\Support\Str;
use Session;

class ParcelController extends Controller
{
 
public function index(Request $request)
{
    Controller::has_ability('View_Parcel');

    // Get filter (today, week, month, year)
    $filter = $request->get('filter', 'today');
    $date = $request->get('date', today()->toDateString()); // default date = today

    $query = Parcel::with(['fromBranch', 'toBranch']);

    // Apply date filters
    switch ($filter) {
        case 'week':
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            break;
        case 'month':
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            break;
        case 'year':
            $query->whereYear('created_at', now()->year);
            break;
        case 'day':
        case 'today':
        default:
            $query->whereDate('created_at', $date);
            break;
    }

    $parcels = $query->orderBy('created_at', 'desc')->get();

    // Status counts (for the summary cards)
    $statusCounts = [
        'booked'    => Parcel::where('status', 0)->count(),
        'waiting'   => Parcel::where('status', 1)->count(),
        'dispatched' => Parcel::where('status', 2)->count(),
        'delivered'  => Parcel::where('status', 3)->count(),
        'received'   => Parcel::where('status', 4)->count(),
        'returned'   => Parcel::where('status', 5)->count(),

    ];

    return view('parcels.index', compact('parcels', 'statusCounts', 'filter', 'date'));
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




    public function showBatchDispatch()
    {
       // Controller::has_ability('View_Parcel');

        // Fetch only waiting parcels
        $waitingParcels = Parcel::where('status', 1)->with(['fromBranch', 'toBranch'])->get();

        return view('parcels.batch_dispatch', compact('waitingParcels'));
    }

    public function dispatchBatch(Request $request)
    {
      //  Controller::has_ability('Dispatch_Parcel');

        $this->validate($request, [
            'parcel_ids' => 'required|array',
            'parcel_ids.*' => 'exists:parcels,id',
        ]);

        // Generate unique batch number
        $batchNumber = 'BATCH-' . strtoupper(Str::random(6));

        // Create the batch record
        $batch = ParcelBatch::create([
            'batch_number' => $batchNumber,
            'dispatched_by' => auth()->user()->name ?? 'System',
            'dispatched_at' => now(),
        ]);

        // Attach parcels to the batch
        $batch->parcels()->attach($request->parcel_ids);

        // Update parcel statuses
        Parcel::whereIn('id', $request->parcel_ids)->update(['status' => 2]); // Dispatched

        Session::flash('alert-success', "Batch {$batchNumber} dispatched successfully.");
        return redirect()->route('parcels.index');
    }

    public function showBatchDetails($id)
    {
      //  Controller::has_ability('View_Parcel');

        $batch = \App\Models\ParcelBatch::with(['parcels.fromBranch', 'parcels.toBranch'])->findOrFail($id);

        return view('parcels.batch_details', compact('batch'));
    }

    /*public function listBatches()
    {
        Controller::has_ability('View_Parcel');

        $batches = \App\Models\ParcelBatch::withCount('parcels')
            ->orderBy('dispatched_at', 'desc')
            ->get();

        return view('parcels.batch_list', compact('batches'));
    }
*/
   public function listBatches(Request $request)
{
    Controller::has_ability('View_Parcel');

    $filter = $request->get('filter', 'today');
    $date = $request->get('date', today()->toDateString());

    $query = \App\Models\ParcelBatch::withCount('parcels');

    // Apply date filters
    switch ($filter) {
        case 'week':
            $query->whereBetween('dispatched_at', [now()->startOfWeek(), now()->endOfWeek()]);
            break;
        case 'month':
            $query->whereMonth('dispatched_at', now()->month)
                  ->whereYear('dispatched_at', now()->year);
            break;
        case 'year':
            $query->whereYear('dispatched_at', now()->year);
            break;
        case 'day':
        case 'today':
        default:
            $query->whereDate('dispatched_at', $date);
            break;
    }

    // ✅ Paginate and keep filter + date for next pages
    $batches = $query->orderBy('dispatched_at', 'desc')->paginate(10);
    $batches->appends([
        'filter' => $filter,
        'date' => $date,
    ]);

    return view('parcels.batch_list', compact('batches', 'filter', 'date'));
}


/*    public function listBatches(Request $request)
{
    Controller::has_ability('View_Parcel');

    $filter = $request->get('filter', 'today');
    $date = $request->get('date', today()->toDateString());

    $query = \App\Models\ParcelBatch::withCount('parcels');

    // Apply date filters
    switch ($filter) {
        case 'week':
            $query->whereBetween('dispatched_at', [now()->startOfWeek(), now()->endOfWeek()]);
            break;
        case 'month':
            $query->whereMonth('dispatched_at', now()->month)
                  ->whereYear('dispatched_at', now()->year);
            break;
        case 'year':
            $query->whereYear('dispatched_at', now()->year);
            break;
        case 'day':
        case 'today':
        default:
            $query->whereDate('dispatched_at', $date);
            break;
    }

    $batches = $query->orderBy('dispatched_at', 'desc')->get();

    return view('parcels.batch_list', compact('batches', 'filter', 'date'));
}
*/


}
