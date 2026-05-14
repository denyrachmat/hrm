<?php

namespace App\Http\Controllers;

use App\Models\Izinsakit;
use App\Http\Requests\{StoreIzinsakitRequest, UpdateIzinsakitRequest};
use App\Mail\EmailNotification;
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IzinsakitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:izinsakit view')->only('index', 'show');
        // $this->middleware('permission:izinsakit create')->only('create', 'store');
        // $this->middleware('permission:izinsakit edit')->only('edit', 'update');
        // $this->middleware('permission:izinsakit delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $izinsakits = DB::table('izinsakits')
                ->leftJoin('employees', 'izinsakits.employee_id', '=', 'employees.id')
                ->leftJoin('users', 'izinsakits.user_review', '=', 'users.id')
                ->select(
                    'izinsakits.*',
                    'employees.full_name',
                    'users.name as reviewer_name'
                );
            $izinsakits = $izinsakits->orderBy('izinsakits.id', 'DESC')->get();

            return Datatables::of($izinsakits)
                ->addColumn('detailed_description', function ($row) {
                    return str($row->detailed_description)->limit(100);
                })
                ->addColumn('employee', function ($row) {
                    return $row->full_name;
                })
                ->addColumn('action', 'izinsakits.include.action')
                ->toJson();
        }

        return view('izinsakits.index');
    }
    public function create()
    {
        return view('izinsakits.create');
    }

    public function store(StoreIzinsakitRequest $request)
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

        Izinsakit::create($attr);

        return redirect()
            ->route('izinsakits.index')
            ->with('success', __('The izinsakit was created successfully.'));
    }

    public function show(Izinsakit $izinsakit)
    {
        $izinsakit->load('employee:id,full_name');

        return view('izinsakits.show', compact('izinsakit'));
    }

    public function edit(Izinsakit $izinsakit)
    {
        $izinsakit->load('employee:id,full_name');

        return view('izinsakits.edit', compact('izinsakit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Izinsakit $izinsakit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIzinsakitRequest $request, Izinsakit $izinsakit)
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
            if ($izinsakit->file_attachment != null && file_exists($path . $izinsakit->file_attachment)) {
                unlink($path . $izinsakit->file_attachment);
            }

            $attr['file_attachment'] = $filename;
        }

        $izinsakit->update($attr);

        return redirect()
            ->route('izinsakits.index')
            ->with('success', __('The izinsakit was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Izinsakit $izinsakit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Izinsakit $izinsakit)
    {
        try {
            $path = storage_path('app/public/uploads/file_attachments/');

            if ($izinsakit->file_attachment != null && file_exists($path . $izinsakit->file_attachment)) {
                unlink($path . $izinsakit->file_attachment);
            }

            $izinsakit->delete();

            return redirect()
                ->route('izinsakits.index')
                ->with('success', __('The izinsakit was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('izinsakits.index')
                ->with('error', __("The izinsakit can't be deleted because it's related to another table."));
        }
    }

    public function approved(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('izinsakits')->find($request->id);
            // 2. cek ready or tidak di table absen
            $countAttendances = DB::table('attendances')
                ->where('employee_id', $pengajuan->employee_id)
                ->where('date', $pengajuan->date)
                ->count();
            if ($countAttendances > 0) {
                return redirect()
                    ->route('izinsakits.index')
                    ->with('error', __('Data already in Attendances'));
            }
            // 3. cek ready atw tidak di table izin sakit
            $countIzinsakits = DB::table('izinsakits')
                ->where('employee_id', $pengajuan->employee_id)
                ->where('date', $pengajuan->date)
                ->where('status', 'Approved')
                ->count();
            if ($countIzinsakits > 0) {
                return redirect()
                    ->route('izinsakits.index')
                    ->with('error', __('Data already in izin sakit with status Approved'));
            }
            // update status jadi approved
            $affectedRows = DB::table('izinsakits')
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
                DB::table('attendances')->insert([
                    'employee_id' => $pengajuan->employee_id,
                    'date' => $pengajuan->date,
                    'is_present' => 'No',
                    'description' =>  $pengajuan->description,
                    'file_attachment' => $pengajuan->file_attachment,
                    'point' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                // send email to employee
                $employee = DB::table('employees')->find($pengajuan->employee_id);
                $company_name = DB::table('companies')->first()->company_name;
                $data = [
                    'type' => 'Sick Leave',
                    'name' => $employee->full_name,
                    'date' => $pengajuan->date,
                    'status' => 'Approved',
                    'note' => $request->catatan,
                    'description' => $pengajuan->description,
                    'detail_description' => $pengajuan->detailed_description,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('izinsakits.index')
                    ->with('success', __('The izinsakit was Approved successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('izinsakits.index')
                ->with('error', $e->getMessage());
        }
    }

    public function rejected(Request $request)
    {
        try {
            // 1. get detail pengajuan
            $pengajuan = DB::table('izinsakits')->find($request->id);

            // update status jadi rejected
            $affectedRows = DB::table('izinsakits')
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
                    'type' => 'Sick Leave',
                    'name' => $employee->full_name,
                    'date' => $pengajuan->date,
                    'status' => 'Rejected',
                    'note' => $request->catatan,
                    'description' => $pengajuan->description,
                    'detail_description' => $pengajuan->detailed_description,
                    'company_name' => $company_name,
                ];

                Mail::to($employee->email)->send(new EmailNotification($data));

                return redirect()
                    ->route('izinsakits.index')
                    ->with('success', __('The izinsakit was Rejected successfully.'));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('izinsakits.index')
                ->with('error', $e->getMessage());
        }
    }
}
