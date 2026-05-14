<?php

namespace App\FormatImport;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EmployeeType;
use App\Models\Department;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Auth;
use Illuminate\Support\Facades\DB;



class GenerateEmployeeSalary implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    // Define a class property
    private $globalDepartement;
    private $globalMonth;

    function __construct($departement, $month)
    {
        $this->globalDepartement = intval($departement);
        $this->globalMonth = $month;
    }

    public function view(): View
    {
        $monthlies = DB::table('employees')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('earnings', 'employees.id', '=', 'earnings.employee_id')
            ->leftJoin('deductions', 'employees.id', '=', 'deductions.employee_id')
            ->select(
                'employees.*',
                'earnings.bpjs_jht as bpjs_jht_earnings',
                'earnings.bpjs_jkk_jkm as bpjs_jkk_jkm_earnings',
                'earnings.bpjs_jp as bpjs_jp_earnings',
                'earnings.bpjs_healt as bpjs_healt_earnings',
                'deductions.bpjs_jht as bpjs_jht_deductions',
                'deductions.bpjs_jkk_jkm as bpjs_jkk_jkm_deductions',
                'deductions.bpjs_jp as bpjs_jp_deductions',
                'deductions.bpjs_healt as bpjs_healt_deductions',
                'deductions.pph',
                'departments.department_name'
            );
        if (isset($this->globalDepartement) && !empty($this->globalDepartement)) {
            if ($this->globalDepartement != 'All') {
                $monthlies = $monthlies->where('employees.department_id', $this->globalDepartement);
            }
        }
        $monthlies = $monthlies->orderBy('employees.employee_id', 'asc')->get();
        return view('monthlies.format', [
            'data' => $monthlies,
            'month' => $this->globalMonth
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:T1';
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
