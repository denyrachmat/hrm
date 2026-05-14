<?php

namespace App\Http\Controllers;


class ReportAttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:report attendance view')->only('index', 'show');
    }

    public function index()
    {

        return view('report-attendances.index');
    }
}
