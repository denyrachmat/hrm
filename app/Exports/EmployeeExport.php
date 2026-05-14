<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;


class EmployeeExport implements FromView, ShouldAutoSize, WithEvents
{
    function __construct($departement, $work_status, $use_gps_location)
    {
        $this->departement = intval($departement);
        $this->work_status =  $work_status;
        $this->use_gps_location =  $use_gps_location;
    }

    public function view(): View
    {
        $data = DB::table('employees')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('branch_offices', 'employees.branch_office_id', '=', 'branch_offices.id')
            ->select(
                'employees.*',
                'departments.department_name',
                'branch_offices.name as branch_office_name'
            );
        if (isset($this->departement) && !empty($this->departement)) {
            if ($this->departement != 'All') {
                $data = $data->where('employees.department_id', $this->departement);
            }
        }

        if (isset($this->use_gps_location) && !empty($this->use_gps_location)) {
            if ($this->use_gps_location != 'All') {
                $data = $data->where('employees.use_gps_location', $this->use_gps_location);
            }
        }

        if (isset($this->work_status) && !empty($this->work_status)) {
            if ($this->work_status != 'All') {
                $data = $data->where('employees.work_status', $this->work_status);
            }
        }

        $data = $data->orderBy('employees.id', 'desc')->get();
        return view('employees.export', [
            'data' => $data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
