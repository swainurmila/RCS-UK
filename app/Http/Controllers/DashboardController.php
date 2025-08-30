<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use App\Models\SocietyAppDetail;
use App\Models\Member;
use App\Models\SocietyRegistration;
use App\Models\SocietySectorType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function dashboard()
    {

        // dd(App::getLocale());

        $arr = [
            'total_society' => SocietyAppDetail::whereIn('status', [1, 2, 3])->count(),
            'pending_society' => SocietyAppDetail::where('status', 1)->count(),
            'rejected_society' => SocietyAppDetail::where('status', 2)->count(),
            'approved_society' => SocietyAppDetail::where('status', 3)->count(),
            'total_member' => Member::count(),
        ];

        $pendingPerMonth = SocietyAppDetail::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 1)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        // Fill missing months with 0
        $pendingData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendingData[] = $pendingPerMonth[$i] ?? 0;
        }

        // Get total society count per month
        $totalPerMonth = SocietyAppDetail::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        // Fill missing months with 0
        $totalData = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalData[] = $totalPerMonth[$i] ?? 0;
        }
        $totalPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
        ///implemtfilter
        $currentYear = date('Y');
        $currentMonth = date('m');
        $currenttotalPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $currentapprovedPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', 3)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('dashboard', compact('arr', 'pendingData', 'totalData', 'totalPerDay', 'currenttotalPerDay', 'currentapprovedPerDay'));
    }
    public function official_dashboard()
    {


        $arr = [
            'total_society' => SocietyAppDetail::whereIn('status', [1, 2, 3])->count(),
            'pending_society' => SocietyAppDetail::where('status', 1)->count(),
            'rejected_society' => SocietyAppDetail::where('status', 2)->count(),
            'approved_society' => SocietyAppDetail::where('status', 3)->count(),
            'total_member' => Member::count(),
        ];

        $pendingPerMonth = SocietyAppDetail::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 1)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        // Fill missing months with 0
        $pendingData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendingData[] = $pendingPerMonth[$i] ?? 0;
        }

        // Get total society count per month
        $totalPerMonth = SocietyAppDetail::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        // Fill missing months with 0
        $totalData = [];
        for ($i = 1; $i <= 12; $i++) {
            $totalData[] = $totalPerMonth[$i] ?? 0;
        }
        $totalPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();
        ///implemtfilter
        $currentYear = date('Y');
        $currentMonth = date('m');
        $currenttotalPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $currentapprovedPerDay = SocietyAppDetail::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', 3)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return view('official_dashboard', compact('arr', 'pendingData', 'totalData', 'totalPerDay', 'currenttotalPerDay', 'currentapprovedPerDay'));
    }
    public function getChartData(Request $request)
    {
        $currentYear = $request->year ?? date('Y'); // Default: Current Year
        $currentMonth = $request->month ?? date('m'); // Default: Current Month

        $currenttotalPerDay = SocietyAppDetail::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(*) as count")
            ->whereYear('created_at', $currentYear)
            ->when($request->month, fn($query) => $query->whereMonth('created_at', $currentMonth))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $currentapprovedPerDay = SocietyAppDetail::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date, COUNT(*) as count")
            ->whereYear('created_at', $currentYear)
            ->when($request->month, fn($query) => $query->whereMonth('created_at', $currentMonth))
            ->where('status', 3)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return response()->json([
            'total' => $currenttotalPerDay,
            'approved' => $currentapprovedPerDay
        ]);
    }

    public function switch(Request $request)
    {
        $request->validate(['lang' => 'required|in:en,hi']);


        Session::put('locale', $request->lang);

        return response()->json(['success' => true]);
    }

    public function all_dashboard()
    {
        return view('dashboard.maindashboard');
    }

    public function all_dashboard1()
    {
        $districts = District::orderBy('name', 'ASC')->get();
        $sectors = SocietySectorType::all();
        // Summary statistics
        $stats = [
            'submitted' => SocietyAppDetail::where('status', '>', 0)->count(),
            // 'submitted' => SocietyAppDetail::where('status', SocietyAppDetail::STATUS_UNDER_PROCESS)->count(),
            'approved' => SocietyAppDetail::where('status', SocietyAppDetail::STATUS_APPROVED)->count(),
            'reverted' => SocietyAppDetail::where('status', SocietyAppDetail::STATUS_REVERTED)->count(),
            'rejected' => SocietyAppDetail::where('status', SocietyAppDetail::STATUS_REJECTED)->count(),
            'under_review' => SocietyAppDetail::where('status', SocietyAppDetail::STATUS_UNDER_PROCESS)->count(),
        ];

        // Society distribution by type
        $societyTypes = [
            1 => SocietyAppDetail::whereHas('society_details', function ($q) {
                $q->where('society_category', 1);
            })->count(),

            2 => SocietyAppDetail::whereHas('society_details', function ($q) {
                $q->where('society_category', 2);
            })->count(),
            3 => SocietyAppDetail::whereHas('society_details', function ($q) {
                $q->where('society_category', 3);
            })->count(),
        ];
        $districtWiseCounts = District::withCount([
            'societyRegistrations as primary_count' => function ($q) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 1));
            },
            'societyRegistrations as central_count' => function ($q) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 2));
            },
            'societyRegistrations as apex_count' => function ($q) {
                $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 3));
            }
        ])->get();
        // Monthly application data
        $monthlyData = SocietyAppDetail::selectRaw('
            MONTH(created_at) as month, 
            SUM(CASE WHEN status >= 1 THEN 1 ELSE 0 END) as submitted,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as reverted,
            SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as under_review
        ')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare data for column chart
        $columnChartData = [
            'submitted' => [],
            'approved' => [],
            'reverted' => [],
            'rejected' => [],
            'under_review' => []
        ];

        // Fill data for all months (1-12)
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyData->firstWhere('month', $i);

            $columnChartData['submitted'][] = $monthData ? (int) $monthData->submitted : 0;
            $columnChartData['approved'][] = $monthData ? (int) $monthData->approved : 0;
            $columnChartData['reverted'][] = $monthData ? (int) $monthData->reverted : 0;
            $columnChartData['rejected'][] = $monthData ? (int) $monthData->rejected : 0;
            $columnChartData['under_review'][] = $monthData ? (int) $monthData->under_review : 0;
        }

        return view('dashboard', compact(
            'stats',
            'districts',
            'sectors',
            'societyTypes',
            'columnChartData',
            'districtWiseCounts'
        ));
    }

    // public function filter(Request $request)
    // {
    //     // dd($request);
    //     $query = SocietyAppDetail::query();

    //     // Apply filters
    //     if ($request->start_date && $request->end_date) {
    //         $query->whereBetween('created_at', [
    //             Carbon::parse($request->start_date)->startOfDay(),
    //             Carbon::parse($request->end_date)->endOfDay()
    //         ]);
    //     }

    //     if ($request->month) {
    //         $query->whereMonth('created_at', Carbon::parse($request->month)->month);
    //     }

    //     if ($request->year) {
    //         $query->whereYear('created_at', $request->year);
    //     }

    //     if ($request->district) {
    //         $query->where('district_id', $request->district);
    //     }

    //     if ($request->block) {
    //         $query->where('block_id', $request->block);
    //     }
    //     if ($request->society_type) {
    //         $query->whereHas('society_details', function ($q) use ($request) {
    //             $q->where('society_category', $request->society_type);
    //         });
    //     }


    //     if ($request->sector_type) {
    //         $query->whereHas('society_details', function ($q) use ($request) {
    //             $q->where('society_sector_type_id', $request->sector_type);
    //         });
    //     }


    //     // Get filtered stats
    //     $stats = [
    //         'submitted'     => (clone $query)->where('status', '>', 0)->count(),
    //         // 'submitted' => $query->clone()->where('status', SocietyAppDetail::STATUS_UNDER_PROCESS)->count(),
    //         'approved' => $query->clone()->where('status', SocietyAppDetail::STATUS_APPROVED)->count(),
    //         'reverted' => $query->clone()->where('status', SocietyAppDetail::STATUS_REVERTED)->count(),
    //         'rejected' => $query->clone()->where('status', SocietyAppDetail::STATUS_REJECTED)->count(),
    //         'under_review' => $query->clone()->where('status', SocietyAppDetail::STATUS_RECHECK)->count(),
    //     ];


    //     $districtWiseCounts = District::withCount([
    //         'societyRegistrations as primary_count' => function ($q) use ($request) {
    //             $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 1));
    //             if ($request->filled('district')) $q->where('district_id', $request->district);
    //             if ($request->filled('block')) $q->where('block_id', $request->block);
    //         },
    //         'societyRegistrations as central_count' => function ($q) use ($request) {
    //             $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 2));
    //             if ($request->filled('district')) $q->where('district_id', $request->district);
    //             if ($request->filled('block')) $q->where('block_id', $request->block);
    //         },
    //         'societyRegistrations as apex_count' => function ($q) use ($request) {
    //             $q->whereHas('society_details', fn($q2) => $q2->where('society_category', 3));
    //             if ($request->filled('district')) $q->where('district_id', $request->district);
    //             if ($request->filled('block')) $q->where('block_id', $request->block);
    //         },
    //     ])->get();

    //     $societyCounts = [
    //         'apex_total' => $districtWiseCounts->sum('apex_count'),
    //         'central_total' => $districtWiseCounts->sum('central_count'),
    //         'primary_total' => $districtWiseCounts->sum('primary_count'),
    //     ];
    //     // Get filtered pie chart data
    //     $pieChartData = [
    //         'series' => [
    //             (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 1))->count(),
    //             (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 2))->count(),
    //             (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 3))->count()
    //         ],
    //         'labels' => ["Primary", "Central", "Apex"]
    //     ];

    //     // Get filtered column chart data
    //     $monthlyData = $query->clone()
    //         ->selectRaw('
    //         MONTH(created_at) as month, 
    //         SUM(CASE WHEN status >= 1 THEN 1 ELSE 0 END) as submitted,
    //         SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as approved,
    //         SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as reverted,
    //         SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as rejected,
    //         SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as under_review
    //     ')
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();

    //     // Initialize with zeros for all months
    //     $columnChartData = [
    //         'submitted' => array_fill(0, 12, 0),
    //         'approved' => array_fill(0, 12, 0),
    //         'reverted' => array_fill(0, 12, 0),
    //         'rejected' => array_fill(0, 12, 0),
    //         'under_review' => array_fill(0, 12, 0)
    //     ];

    //     // Fill the actual data
    //     foreach ($monthlyData as $data) {
    //         $monthIndex = $data->month - 1;
    //         $columnChartData['submitted'][$monthIndex] = (int) $data->submitted;
    //         $columnChartData['approved'][$monthIndex] = (int) $data->approved;
    //         $columnChartData['reverted'][$monthIndex] = (int) $data->reverted;
    //         $columnChartData['rejected'][$monthIndex] = (int) $data->rejected;
    //         $columnChartData['under_review'][$monthIndex] = (int) $data->under_review;
    //     }

    //     return response()->json([
    //         'stats' => $stats,
    //         'districtWiseCounts' => $societyCounts,
    //         'pieChartData' => $pieChartData,
    //         'columnChartData' => [
    //             'submitted' => $columnChartData['submitted'],
    //             'approved' => $columnChartData['approved'],
    //             'reverted' => $columnChartData['reverted'],
    //             'rejected' => $columnChartData['rejected'],
    //             'under_review' => $columnChartData['under_review']
    //         ]
    //     ]);
    // }
    public function filter(Request $request)
{
    $query = SocietyAppDetail::query();

    // Apply filters
    if ($request->start && $request->end) {
        $query->whereBetween('created_at', [
            Carbon::parse($request->start)->startOfDay(),
            Carbon::parse($request->end)->endOfDay()
        ]);
    }

    if ($request->month) {
        $query->whereMonth('created_at', Carbon::parse($request->month)->month);
    }

    if ($request->year) {
        $query->whereYear('created_at', $request->year);
    }

    if ($request->district) {
        $query->where('district_id', $request->district);
    }

    if ($request->block) {
        $query->where('block_id', $request->block);
    }
 if ($request->society_type) {
            $query->whereHas('society_details', function ($q) use ($request) {
                $q->where('society_category', $request->society_type);
            });
        }


        if ($request->sector_type) {
            $query->whereHas('society_details', function ($q) use ($request) {
                $q->where('society_sector_type_id', $request->sector_type);
            });
        }

    // Get filtered stats
    $stats = [
        'submitted'     => (clone $query)->where('status', '>', 0)->count(),
        'approved'      => (clone $query)->where('status', SocietyAppDetail::STATUS_APPROVED)->count(),
        'reverted'      => (clone $query)->where('status', SocietyAppDetail::STATUS_REVERTED)->count(),
        'rejected'      => (clone $query)->where('status', SocietyAppDetail::STATUS_REJECTED)->count(),
        'under_review'  => (clone $query)->where('status', SocietyAppDetail::STATUS_RECHECK)->count(),
    ];

    // Prepare society counts based on filters
    $societyCounts = [
        'apex_total' => 0,
        'central_total' => 0,
        'primary_total' => 0,
    ];

    // Apply society type filter if selected
    if ($request->society_type) {
        $societyType = $request->society_type;
        
        // Only count the selected society type
        $countQuery = (clone $query)->whereHas('society_details', function($q) use ($societyType) {
            $q->where('society_category', $societyType);
        })->count();
        
        // Set the appropriate count based on society type
        switch($societyType) {
            case 1: // Primary
                $societyCounts['primary_total'] = $countQuery;
                break;
            case 2: // Central
                $societyCounts['central_total'] = $countQuery;
                break;
            case 3: // Apex
                $societyCounts['apex_total'] = $countQuery;
                break;
        }
    } else {
        // If no society type filter, show all counts
        $societyCounts = [
            'apex_total' => (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 3))->count(),
            'central_total' => (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 2))->count(),
            'primary_total' => (clone $query)->whereHas('society_details', fn($q) => $q->where('society_category', 1))->count(),
        ];
    }

    // Get filtered pie chart data
    $pieChartData = [
        'series' => [
            $societyCounts['primary_total'],
            $societyCounts['central_total'],
            $societyCounts['apex_total']
        ],
        'labels' => ["Primary", "Central", "Apex"]
    ];

    // Get filtered column chart data
    $monthlyData = $query->clone()
        ->selectRaw('
            MONTH(created_at) as month, 
            SUM(CASE WHEN status >= 1 THEN 1 ELSE 0 END) as submitted,
            SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as reverted,
            SUM(CASE WHEN status = 5 THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = 4 THEN 1 ELSE 0 END) as under_review
        ')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Initialize with zeros for all months
    $columnChartData = [
        'submitted' => array_fill(0, 12, 0),
        'approved' => array_fill(0, 12, 0),
        'reverted' => array_fill(0, 12, 0),
        'rejected' => array_fill(0, 12, 0),
        'under_review' => array_fill(0, 12, 0)
    ];

    // Fill the actual data
    foreach ($monthlyData as $data) {
        $monthIndex = $data->month - 1;
        $columnChartData['submitted'][$monthIndex] = (int) $data->submitted;
        $columnChartData['approved'][$monthIndex] = (int) $data->approved;
        $columnChartData['reverted'][$monthIndex] = (int) $data->reverted;
        $columnChartData['rejected'][$monthIndex] = (int) $data->rejected;
        $columnChartData['under_review'][$monthIndex] = (int) $data->under_review;
    }

    return response()->json([
        'stats' => $stats,
        'districtWiseCounts' => $societyCounts,
        'pieChartData' => $pieChartData,
        'columnChartData' => [
            'submitted' => $columnChartData['submitted'],
            'approved' => $columnChartData['approved'],
            'reverted' => $columnChartData['reverted'],
            'rejected' => $columnChartData['rejected'],
            'under_review' => $columnChartData['under_review']
        ]
    ]);
}
}
