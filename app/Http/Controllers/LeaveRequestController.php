<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Http\Requests\{StoreLeaveRequestRequest, UpdateLeaveRequestRequest};
use App\Mail\EmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Image;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:leave request view')->only('index', 'show');
        $this->middleware('permission:leave request create')->only('create', 'store');
        $this->middleware('permission:leave request edit')->only('edit', 'update');
        $this->middleware('permission:leave request delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $leaveRequests = DB::table('leave_requests')
                ->leftJoin('employees', 'leave_requests.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'leave_requests.user_review', '=', 'users.id')
                ->select(
                    'leave_requests.*',
                    'employees.full_name',
                    'users.name as reviewer_name'
                );
            $leaveRequests = $leaveRequests->orderBy('leave_requests.id', 'DESC')->get();
            return Datatables::of($leaveRequests)
                ->addColumn('reason', function ($row) {
                    return str($row->reason)->limit(100);
                })
                ->addColumn('employee', function ($row) {
                    return $row->full_name;
                })
                ->addColumn('action', 'leave-requests.include.action')
                ->toJson();
        }

        return view('leave-requests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave-requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLeaveRequestRequest $request)
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

        LeaveRequest::create($attr);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', __('The leaveRequest was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LeaveRequest $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load('employee:id,employee_id');

        return view('leave-requests.show', compact('leaveRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LeaveRequest $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load('employee:id,employee_id');

        return view('leave-requests.edit', compact('leaveRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LeaveRequest $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLeaveRequestRequest $request, LeaveRequest $leaveRequest)
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
            if ($leaveRequest->file_attachment != null && file_exists($path . $leaveRequest->file_attachment)) {
                unlink($path . $leaveRequest->file_attachment);
            }

            $attr['file_attachment'] = $filename;
        }

        $leaveRequest->update($attr);

        return redirect()
            ->route('leave-requests.index')
            ->with('success', __('The leaveRequest was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LeaveRequest $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $path = storage_path('app/public/uploads/file_attachments/');

            if ($leaveRequest->file_attachment != null && file_exists($path . $leaveRequest->file_attachment)) {
                unlink($path . $leaveRequest->file_attachment);
            }

            $leaveRequest->delete();

            return redirect()
                ->route('leave-requests.index')
                ->with('success', __('The leaveRequest was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('leave-requests.index')
                ->with('error', __("The leaveRequest can't be deleted because it's related to another table."));
        }
    }

    public function approved(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('leave_requests')->find($request->id);

            // 2. cek ready or tidak di table absen
            $attendance = DB::table('attendances')
                ->where('employee_id', $pengajuan->employee_id)
                ->whereBetween('date', [$pengajuan->start_date, $pengajuan->end_date])
                ->first();

            if ($attendance) {
                return redirect()
                    ->route('leave-requests.index')
                    ->with('error', __('Data with date ' . $attendance->date . ' already exist in Attendances'));
            }

            // 3. cek ready atw tidak di table leave requests
            $countLeaveRequests = DB::table('leave_requests')
                ->where('id', $request->id)
                ->where('status', 'Approved')
                ->count();
            if ($countLeaveRequests > 0) {
                return redirect()
                    ->route('leave-requests.index')
                    ->with('error', __('Data already in leave requests with status Approved'));
            }

            // update status jadi approved
            $affectedRows = DB::table('leave_requests')
                ->where('id', $request->id)
                ->update(
                    [
                        'status' => 'Approved',
                        'note_review' => $request->catatan,
                        'user_review' => auth()->user()->id
                    ]
                );
            if ($affectedRows) {
                // insert ke table absen
                $dates = \Carbon\CarbonPeriod::create($pengajuan->start_date, $pengajuan->end_date);
                $employee = DB::table('employees')->where('id', $pengajuan->employee_id)->first();
                $mealAllowance = $employee->meal_allowance;

                foreach ($dates as $date) {
                    if ($date->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
                        DB::table('attendances')->insert([
                            'employee_id' => $pengajuan->employee_id,
                            'date' => $date->format('Y-m-d'),
                            'file_attachment' => $pengajuan->file_attachment,
                            'is_present' => 'No',
                            'description' =>  'Cuti',
                            'point' => 5,
                            'meal_allowance' => $mealAllowance,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }

                // send email to employee
                $employee = DB::table('employees')->find($pengajuan->employee_id);
                $company_name = DB::table('companies')->first()->company_name;
                $data = [
                    'type' => 'Leave Request',
                    'name' => $employee->full_name,
                    'start_date' => $pengajuan->start_date,
                    'end_date' => $pengajuan->end_date,
                    'status' => 'Approved',
                    'note' => $request->catatan,
                    'description' => 'Leave Request',
                    'detail_description' => $pengajuan->reason,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('leave-requests.index')
                    ->with('success', __('The attendance revision was Approved successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('leave-requests.index')
                ->with('error', $e->getMessage());
        }
    }

    public function rejected(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('leave_requests')->find($request->id);

            // update status jadi Rejected
            $affectedRows = DB::table('leave_requests')
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
                    'type' => 'Leave Request',
                    'name' => $employee->full_name,
                    'start_date' => $pengajuan->start_date,
                    'end_date' => $pengajuan->end_date,
                    'status' => 'Rejected',
                    'note' => $request->catatan,
                    'description' => 'Leave Request',
                    'detail_description' => $pengajuan->reason,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('leave-requests.index')
                    ->with('success', __('The attendance revision was Rejected successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('leave-requests.index')
                ->with('error', $e->getMessage());
        }
    }
}
