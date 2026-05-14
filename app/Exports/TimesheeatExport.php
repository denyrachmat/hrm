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


class TimesheeatExport implements FromView, ShouldAutoSize, WithEvents
{
    function __construct($start_date, $end_date, $departement, $is_present, $description)
    {
        $this->start_date =  $start_date;
        $this->end_date =   $end_date;
        $this->departement = intval($departement);
        $this->is_present =  $is_present;
        $this->description =  $description;
    }

    public function view(): View
    {
        $attendances = DB::table('attendances')
            ->leftJoin('employees', 'attendances.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->select(
                'attendances.*',
                'employees.full_name',
                'departments.department_name'
            );
        if (isset($this->end_date) && !empty($this->end_date)) {
            $to = date("Y-m-d H:i:s", substr($this->end_date, 0, 10));
            $attendances = $attendances->where('date', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $attendances = $attendances->where('date', '<=', $to);
        }

        if (isset($this->start_date) && !empty($this->start_date) && isset($this->end_date) && !empty($this->end_date)) {
            $from = date("Y-m-d H:i:s", substr($this->start_date, 0, 10));
            $to = date("Y-m-d H:i:s", substr($this->end_date, 0, 10));
            $attendances = $attendances->whereBetween('date', [$from, $to]);
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $to = date('Y-m-d') . " 23:59:59";
            $attendances = $attendances->whereBetween('date', [$from, $to]);
        }

        if (isset($this->departement) && !empty($this->departement)) {
            if ($this->departement != 'All') {
                $attendances = $attendances->where('employees.department_id', $this->departement);
            }
        }


        if (isset($this->is_present) && !empty($this->is_present)) {
            if ($this->is_present != 'All') {
                $attendances = $attendances->where('attendances.is_present', $this->is_present);
            }
        }

        if (isset($this->description) && !empty($this->description)) {
            if ($this->description != 'All') {
                $attendances = $attendances->where('attendances.description', $this->description);
            }
        }
        $attendances = $attendances->orderBy('attendances.id', 'DESC')->get();
        return view('attendances.export', [
            'data' => $attendances
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
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
