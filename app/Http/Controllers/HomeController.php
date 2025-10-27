<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //  Load other controller objects for counts
    $data['user'] = new UsersController; 
    $data['branch'] = new BranchController; 
    /*$data['supplier'] = new SupplierController;
    $data['product'] = new ProductController;
    $data['purchase'] = new PurchaseController;
    $data['color'] = new ColorController;
    $data['sale'] = new SaleController;*/

    // Prepare data for the chart (Current Month)
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    $statusLabels = [
        0 => 'Ordered',
        1 => 'Dispatched',
        2 => 'Delivered',
        3 => 'Received',
        4 => 'Returned'
    ];

    $parcelData = Parcel::select(
        DB::raw('DATE(created_at) as date'),
        'status',
        DB::raw('COUNT(*) as total')
    )
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->groupBy('date', 'status')
    ->orderBy('date')
    ->get();

    $dates = [];
    $chartData = [];

    foreach ($parcelData as $row) {
        $date = $row->date;
        $status = $statusLabels[$row->status] ?? 'Unknown';
        $dates[$date] = true;
        $chartData[$status][$date] = $row->total;
    }

    // Sort and fill missing dates
    $dates = array_keys($dates);
    sort($dates);

    foreach ($statusLabels as $status) {
        foreach ($dates as $date) {
            if (!isset($chartData[$status][$date])) {
                $chartData[$status][$date] = 0;
            }
        }
        ksort($chartData[$status]);
    }

    //  Pass everything to the view
    $data['dates'] = array_values($dates);
    $data['chartData'] = $chartData;

    return view('home', $data);
    }





    
}
