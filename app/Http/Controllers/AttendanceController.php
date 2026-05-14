<?php

namespace App\Http\Controllers;

use App\Exports\TimesheeatExport;
use App\Models\Attendance;
use App\Http\Requests\{StoreAttendanceRequest, UpdateAttendanceRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attendance view')->only('index', 'show');
        $this->middleware('permission:attendance create')->only('create', 'store');
        $this->middleware('permission:attendance edit')->only('edit', 'update');
        $this->middleware('permission:attendance delete')->only('destroy');
    }

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
            $is_present = $request->query('is_present');
            $description = $request->query('description');
            $departementFilter = intval($request->query('departement'));

            $attendances = DB::table('attendances')
                ->leftJoin('employees', 'attendances.employee_id', '=', 'employees.id')
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                ->select(
                    'attendances.*',
                    'employees.full_name',
                    'departments.department_name'
                );
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

            if (isset($departementFilter) && !empty($departementFilter)) {
                if ($departementFilter != 'All') {
                    $attendances = $attendances->where('employees.department_id', $departementFilter);
                }
            }


            if (isset($is_present) && !empty($is_present)) {
                if ($is_present != 'All') {
                    $attendances = $attendances->where('attendances.is_present', $is_present);
                }
            }

            if (isset($description) && !empty($description)) {
                if ($description != 'All') {
                    $attendances = $attendances->where('attendances.description', $description);
                }
            }
            $attendances = $attendances->orderBy('attendances.id', 'DESC')->get();
            return Datatables::of($attendances)
                ->addColumn('employee', function ($row) {
                    return $row->full_name;
                })
                ->addColumn('action', 'attendances.include.action')
                ->toJson();
        }

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        return view('attendances.index', [
            'microFrom' => $microFrom,
            'microTo' => $microTo,
        ]);
    }


    public function detailPoint(Request $request)
    {
        $id = $request->input('id');
        $start_date = (int) $request->input('start_date');
        $end_date = (int) $request->input('end_date');
        $attendancesById = DB::table('attendances')
            ->where('attendances.employee_id', '=', $id)
            ->select('attendances.description', DB::raw('SUM(attendances.point) as total_point'))
            ->groupBy('attendances.description');
        $from = date("Y-m-d H:i:s", substr($start_date, 0, 10));
        $to = date("Y-m-d H:i:s", substr($end_date, 0, 10));
        $attendancesById = $attendancesById->whereBetween('date', [$from, $to]);
        $attendancesById = $attendancesById->get();
        return view('attendances.table', compact('attendancesById'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('file_attachment') && $request->file('file_attachment')->isValid()) {

            $path = storage_path('app/public/uploads/file_attachments/');
            $filename = $request->file('file_attachment')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('file_attachment')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['file_attachment'] = $filename;
        }

        Attendance::create($attr);

        return redirect()
            ->route('attendances.index')
            ->with('success', __('The attendance was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        $attendance->load('employee:id,full_name');

        return view('attendances.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $attendance->load('employee:id,bpjs_health_no');

        return view('attendances.edit', compact('attendance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attr = $request->validated();

        if ($request->file('file_attachment') && $request->file('file_attachment')->isValid()) {

            $path = storage_path('app/public/uploads/file_attachments/');
            $filename = $request->file('file_attachment')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('file_attachment')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old file_attachment from storage
            if ($attendance->file_attachment != null && file_exists($path . $attendance->file_attachment)) {
                unlink($path . $attendance->file_attachment);
            }

            $attr['file_attachment'] = $filename;
        }

        $attendance->update($attr);

        return redirect()
            ->route('attendances.index')
            ->with('success', __('The attendance was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        try {
            $path = storage_path('app/public/uploads/file_attachments/');

            if ($attendance->file_attachment != null && file_exists($path . $attendance->file_attachment)) {
                unlink($path . $attendance->file_attachment);
            }

            $attendance->delete();

            return redirect()
                ->route('attendances.index')
                ->with('success', __('The attendance was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('attendances.index')
                ->with('error', __("The attendance can't be deleted because it's related to another table."));
        }
    }

    public function exportAtten($start_date, $end_date, $departement, $is_present, $description)
    {
        $date = date('d-m-Y');
        $nameFile = 'Timesheet' . $date;
        return Excel::download(new TimesheeatExport($start_date, $end_date, $departement, $is_present, $description), $nameFile . '.xlsx');
    }

    public function printPdf($start_date, $end_date, $departement, $is_present, $description)
    {
        $attendances = DB::table('attendances')
            ->leftJoin('employees', 'attendances.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                'attendances.*',
                'employees.full_name',
                'departments.department_name'
            );
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($end_date, 0, 10));
            $attendances = $attendances->where('date', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $attendances = $attendances->where('date', '<=', $to);
        }

        if (isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date)) {
            $from = date("Y-m-d H:i:s", substr($start_date, 0, 10));
            $to = date("Y-m-d H:i:s", substr($end_date, 0, 10));
            $attendances = $attendances->whereBetween('date', [$from, $to]);
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $to = date('Y-m-d') . " 23:59:59";
            $attendances = $attendances->whereBetween('date', [$from, $to]);
        }

        if (isset($departement) && !empty($departement)) {
            if ($departement != 'All') {
                $attendances = $attendances->where('employees.department_id', $departement);
            }
        }

        if (isset($is_present) && !empty($is_present)) {
            if ($is_present != 'All') {
                $attendances = $attendances->where('attendances.is_present', $is_present);
            }
        }

        if (isset($description) && !empty($description)) {
            if ($description != 'All') {
                $attendances = $attendances->where('attendances.description', $description);
            }
        }
        $attendances = $attendances->orderBy('attendances.id', 'DESC')->get();
        $pdf = PDF::loadview('attendances.pdf', ['attendances' => $attendances]);
        return $pdf->download('Timesheet-Pdf');
    }
}
