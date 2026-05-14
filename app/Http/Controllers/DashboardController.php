<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $start_date = $request->query('start_date');
            $end_date = $request->query('end_date');

            $izinSakit = DB::table('izinsakits')
            ->select(
                DB::raw('count(*) as total'),
                DB::raw("sum(case when status = 'waiting' then 1 else 0 end) as waiting"),
                DB::raw("sum(case when status = 'approved' then 1 else 0 end) as approved"),
                DB::raw("sum(case when status = 'rejected' then 1 else 0 end) as rejected")
            );

            $attendanceRevisions = DB::table('attendance_revisions')
            ->select(
                DB::raw('count(*) as total'),
                DB::raw("sum(case when status = 'waiting' then 1 else 0 end) as waiting"),
                DB::raw("sum(case when status = 'approved' then 1 else 0 end) as approved"),
                DB::raw("sum(case when status = 'rejected' then 1 else 0 end) as rejected")
            );

            $leaveRequests = DB::table('leave_requests')
            ->select(
                DB::raw('count(*) as total'),
                DB::raw("sum(case when status = 'waiting' then 1 else 0 end) as waiting"),
                DB::raw("sum(case when status = 'approved' then 1 else 0 end) as approved"),
                DB::raw("sum(case when status = 'rejected' then 1 else 0 end) as rejected")
            );

            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $izinSakit = $izinSakit->where('date', '<=', $to);
                $attendanceRevisions = $attendanceRevisions->where('date', '<=', $to);
                $leaveRequests = $leaveRequests->where('start_date', '<=', $to);
                $leaveRequests = $leaveRequests->where('end_date', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $izinSakit = $izinSakit->where('date', '<=', $to);
                $attendanceRevisions = $attendanceRevisions->where('date', '<=', $to);
                $leaveRequests = $leaveRequests->where('start_date', '<=', $to);
                $leaveRequests = $leaveRequests->where('end_date', '<=', $to);
            }

            if (isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $izinSakit = $izinSakit->whereBetween('date', [$from, $to]);
                $attendanceRevisions = $attendanceRevisions->whereBetween('date', [$from, $to]);
                $leaveRequests = $leaveRequests->whereBetween('start_date', [$from, $to]);
                $leaveRequests = $leaveRequests->whereBetween('end_date', [$from, $to]);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $to = date('Y-m-d') . " 23:59:59";
                $izinSakit = $izinSakit->whereBetween('date', [$from, $to]);
                $attendanceRevisions = $attendanceRevisions->whereBetween('date', [$from, $to]);
                $leaveRequests = $leaveRequests->whereBetween('start_date', [$from, $to]);
                $leaveRequests = $leaveRequests->whereBetween('end_date', [$from, $to]);
            }
            return response()->json([
                'izinSakit' => $izinSakit->first(),
                'attendanceRevisions' => $attendanceRevisions->first(),
                'leaveRequests' => $leaveRequests->first(),
            ]);
        }

        $employeesEndContractLessThen90Days = DB::table('employees')
            ->select('full_name', 'end_contract_date')
            ->where('end_contract_date', '<=', date('Y-m-d', strtotime('+90 days')))
            ->orderBy('full_name', 'ASC')
            ->get();

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        return view('dashboard', [
            'microFrom' => $microFrom,
            'microTo' => $microTo,
            'employeesEndContractLessThen90Days' => $employeesEndContractLessThen90Days,
        ]);
    }
}
