<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Helpers\GeolocationHelper;
use App\Helpers\ModelFileUploadHelper;
use App\Helpers\TokenHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiMobileAttendanceClockInRequest;
use App\Http\Requests\ApiMobileAttendanceClockIstirahatRequest;
use App\Http\Requests\ApiMobileAttendanceClockOutRequest;
use App\Http\Requests\ApiMobileAttendanceIzinOrSakitRequest;
use App\Http\Requests\ApiMobileAttendancePengajuanCutiRequest;
use App\Http\Requests\ApiMobileAttendancePengajuanRevisiAbsenRequest;
use App\Mail\EmailNotificationToCompanyWhenEmployeeDoPengajuanCuti;
use App\Models\Attendance;
use App\Models\AttendanceRevision;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Izinsakit;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AttendanceController extends Controller
{
    public function getHistoryPresence(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => Attendance::select(['id', 'date', 'is_present', 'description', 'created_at'])
                ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                    $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
                })
                ->where('employee_id', $employeeTokenObj->id)
                ->orderBy('created_at', 'DESC')
                ->simplePaginate(10)
        ], 200);
    }

    public function rankPoint(Request $request)
    {
        DB::statement("SET SQL_MODE=''");
        $query = DB::table('attendances')
            ->leftJoin('employees', 'attendances.employee_id', '=', 'employees.id')
            ->select('employees.full_name', 'employees.id', DB::raw('SUM(attendances.point) as total_point'))
            ->groupBy('attendances.employee_id')
            ->orderBy('total_point', 'DESC');

        // Paginate the results
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $data = $query->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $data
        ], 200);
    }

    public function getAllPengajuanIzinSakitCurrentEmployee(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        $dataPagination = Izinsakit::where('employee_id', $employeeTokenObj->id)
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
            })
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);

        $dataPagination->getCollection()->transform(function ($item) {
            if ($item->file_attachment) {
                $item->file_attachment = url('/storage/file-attachment/file-attachment/' . $item->file_attachment);
            }

            return $item;
        });

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $dataPagination
        ], 200);
    }

    public function getAllPengajuanCutiCurrentEmployee(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        $dataPagination = LeaveRequest::where('employee_id', $employeeTokenObj->id)
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
            })
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);

        $dataPagination->getCollection()->transform(function ($item) {
            if ($item->file_attachment) {
                $item->file_attachment = url('/storage/leave-request/file-attachment/' . $item->file_attachment);
            }

            return $item;
        });

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $dataPagination
        ], 200);
    }

    public function getAllPengajuanRevisiAbsenCurrentEmployee(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        $dataPagination = AttendanceRevision::where('employee_id', $employeeTokenObj->id)
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [$request->start_date . " 00:00:00", $request->end_date . " 23:59:59"]);
            })
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(10);

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $dataPagination
        ], 200);
    }

    public function getAllEmployeesTodayNotPresent(Request $request)
    {
        $date = date('Y-m-d');
        DB::statement("SET SQL_MODE=''");

        // Use the query builder to build the query
        $query = DB::table('employees')
            ->select('employees.full_name as employee_full_name', 'attendances.description')
            ->leftJoin('attendances', function ($join) use ($date) {
                $join->on('employees.id', '=', 'attendances.employee_id')
                    ->where('attendances.date', '=', $date);
            })
            ->where('attendances.is_present', '=', 'No')
            ->orWhereNull('attendances.employee_id');

        // Paginate the results
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $attendances = $query->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $attendances
        ], 200);
    }

    public function pengajuanCuti(ApiMobileAttendancePengajuanCutiRequest $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        if (LeaveRequest::where('employee_id', $employeeTokenObj->id)->where('status', 'Waiting')->first()) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Kesalahan Validasi",
                'error' => 'Anda masih memiliki permohonan cuti yang dalam status Menunggu'
            ], 422);
        }

        LeaveRequest::create([
            'employee_id' => $employeeTokenObj->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'file_attachment' => ModelFileUploadHelper::modelFileStore('leave_request', 'file_attachment', $request->file('file_attachment')),
            'status' => 'Waiting'
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, Permohonan Cuti telah dikirim',
        ], 200);
    }

    public function pengajuanRevisiAbsen(ApiMobileAttendancePengajuanRevisiAbsenRequest $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        if ($attendanceRevision = AttendanceRevision::where('employee_id', $employeeTokenObj->id)->whereIn('status', ['Waiting', 'Approved'])->where('date', $request->date)->first()) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Kesalahan Validasi",
                'error' => 'Anda telah mengajukan revisi kehadiran untuk tanggal ' . $request->date . ' dengan status ' . $attendanceRevision->status
            ], 422);
        }

        AttendanceRevision::create([
            'employee_id' => $employeeTokenObj->id,
            'date' => $request->date,
            'clock_in' => $request->clock_in,
            'masuk_istirahat' => $request->masuk_istirahat,
            'clock_out' => $request->clock_out,
            'reason' => $request->reason,
            'status' => 'Waiting',
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, Permohonan Revisi Kehadiran telah diajukan',
        ], 200);
    }

    public function getTodayPresence(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $data = Attendance::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->first() ?? [];
        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => $data
        ], 200);
    }

    public function getTodayIzinSakit(Request $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());

        return response()->json([
            'code' => 200,
            'msg' => 'OK',
            'data' => Izinsakit::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->orderBy('updated_at', 'DESC')->first()
        ], 200);
    }

    public function clockIn(ApiMobileAttendanceClockInRequest $request)
    {
        // logger('Received clock-in request', ['request_data' => $request->all()]);
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $employee = Employee::find($employeeTokenObj->id);
        $company = Company::first();

        // Validasi kecuali hari Minggu
        // if (date('N') == 7) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Anda tidak dapat melakukan clock-in pada hari Minggu",
        //     ], 422);
        // }

        // Cek hari libur
        $today = date('Y-m-d');
        $data = DB::table('offdays')->whereDate('date', $today)->first();

        // if ($data) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Hari libur: "  . $data->description,
        //     ], 422);
        // }

        if (strtotime(date('H:i:s')) < strtotime($company->start_clock_in)) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda hanya dapat clock-in mulai ' . $company->start_clock_in,
            ], 422);
        }

        if ($employee->use_gps_location == 'Yes') {
            $locations = DB::table('location_attendance_employee')
                ->join('gpslocations', 'location_attendance_employee.location_id', '=', 'gpslocations.id')
                ->where('location_attendance_employee.employee_id', $employee->id)
                ->get();

            $can = false;

            foreach ($locations as $location) {
                $distanceLatLng = GeolocationHelper::haversineGreatCircleDistance($request->latitude, $request->longitude, $location->latitude, $location->longitude);
                logger('Distance to location ', ['distance_in_meters' => $distanceLatLng, 'allowed_radius' => $location->radius]);
                if ($distanceLatLng <= $location->radius) {
                    $can = true;
                    break;
                }
            }

            if ($can == false) {
                return response()->json([
                    'code'  => 422,
                    'msg'   => 'Validasi Gagal',
                    'error' => 'Anda harus clock-in di area yang ditentukan',
                ], 422);
            }
        }

        if (Attendance::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->first()) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Data kehadiran sudah ada',
            ], 422);
        }

        $distanceMinuteAttendance = (strtotime(date('H:i:s')) - strtotime($company->start_clock_in)) / 60;

        $data = Attendance::create([
            'employee_id' => $employeeTokenObj->id,
            'date' => date('Y-m-d'),
            'clock_in' => date('H:i:s'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'file_attachment' => ModelFileUploadHelper::modelFileStore('file_attachment', 'file_attachment', $request->file('photo')),
            'is_present' => 'Yes',
            'description' => $distanceMinuteAttendance > $company->late_absence ? 'Terlambat' : 'Tepat Waktu',
            'point' => $distanceMinuteAttendance > $company->late_absence ? 3 : 5,
            'meal_allowance' => $employee->meal_allowance,
        ]);

        return response()->json([
            'code' => 200,
            'data' => $data,
            'msg' => 'Berhasil, Clock-In Berhasil'
        ], 200);
    }

    private function validateInAttendanceArea(Request $request, Employee $employee)
    {
        if ($employee->use_gps_location == 'No') {
            return;
        }

        $locations = DB::table('location_attendance_employee')
            ->join('gpslocations', 'location_attendance_employee.location_id', '=', 'gpslocations.id')
            ->where('location_attendance_employee.employee_id', $employee->id)
            ->get();

        foreach ($locations as $location) {
            $distanceLatLng = GeolocationHelper::haversineGreatCircleDistance($request->latitude, $request->longitude, $location->latitude, $location->longitude);
            if ($distanceLatLng <= $location->radius) {
                return;
            }
        }

        abort(response()->json([
            'code'  => 422,
            'msg'   => 'Validasi Gagal',
            'error' => 'Anda harus berada di area yang ditentukan untuk melakukan absensi',
        ], 422));
    }

    public function clockIstirahat(ApiMobileAttendanceClockIstirahatRequest $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        // if (date('N') == 7) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Anda tidak dapat absen masuk istirahat pada hari Minggu",
        //     ], 422);
        // }

        // Cek waktu untuk istirahat
        // $currentTime = date('H:i:s');
        // if (strtotime($currentTime) < strtotime('12:50:00')) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Anda hanya dapat absen masuk setelah 12:50",
        //     ], 422);
        // }

        // Cek hari libur
        $today = now()->toDateString();
        $data = DB::table('offdays')->whereDate('date', $today)->first();

        // if ($data) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Hari libur: "  . $data->description,
        //     ], 422);
        // }

        // Cek apakah sudah clock-in
        $attendance = Attendance::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->first();
        if (!$attendance) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda belum melakukan clock-in untuk kerja',
            ], 422);
        }

        // Cek apakah sudah clock-in untuk istirahat
        if ($attendance->clock_istirahat) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda sudah melakukan clock-in untuk istirahat',
            ], 422);
        }

        // Clock-in untuk istirahat
        $clockIstirahatTime = date('H:i:s');
        $statusIstirahat = strtotime($clockIstirahatTime) > strtotime('13:00:00') ? 'Terlambat' : 'Tepat waktu';

        $attendance->update([
            'clock_istirahat' => $clockIstirahatTime,
            'image_istirahat' => ModelFileUploadHelper::modelFileStore('image_istirahat', 'image_istirahat', $request->file('photo')),
            'description_istirahat' => $statusIstirahat,
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, Absen masuk istirahat',
        ], 200);
    }

    public function clockIstirahatOut(Request $request){
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $attendance = Attendance::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->first();

        if (!$attendance || !$attendance->clock_istirahat) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda belum melakukan clock-in untuk istirahat',
            ], 422);
        }

        if ($attendance->clock_istirahat_out) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda sudah melakukan clock-out untuk istirahat',
            ], 422);
        }

        $attendance->update([
            'clock_istirahat_out' => date('H:i:s'),
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, Absen keluar istirahat',
        ], 200);
    }

    public function clockOut(ApiMobileAttendanceClockOutRequest $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $company = Company::first();

        // Validasi kecuali hari Minggu
        // if (date('N') == 7) {
        //     return response()->json([
        //         'code'  => 422,
        //         'msg'   => "Validasi Gagal",
        //         'error' => "Anda tidak dapat clock-out pada hari Minggu",
        //     ], 422);
        // }

        // Cek hari libur
        $today = now()->toDateString();
        $data = DB::table('offdays')->whereDate('date', $today)->first();

        if ($data) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => "Hari libur: "  . $data->description,
            ], 422);
        }

        // Validasi waktu Clock-Out
        $current_time = strtotime(date('H:i:s'));
        $day_of_week = date('N');

        if ($day_of_week >= 1 && $day_of_week <= 5) {
            // Senin - Jumat
            if ($current_time < strtotime($company->start_clock_out)) {
                return response()->json([
                    'code'  => 422,
                    'msg'   => "Validasi Gagal",
                    'error' => 'Anda hanya dapat clock-out mulai ' . $company->start_clock_out,
                ], 422);
            }
        } elseif ($day_of_week == 6) {
            // Sabtu
            if ($current_time < strtotime($company->start_clock_out_saturday)) {
                return response()->json([
                    'code'  => 422,
                    'msg'   => "Validasi Gagal",
                    'error' => 'Anda hanya dapat clock-out mulai ' . $company->start_clock_out_saturday,
                ], 422);
            }
        }

        $employee = Employee::find($employeeTokenObj->id);
        $attendance = Attendance::where('date', date('Y-m-d'))->where('employee_id', $employeeTokenObj->id)->first();

        if (!$attendance) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda belum melakukan clock-in',
            ], 422);
        }

        // Validasi lokasi GPS (harus dalam area)
        $this->validateInAttendanceArea($request, $employee);

        // Validasi jika sudah melakukan clock-out
        if ($attendance->clock_out) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Validasi Gagal",
                'error' => 'Anda sudah melakukan clock-out',
            ], 422);
        }

        $clockOutMinuteAttendance = (strtotime(date('H:i:s')) - strtotime($company->start_clock_out)) / 60;

        $attendance->update([
            'selisih' => intval($clockOutMinuteAttendance),
            'activity' => $request->activity,
            'clock_out' => date('H:i:s'),
            'image_clock_out' => ModelFileUploadHelper::modelFileStore('image_clock_out', 'image_clock_out', $request->file('photo')),
        ]);

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, Clock-Out Berhasil'
        ], 200);
    }

    public function izinOrSakit(ApiMobileAttendanceIzinOrSakitRequest $request)
    {
        $employeeTokenObj = TokenHelper::decodeJWTBearerToken($request->bearerToken());
        $company = Company::first();
        $employee = Employee::find($employeeTokenObj->id);

        /**
         * Validasi kecuali hari Sabtu dan Minggu untuk kehadiran
         *
         */
        if (date('N') == 7) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Kesalahan Validasi",
                'error' => "Anda tidak bisa melakukan permintaan Izin/Sakit pada hari Minggu",
            ], 422);
        }

        // Jika sudah melakukan clock-in maka tolak
        if (Attendance::where('date', $request->date)->where('employee_id', $employeeTokenObj->id)->first()) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Kesalahan Validasi",
                'error' => 'Data sudah ada dalam kehadiran',
            ], 422);
        }

        // Jika sudah ada data izin sakit dimana statusnya waiting dan approved maka tolak
        if ($izinSakit = Izinsakit::where('date', $request->date)->where('employee_id', $employeeTokenObj->id)->whereIn('status', ['Waiting', 'Approved'])->first()) {
            return response()->json([
                'code'  => 422,
                'msg'   => "Kesalahan Validasi",
                'error' => 'Anda telah mengajukan permohonan ' . $izinSakit->description . ' pada tanggal ' . $request->date . ' dengan status ' . $izinSakit->status,
            ], 422);
        }

        $data = Izinsakit::create([
            'employee_id' => $employeeTokenObj->id,
            'date' => $request->date,
            'description' => $request->description,
            'detailed_description' => $request->detailed_description,
            'status' => 'Waiting',
            'file_attachment' => ModelFileUploadHelper::modelFileStore('file_attachment', 'file_attachment', $request->file('file_attachment')),
        ]);

        $data->type = 'Pengajuan ' . $request->description;
        $data->app_name = $company->app_name;
        $data->company_name = $company->company_name;
        if ($data->file_attachment) {
            $data->file_attachment = url('/storage/file_attachment/' . $data->file_attachment);
        }
        $data->employee_fullname = $employee->full_name;
        $data->employee_email = $employee->email;

        Mail::to($company->email_remainder_first)->send(new EmailNotificationToCompanyWhenEmployeeDoPengajuanCuti($data));
        Mail::to($company->email_remainder_second)->send(new EmailNotificationToCompanyWhenEmployeeDoPengajuanCuti($data));

        return response()->json([
            'code' => 200,
            'msg' => 'Berhasil, ' . $request->description . ' berhasil diajukan'
        ], 200);
    }
}
