<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // If you have these controllers, keep creating them for counts
        // (they appear to provide helper methods like users_count())
        $userController = new UsersController;
        $branchController = new BranchController;

        // Determine month to display (format: YYYY-MM)
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $selectedMonth = Carbon::createFromFormat('Y-m', $month);

        // Date range for selected month
        $startOfMonth = $selectedMonth->copy()->startOfMonth();
        $endOfMonth = $selectedMonth->copy()->endOfMonth();

        // Status labels
        /*$statusLabels = [
            0 => 'Ordered',
            1 => 'Dispatched',
            2 => 'Delivered',
            3 => 'Received',
            4 => 'Returned'
        ];*/
        $statusLabels = [
            0 => 'Ordered',
            1 => 'Waiting',
            2 => 'Dispatched',
            3 => 'Delivered',
            4 => 'Received',
            5 => 'Returned'
        ];

        /*$statusCounts = [
            'booked'    => Parcel::where('status', 0)->count(),
            'waiting'   => Parcel::where('status', 1)->count(),
            'dispatched' => Parcel::where('status', 2)->count(),
            'delivered'  => Parcel::where('status', 3)->count(),
            'received'   => Parcel::where('status', 4)->count(),
            'returned'   => Parcel::where('status', 5)->count(),

        ];*/

        $statusCounts = [
            'booked'     => Parcel::where('status', 0)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
            'waiting'    => Parcel::where('status', 1)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
            'dispatched' => Parcel::where('status', 2)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
            'delivered'  => Parcel::where('status', 3)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
            'received'   => Parcel::where('status', 4)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
            'returned'   => Parcel::where('status', 5)
                                ->whereDate('created_at', Carbon::today())
                                ->count(),
        ];

        // Fetch parcel counts grouped by day and status
        $parcelData = Parcel::select(
                DB::raw('DAY(created_at) as day'),
                'status',
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('day', 'status')
            ->orderBy('day')
            ->get();

        $daysInMonth = $endOfMonth->day;
        $days = range(1, $daysInMonth);
        $chartData = [];

        // Initialize each status with zeros for all days
        foreach ($statusLabels as $statusName) {
            $chartData[$statusName] = array_fill(1, $daysInMonth, 0);
        }

        // Fill actual counts
        foreach ($parcelData as $row) {
            $statusName = $statusLabels[$row->status] ?? 'Unknown';
            $chartData[$statusName][$row->day] = $row->total;
        }

        // Convert keyed arrays to simple numeric arrays (for JSON)
        foreach ($chartData as $key => $values) {
            $chartData[$key] = array_values($values);
        }

        // Prepare response payload
        $response = [
            'currentMonth' => $selectedMonth->format('F Y'),
            'prevMonth' => $selectedMonth->copy()->subMonth()->format('Y-m'),
            'nextMonth' => $selectedMonth->copy()->addMonth()->format('Y-m'),
            'dates' => $days, // 1,2,3...
            'chartData' => $chartData,
        ];

        // If AJAX, return JSON only (front-end will update the chart)
        if ($request->ajax()) {
            return response()->json($response);
        }

        // For normal (initial) page render, pass the additional objects the blade expects
        $response['user'] = $userController;
        $response['branch'] = $branchController;
        $response['statusCounts'] = $statusCounts; 

        return view('home', $response);
    }
}
