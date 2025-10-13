<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LogActivityController extends Controller
{
    //
     public function index()
        {         

        Controller::has_ability('View_LogActivity');

            // Fetch log activity with user info
            $logActivities = LogActivity::select('log_activities.*', 'u.first_name as firstname', 'u.last_name as lastname', 'u.middle_name as middlename')
                ->leftJoin('users as u', 'u.id', '=', 'log_activities.user_id')
                ->orderBy('log_activities.login_time', 'desc')
                ->get();

            // Get current month date range
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

            // Get daily login counts
            $dailyLogCounts = LogActivity::select(
                    DB::raw('DATE(login_time) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereBetween('login_time', [$startOfMonth, $endOfMonth])
                ->groupBy(DB::raw('DATE(login_time)'))
                ->orderBy('date')
                ->get()
                ->mapWithKeys(fn ($item) => [$item->date => $item->count])
                ->toArray();

            // Create date range and fill missing days
            $dates = collect(range(1, Carbon::now()->daysInMonth))->map(function ($day) {
                return Carbon::now()->startOfMonth()->addDays($day - 1)->toDateString();
            });

            // Prepare plot data
            $plotData = $dates->map(fn ($date) => $dailyLogCounts[$date] ?? 0);
            
            // Use only the day number for labels (1, 2, 3...)
            $plotLabels = $dates->map(fn ($date) => Carbon::parse($date)->day)->toArray();

            return view('logactivity.index', compact('logActivities', 'plotData', 'plotLabels'));
        }
}
