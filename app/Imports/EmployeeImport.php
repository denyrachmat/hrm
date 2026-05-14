<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\BranchOffice;
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

class EmployeeImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        Validator::make($collection->toArray(), [
            '*.employee_id' => 'required|max:255',
            // '*.full_name' => 'required|max:255',
            // '*.gender' => 'nullable|in:Male,Female',
            // '*.date_of_birth' => 'nullable',
            // '*.martial_status' => 'nullable|in:Single,Married,Divorced,Widowed',
            // '*.id_type' => 'nullable|in:KTP,PASSPORT',
            // '*.national_id_no' => 'nullable|max:255',
            // '*.start_contract_date' => 'nullable',
            // '*.end_contract_date' => 'nullable',
            // '*.job_position' => 'nullable|max:255',
            // '*.branch_office' => 'required',
            // '*.bpjs_tk_no' => 'nullable|max:255',
            // '*.bpjs_health_no' => 'nullable|max:255',
            // '*.medical_insurance' => 'nullable|max:255',
            // '*.work_status' => 'nullable|in:Active,Non Active',
            // '*.currency' => 'nullable|in:IDR,USD,Euro',
            // '*.salary' => 'nullable',
            // '*.address' => 'nullable|max:255',
            // '*.department_name' => 'required',
            // '*.email' => 'nullable',
            // '*.tax_id' => 'nullable',
        ])->validate();
        // dd($collection);
        foreach ($collection as $row) {
            try {
                if (is_numeric($row['date_of_birth'])) {
                    $date_of_birth = self::convertTglFromExcel($row['date_of_birth']);
                } else {
                    $date_of_birth = null;
                }

                if (is_numeric($row['start_contract_date'])) {
                    $start_contract_date = self::convertTglFromExcel($row['start_contract_date']);
                } else {
                    $start_contract_date = null;
                }

                if (is_numeric($row['end_contract_date'])) {
                    $end_contract_date = self::convertTglFromExcel($row['end_contract_date']);
                } else {
                    $end_contract_date = null;
                }
                $data = [
                    'employee_id' => $row['employee_id'],
                    'full_name' => $row['full_name'],
                    'gender' => $row['gender'],
                    'date_of_birth' => $date_of_birth,
                    'martial_status' => $row['martial_status'],
                    'id_type' => $row['id_type'],
                    'national_id_no' => $row['national_id_no'],
                    'start_contract_date' => $start_contract_date,
                    'end_contract_date' => $end_contract_date,
                    'job_position' => $row['job_position'],
                    'branch_office_id' => optional(BranchOffice::where('name', $row['branch_office'])->first())->id,
                    'bpjs_tk_no' => (string) $row['bpjs_tk_no'],
                    'bpjs_health_no' => (string) $row['bpjs_health_no'],
                    'medical_insurance' => $row['medical_insurance'],
                    'work_status' => $row['work_status'],
                    'currency' => $row['currency'],
                    'address' => $row['address'],
                    'email' => $row['email'],
                    'tax_id' => $row['tax_id'],
                    'payroll_type' => $row['payroll_type'],
                    'salary' => $row['salary'],
                    'daily_salary' => $row['daily_salary'],
                    'meal_allowance' => $row['meal_allowance'],
                    'craft_incentives' => $row['inst_kerajinan'],
                    'use_gps_location' => 'No',
                    'department_id' => optional(Department::where('department_name', $row['department_name'])->first())->id,
                    'password' => bcrypt($row['employee_id']),
                    'bank_id' => optional(Bank::where('name', $row['bank'])->first())->id,
                    'bank_account_name' => $row['bank_account_name'],
                    'bank_account_number' => $row['bank_account_number'],
                ];
                Employee::create($data);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return $e->getMessage();
            }
        }
    }

    public static function convertTglFromExcel($num)
    {
        $excel_date = $num; //here is that value 41621 or 41631
        $unix_date = ($excel_date - 25569) * 86400;
        $excel_date = 25569 + ($unix_date / 86400);
        $unix_date = ($excel_date - 25569) * 86400;
        return gmdate("Y-m-d", $unix_date);
    }
}
