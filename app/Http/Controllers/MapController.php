<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function getMarkers(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $markers = DB::table('attendances')
            ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            ->select('attendances.*', 'employees.full_name')
            ->whereNotNull('attendances.latitude')
            ->whereNotNull('attendances.longitude')
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('attendances.date', '=', $tanggal);
            })
            ->get();

        return response()->json($markers);
    }
}
