<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ranking view')->only('index', 'show');
    }

    public function index(Request $request)
    {

        if (request()->ajax()) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');
            $attendances = DB::table('attendances')
                ->leftJoin('employees', 'attendances.employee_id', '=', 'employees.id')
                ->select('employees.full_name', 'employees.id', DB::raw('SUM(attendances.point) as total_point'))
                ->groupBy('attendances.employee_id');
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $attendances = $attendances->where('date', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $attendances = $attendances->where('date', '<=', $to);
            }

            if (isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $attendances = $attendances->whereBetween('date', [$from, $to]);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $to = date('Y-m-d') . " 23:59:59";
                $attendances = $attendances->whereBetween('date', [$from, $to]);
            }

            $attendances = $attendances->orderBy('total_point', 'DESC')->get();
            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('employee', function ($row) {
                    return $row->full_name;
                })
                ->addColumn('total_point', function ($row) {
                    return $row->total_point . ' Points';
                })
                ->addColumn('action', 'rankings.include.action')
                ->toJson();
        }

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        return view('rankings.index', [
            'microFrom' => $microFrom,
            'microTo' => $microTo,
        ]);
    }
}
