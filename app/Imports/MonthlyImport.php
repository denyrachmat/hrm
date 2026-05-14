<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeType;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;
use Illuminate\Support\Facades\DB;

class MonthlyImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.employee_id' => 'required|max:255',
            '*.full_name' => 'nullable|max:255',
            '*.departement_name' => 'nullable|max:255',
            '*.salary' => 'nullable|max:255',
            '*.period' => 'nullable|max:255',
            '*.earnings_bpjs_jht_37' => 'nullable|max:255',
            '*.earnings_bpjs_jkkjkm_054' => 'nullable|max:255',
            '*.earnings_bpjs_jp_2' => 'nullable|max:255',
            '*.earnings_bpjs_health_4' => 'nullable|max:255',
            '*.medical_insurance' => 'nullable|max:255',
            '*.transport' => 'nullable|max:255',
            '*.miscellaneous_earnings' => 'nullable|max:255',
            '*.deductions_bpjs_jht_37' => 'nullable|max:255',
            '*.deductions_bpjs_jkkjkm_054' => 'nullable|max:255',
            '*.deductions_bpjs_jp_2' => 'nullable',
            '*.bpjs_health_4' => 'nullable|max:255',
            '*.pph_21' => 'nullable',
            '*.insurance' => 'nullable|max:255',
            '*.miscellaneous_deduction' => 'nullable|max:255',
        ])->validate();

        foreach ($collection as $row) {
            try {
                $employee = DB::table('employees')
                    ->where('employee_id', $row['employee_id'])
                    ->first();
                $monthlies = DB::table('monthlies')
                    ->where('employee_id', $employee->id)
                    ->where('period', $row['period'])
                    ->first();
                if ($monthlies) {

                    // update
                    DB::table('monthlies')
                        ->where('employee_id', $employee->id)
                        ->where('period', $row['period'])
                        ->update([
                            'bpjs_jht_earnings' => isset($row['earnings_bpjs_jht_37']) ? $row['earnings_bpjs_jht_37'] : 0,
                            'bpjs_jkk_earnings' => isset($row['earnings_bpjs_jkkjkm_054']) ? $row['earnings_bpjs_jkkjkm_054'] : 0,
                            'bpjs_jp_earnings' => isset($row['earnings_bpjs_jp_2']) ? $row['earnings_bpjs_jp_2'] : 0,
                            'bpjs_healt_earnings' => isset($row['earnings_bpjs_health_4']) ? $row['earnings_bpjs_health_4'] : 0,
                            'medical_insurance_earnings' => isset($row['medical_insurance']) ? $row['medical_insurance'] : 0,
                            'transport_earnings' => isset($row['transport']) ? $row['transport'] : 0,
                            'miscellaneous_earnings' => isset($row['miscellaneous_earnings']) ? $row['miscellaneous_earnings'] : 0,
                            'bpjs_jht_deductions' => isset($row['deductions_bpjs_jht_37']) ? $row['deductions_bpjs_jht_37'] : 0,
                            'bpjs_jkk_jkm_deductions' => isset($row['deductions_bpjs_jkkjkm_054']) ? $row['deductions_bpjs_jkkjkm_054'] : 0,
                            'bpjs_jp_deductions' => isset($row['deductions_bpjs_jp_2']) ? $row['deductions_bpjs_jp_2'] : 0,
                            'bpjs_healt_deductions' => isset($row['bpjs_health_4']) ? $row['bpjs_health_4'] : 0,
                            'pph' => isset($row['pph_21']) ? $row['pph_21'] : 0,
                            'insurance_deductions' => isset($row['insurance']) ? $row['insurance'] : 0,
                            'miscellaneous_deduction' => isset($row['miscellaneous_deduction']) ? $row['miscellaneous_deduction'] : 0,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                } else {
                    // create
                    $data = [
                        'employee_id' => $employee->id,
                        'currency' => $row['currency'],
                        'salary' => isset($row['salary']) ? $row['salary'] : 0,
                        'period' => $row['period'],
                        'bpjs_jht_earnings' => isset($row['earnings_bpjs_jht_37']) ? $row['earnings_bpjs_jht_37'] : 0,
                        'bpjs_jkk_earnings' => isset($row['earnings_bpjs_jkkjkm_054']) ? $row['earnings_bpjs_jkkjkm_054'] : 0,
                        'bpjs_jp_earnings' => isset($row['earnings_bpjs_jp_2']) ? $row['earnings_bpjs_jp_2'] : 0,
                        'bpjs_healt_earnings' => isset($row['earnings_bpjs_health_4']) ? $row['earnings_bpjs_health_4'] : 0,
                        'medical_insurance_earnings' => isset($row['medical_insurance']) ? $row['medical_insurance'] : 0,
                        'transport_earnings' => isset($row['transport']) ? $row['transport'] : 0,
                        'miscellaneous_earnings' => isset($row['miscellaneous_earnings']) ? $row['miscellaneous_earnings'] : 0,
                        'bpjs_jht_deductions' => isset($row['deductions_bpjs_jht_37']) ? $row['deductions_bpjs_jht_37'] : 0,
                        'bpjs_jkk_jkm_deductions' => isset($row['deductions_bpjs_jkkjkm_054']) ? $row['deductions_bpjs_jkkjkm_054'] : 0,
                        'bpjs_jp_deductions' => isset($row['deductions_bpjs_jp_2']) ? $row['deductions_bpjs_jp_2'] : 0,
                        'bpjs_healt_deductions' => isset($row['bpjs_health_4']) ? $row['bpjs_health_4'] : 0,
                        'pph' => isset($row['pph_21']) ? $row['pph_21'] : 0,
                        'insurance_deductions' => isset($row['insurance']) ? $row['insurance'] : 0,
                        'miscellaneous_deduction' => isset($row['miscellaneous_deduction']) ? $row['miscellaneous_deduction'] : 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    DB::table('monthlies')->insert($data);
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }
}
