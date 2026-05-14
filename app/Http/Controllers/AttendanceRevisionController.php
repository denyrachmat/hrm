<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRevision;
use App\Http\Requests\{StoreAttendanceRevisionRequest, UpdateAttendanceRevisionRequest};
use App\Mail\EmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class AttendanceRevisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attendance revision view')->only('index', 'show');
        $this->middleware('permission:attendance revision create')->only('create', 'store');
        $this->middleware('permission:attendance revision edit')->only('edit', 'update');
        $this->middleware('permission:attendance revision delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $attendanceRevisions =  DB::table('attendance_revisions')
                ->leftJoin('employees', 'attendance_revisions.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'attendance_revisions.user_review', '=', 'users.id')
                ->select(
                    'attendance_revisions.*',
                    'employees.full_name',
                    'users.name as reviewer_name'
                );
            $attendanceRevisions = $attendanceRevisions->orderBy('attendance_revisions.id', 'DESC')->get();
            return DataTables::of($attendanceRevisions)
                ->addColumn('reason', function ($row) {
                    return str($row->reason)->limit(100);
                })
                ->addColumn('employee', function ($row) {
                    return  $row->full_name;
                })->addColumn('action', 'attendance-revisions.include.action')
                ->toJson();
        }

        return view('attendance-revisions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance-revisions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRevisionRequest $request)
    {

        AttendanceRevision::create($request->validated());

        return redirect()
            ->route('attendance-revisions.index')
            ->with('success', __('The attendanceRevision was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendanceRevision  $attendanceRevision
     * @return \Illuminate\Http\Response
     */
    public function show(AttendanceRevision $attendanceRevision)
    {
        $attendanceRevision->load('employee:id,full_name');

        return view('attendance-revisions.show', compact('attendanceRevision'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendanceRevision  $attendanceRevision
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendanceRevision $attendanceRevision)
    {
        $attendanceRevision->load('employee:id,employee_id');

        return view('attendance-revisions.edit', compact('attendanceRevision'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendanceRevision  $attendanceRevision
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRevisionRequest $request, AttendanceRevision $attendanceRevision)
    {

        $attendanceRevision->update($request->validated());

        return redirect()
            ->route('attendance-revisions.index')
            ->with('success', __('The attendanceRevision was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendanceRevision  $attendanceRevision
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendanceRevision $attendanceRevision)
    {
        try {
            $attendanceRevision->delete();

            return redirect()
                ->route('attendance-revisions.index')
                ->with('success', __('The attendanceRevision was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('attendance-revisions.index')
                ->with('error', __("The attendanceRevision can't be deleted because it's related to another table."));
        }
    }

    public function approved(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('attendance_revisions')->find($request->id);

            // 2. cek ready or tidak di table absen
            $countAttendances = DB::table('attendances')
                ->where('employee_id', $pengajuan->employee_id)
                ->where('date', $pengajuan->date)
                ->count();
            if ($countAttendances > 0) {
                return redirect()
                    ->route('attendance-revisions.index')
                    ->with('error', __('Data already exist in Attendances'));
            }

            // 3. cek ready atw tidak di table attendance revisions
            $countAttendanceRevisions = DB::table('attendance_revisions')
                ->where('employee_id', $pengajuan->employee_id)
                ->where('date', $pengajuan->date)
                ->where('status', 'Approved')
                ->count();
            if ($countAttendanceRevisions > 0) {
                return redirect()
                    ->route('attendance-revisions.index')
                    ->with('error', __('Data already in attendance revisions with status Approved'));
            }

            // update status jadi approved
            $affectedRows = DB::table('attendance_revisions')
                ->where('id', $request->id)
                ->update([
                    'status' => 'Approved',
                    'note_review' => $request->catatan,
                    'user_review' => auth()->user()->id
                ]);
            if ($affectedRows) {
                // Ambil data perusahaan
                $company = DB::table('companies')->select('start_clock_in', 'start_clock_out_saturday', 'late_absence')->first();

                // Cek hari apa dari tanggal $pengajuan->date
                $dayOfWeek = date('N', strtotime($pengajuan->date)); // 1 = Senin, ..., 7 = Minggu

                // Tentukan waktu start clock yang akan digunakan
                if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Senin - Jumat
                    $startClockIn = $company->start_clock_in;
                } else { // Sabtu / minggu
                    $startClockIn = $company->start_clock_out_saturday;
                }

                // Hitung waktu batas toleransi (start_clock + late_absence)
                $lateAbsenceTime = date('H:i:s', strtotime($startClockIn) + ($company->late_absence * 60)); // late_absence dalam menit

                // Tentukan apakah terlambat
                $description = strtotime($pengajuan->clock_in) > strtotime($lateAbsenceTime) ? 'Terlambat' : 'Tepat Waktu';
                $descriptionIstirahat = strtotime($pengajuan->masuk_istirahat) > strtotime('13:00:00') ? 'Terlambat' : 'Tepat Waktu';
                $point = $description == 'Tepat Waktu' ? 5 : 3;

                // Insert ke table absen
                DB::table('attendances')->insert([
                    'employee_id' => $pengajuan->employee_id,
                    'date' => $pengajuan->date,
                    'is_present' => 'Yes',
                    'description' => $description, // Menggunakan hasil pengecekan
                    'description_istirahat' => $descriptionIstirahat,
                    'point' => $point,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                // send email to employee
                $employee = DB::table('employees')->find($pengajuan->employee_id);
                $company_name = DB::table('companies')->first()->company_name;
                $data = [
                    'type' => 'Attendance Revision',
                    'name' => $employee->full_name,
                    'date' => $pengajuan->date,
                    'status' => 'Approved',
                    'note' => $request->catatan,
                    'description' => 'Attendance Revision',
                    'detail_description' => $pengajuan->reason,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('attendance-revisions.index')
                    ->with('success', __('The attendance revision was Approved successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('attendance-revisions.index')
                ->with('error', $e->getMessage());
        }
    }

    public function rejected(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('attendance_revisions')->find($request->id);

            // update status jadi rejected
            $affectedRows = DB::table('attendance_revisions')
                ->where('id', $request->id)
                ->update(
                    [
                        'status' => 'Rejected',
                        'note_review' => $request->catatan,
                        'user_review' => auth()->user()->id
                    ]
                );

            if ($affectedRows) {
                // send email to employee
                $employee = DB::table('employees')->find($pengajuan->employee_id);
                $company_name = DB::table('companies')->first()->company_name;
                $data = [
                    'type' => 'Attendance Revision',
                    'name' => $employee->full_name,
                    'date' => $pengajuan->date,
                    'status' => 'Rejected',
                    'note' => $request->catatan,
                    'description' => 'Attendance Revision',
                    'detail_description' => $pengajuan->reason,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('attendance-revisions.index')
                    ->with('success', __('The attendance revision was Rejected successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('attendance-revisions.index')
                ->with('error', $e->getMessage());
        }
    }
}
