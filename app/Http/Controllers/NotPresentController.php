<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class NotPresentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:not present view')->only('index', 'show');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            DB::statement("SET SQL_MODE=''");

            $startDate = $request->input('start_date') ?? date('Y-m-d');
            $endDate = $request->input('end_date') ?? date('Y-m-d');

            // Ambil semua karyawan aktif
            $employees = DB::table('employees')
                ->select(
                    'employees.id',
                    'employees.employee_id',
                    'employees.full_name',
                    'departments.department_name',
                    'branch_offices.name as branch_name'
                )
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                ->leftJoin('branch_offices', 'employees.branch_office_id', '=', 'branch_offices.id')
                ->where('employees.work_status', 'Active')
                ->get();

            // Ambil seluruh data absensi dalam rentang waktu
            $attendances = DB::table('attendances')
                ->select('employee_id', 'date', 'is_present', 'description')
                ->whereBetween('date', [$startDate, $endDate])
                ->get()
                ->groupBy(function ($item) {
                    return $item->employee_id . '|' . $item->date;
                });

            // Siapkan semua tanggal dalam rentang
            $allDates = $this->generateDateRange($startDate, $endDate);

            $data = [];
            foreach ($employees as $employee) {
                foreach ($allDates as $date) {
                    $key = $employee->id . '|' . $date;

                    if (isset($attendances[$key])) {
                        $attendance = $attendances[$key][0]; // satu hari satu record

                        // Jika tidak hadir, tampilkan
                        if ($attendance->is_present === 'No') {
                            $data[] = [
                                'id' => $employee->id,
                                'employee_id' => $employee->employee_id,
                                'full_name' => $employee->full_name,
                                'department_name' => $employee->department_name,
                                'branch_name' => $employee->branch_name,
                                'date' => $date,
                                'status' => $attendance->description,
                            ];
                        }
                        // jika hadir, lewati (tidak ditampilkan)
                    } else {
                        // Tidak ada record → Alpha
                        $data[] = [
                            'id' => $employee->id,
                            'employee_id' => $employee->employee_id,
                            'full_name' => $employee->full_name,
                            'department_name' => $employee->department_name,
                            'branch_name' => $employee->branch_name,
                            'date' => $date,
                            'status' => 'Alpha',
                        ];
                    }
                }
            }

            // Sort by date and name
            usort($data, function ($a, $b) {
                return $a['date'] <=> $b['date'] ?: strcmp($a['full_name'], $b['full_name']);
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('not-presents.index');
    }

    private function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $current = strtotime($startDate);
        $end = strtotime($endDate);

        while ($current <= $end) {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }
}
