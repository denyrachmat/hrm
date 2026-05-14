<?php

namespace App\Http\Controllers;

use App\Models\EmployeeHasDeduction;
use App\Models\Monthly;
use App\Http\Requests\{StoreMonthlyRequest, UpdateMonthlyRequest, ImportMonthlyRequest};
use Yajra\DataTables\Facades\DataTables;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\FormatImport\GenerateEmployeeSalary;
use App\Imports\MonthlyImport;
use Illuminate\Support\Facades\Mail;
use App\Mail\SalaryEmail;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeHasEarning;
use App\Models\MonthlyHasEarningAndDeduction;
use PDF;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;
use DateTime;


class MonthlyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:monthly view')->only('index', 'show');
        $this->middleware('permission:monthly create')->only('create', 'store');
        $this->middleware('permission:monthly edit')->only('edit', 'update');
        $this->middleware('permission:monthly delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $departementFilter = intval($request->query('departement'));
            $monthFilter = $request->query('month');
            $monthlies = DB::table('monthlies')
                ->leftJoin('employees', 'monthlies.employee_id', '=', 'employees.id')
                ->select(
                    'monthlies.*',
                    'employees.id as employee_id',
                    'employees.full_name',
                    'employees.department_id'
                );
            if (isset($departementFilter) && !empty($departementFilter)) {
                if ($departementFilter != 'All') {
                    $monthlies = $monthlies->where('employees.department_id', $departementFilter);
                }
            }
            if (isset($monthFilter) && !empty($monthFilter)) {
                $monthlies = $monthlies->where('monthlies.period', $monthFilter);
            } else {
                $thisMonth = date('Y-m');
                $monthlies = $monthlies->where('monthlies.period', $thisMonth);
            }
            $monthlies = $monthlies->orderBy('monthlies.employee_id', 'asc')->get();

            return DataTables::of($monthlies)
                ->addColumn('full_name', function ($row) {
                    return $row->full_name;
                })
                ->addColumn('salary_monthly', function ($row) {
                    return  $row->currency . ' ' . currency($row->salary_monthly);
                })
                ->addColumn('salary_daily', function ($row) {
                    return  $row->currency . ' ' . currency($row->salary_daily);
                })
                ->addColumn('total_earnings', function ($row) {
                    return  $row->currency . ' ' . currency($row->total_earnings + $row->craft_incentives_payroll  + $row->meal_allowance_payroll);
                })
                ->addColumn('total_deductions', function ($row) {
                    return  $row->currency . ' ' . currency($row->total_deductions + $row->potongan_telat_absen);
                })
                ->addColumn('final_salary', function ($row) {
                    return  $row->currency . ' ' . currency($row->final_salary);
                })
                ->addColumn('earning_and_deductions', function ($row) {
                    return  MonthlyHasEarningAndDeduction::where('employee_id', $row->employee_id)->where('period', $row->period)->get();
                })
                ->addColumn('is_send', function ($row) {
                    if ($row->is_send == 'Yes') {
                        return '<button class="btn btn-sm  btn-success"><i class="mdi mdi-eye"></i> Yes </button>';
                    } else {
                        return '<button class="btn btn-sm  btn-danger"><i class="mdi mdi-eye"></i> No </button>';
                    }
                })
                ->addColumn('action', 'monthlies.include.action', 'is_send')
                ->rawColumns(['is_send', 'monthlies.include.action', 'action'])
                ->toJson();
        }

        $departement = Department::all();
        return view('monthlies.index', [
            'departement' => $departement
        ]);
    }

    public function printPdf($id)
    {
        $monthlies = DB::table('monthlies')
            ->leftJoin('employees', 'monthlies.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('branch_offices', 'branch_offices.id', '=', 'employees.branch_office_id') // Added join for branch_offices
            ->select(
                'monthlies.*',
                 'employees.id',
                'employees.full_name',
                'employees.email',
                'employees.employee_id',
                'employees.tax_id',
                'employees.national_id_no',
                'employees.job_position',
                'departments.department_name',
                'branch_offices.name as branch_office_name'
            )
            ->where('monthlies.id', $id)
            ->first();
             $employeeId = $monthlies->id;
 // Fetch earnings from monthly_has_earning_and_deductions where period and status = 'earning'
        $earnings = DB::table('monthly_has_earning_and_deductions')
            ->where('period', $monthlies->period)
            ->where('employee_id', $employeeId)
            ->where('status', 'earning')
            ->get();

        // Fetch deductions from monthly_has_earning_and_deductions where period and status = 'deduction'
        $deductions = DB::table('monthly_has_earning_and_deductions')
            ->where('period', $monthlies->period)
            ->where('employee_id', $employeeId)
            ->where('status', 'deduction')
            ->get();
            
        $pdf = PDF::loadview('monthlies.pdf', [
            'monthlies' => $monthlies,
            'earnings' => $earnings,
            'deductions' => $deductions
        ]);
        return $pdf->stream('Salary-Slip.pdf');
    }

    public function viewDetail($id)
    {
        $monthlies = DB::table('monthlies')
            ->leftJoin('employees', 'monthlies.employee_id', '=', 'employees.id')
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('branch_offices', 'branch_offices.id', '=', 'employees.branch_office_id') // Added join for branch_offices
            ->select(
                'monthlies.*',
                'employees.id',
                'employees.full_name',
                'employees.id',
                'employees.email',
                'employees.id as karyawan_id',
                'employees.employee_id',
                'employees.tax_id',
                'employees.national_id_no',
                'employees.job_position',
                'departments.department_name',
                'branch_offices.name as branch_office_name'
            )
            ->where('monthlies.id', $id)
            ->first();
            $employeeId = $monthlies->id;

        // Fetch earnings from monthly_has_earning_and_deductions where period and status = 'earning'
        $earnings = DB::table('monthly_has_earning_and_deductions')
            ->where('period', $monthlies->period)
            ->where('employee_id', $employeeId)
                       ->where('status', 'earning')
            ->get();

        // Fetch deductions from monthly_has_earning_and_deductions where period and status = 'deduction'
        $deductions = DB::table('monthly_has_earning_and_deductions')
            ->where('period', $monthlies->period)
            ->where('employee_id', $employeeId)
                       ->where('status', 'deduction')
            ->get();
        return view('monthlies.show', [
            'monthlies' => $monthlies,
            'earnings' => $earnings,
            'deductions' => $deductions
        ]);
    }

    public function sendMailSalary(Request $request)
    {
        try {
            $monthlies = DB::table('monthlies')
                ->leftJoin('employees', 'monthlies.employee_id', '=', 'employees.id')
                ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
                ->select(
                    'monthlies.*',
                    'employees.full_name',
                    'employees.email',
                    'employees.employee_id',
                    'employees.tax_id',
                    'employees.national_id_no',
                    'employees.job_position',
                    'departments.department_name'
                )->where('monthlies.id', $request->salary_id)->first();
            $data = [
                'title' => $request->title,
                'message' => $request->email_body
            ];
            Mail::to($monthlies->email)->send(new SalaryEmail($data));
            // update status
            DB::table('monthlies') // Replace 'your_table_name' with your actual table name
                ->where('id', $request->salary_id)
                ->update(['is_send' => 'Yes']);
            return redirect()
                ->route('monthlies.index')
                ->with('success', __("Email sent successfully"));
        } catch (\Exception $e) {
            return redirect()
                ->route('monthlies.index')
                ->with('error', __($e->getMessage()));
        }
    }

    public function generateMonthly(Request $request)
    {
        DB::table('monthlies')->where('period', $request->month_generate)->delete();
        DB::table('monthly_has_earning_and_deductions')->where('period', $request->month_generate)->delete();

        $workingDaysInMonth = $this->countWorkingDays($request->month_generate);
        $employees = Employee::when($request->department_id != 'All', function ($q) use ($request) {
            return $q->where('department_id', $request->department_id);
        })->get();

        foreach ($employees as $employee) {
            // Earnings
            $earnings = DB::table('employee_has_earnings')
                ->where('employee_id', $employee->id)
                ->get();

            // Step 2: Insert data into monthly_has_earning_and_deductions
            foreach ($earnings as $earning) {
                DB::table('monthly_has_earning_and_deductions')->insert([
                    'employee_id' => $employee->id,
                    'period' => $request->month_generate,
                    'status' => 'earning',
                    'name' => $earning->name,
                    'amount' => $earning->amount,
                ]);
            }

            // Deductions
            $deductions = DB::table('employee_has_deductions')
                ->where('employee_id', $employee->id)
                ->get();

            // Step 2: Insert data into monthly_has_earning_and_deductions
            foreach ($deductions as $deduction) {
                DB::table('monthly_has_earning_and_deductions')->insert([
                    'employee_id' => $employee->id,
                    'period' => $request->month_generate,
                    'status' => 'deduction',
                    'name' => $deduction->name,
                    'amount' => $deduction->amount,
                ]);
            }

            $salary_monthly = $employee->payroll_type == 'monthly' || $employee->payroll_type == 'monthly_and_daily' ? $employee->salary : 0;
            $salary_per_day = 0;
if ($employee->payroll_type == 'daily' || $employee->payroll_type == 'monthly_and_daily') {
    $salary_per_day = $employee->daily_salary ?? 0; // fallback ke 0 kalau null
}

          
            $craft_incentives = $employee->craft_incentives ?? 0;

            // Total Earnings
            $total_earnings = MonthlyHasEarningAndDeduction::where('employee_id', $employee->id)
                ->where('status', 'earning')
                ->where('period', $request->month_generate)
                ->sum('amount');

            // Total Deductions
            $total_deductions = MonthlyHasEarningAndDeduction::where('employee_id', $employee->id)
                ->where('status', 'deduction')
                ->where('period', $request->month_generate)
                ->sum('amount');

            $daysPresent = $this->countAmountIsPresentEmployee($request->month_generate, $employee->id);
            if ($employee->payroll_type == 'daily' || $employee->payroll_type == 'monthly_and_daily') {
                $daysMissed = $workingDaysInMonth - $daysPresent;
                if ($daysMissed > 3) {
                    $craft_incentives_payroll = 0;
                } elseif ($daysMissed > 0 && $daysMissed <= 3) {
                    $craft_incentives_payroll = $employee->craft_incentives - ($daysMissed * 15000);
                } else {
                    $craft_incentives_payroll = $employee->craft_incentives;
                }
            } else {
                $craft_incentives_payroll = 0;
            }

            if ($employee->payroll_type == 'monthly') {
                $salary_daily = 0;
            } else {
                $salary_daily = $salary_per_day * $daysPresent;
            }

            // Hitung potongan absen karyawan yang clock_in lebih dari jam 08:01 dan kurang dari jam 10:00
            $lateAbsencesCount = $this->calculateLateAbsenceDeduction($employee->id, $request->month_generate);
            $departmentswithlatepenalty = ['1','2','3','4'];
            if (in_array($employee->department_id,$departmentswithlatepenalty)){
                $potongan_telat_absen = $lateAbsencesCount * 10000;
            } else {
                $potongan_telat_absen = 0;
            }
            

            // Hitung benefit uang makan
            $totalAllowanceFee = $employee->meal_allowance * $daysPresent;

            // Hitung final salary
            $final_salary = 0;
            $final_salary = $salary_monthly + $salary_daily + $total_earnings + $totalAllowanceFee + $craft_incentives_payroll - $total_deductions - $potongan_telat_absen;

            // Simpan ke tabel Monthly
            DB::table('monthlies')->insert([
                'employee_id' => $employee->id,
                'period' => $request->month_generate,
                'payroll_type' => $employee->payroll_type,
                'currency' => $employee->currency,
                'salary_monthly' => $salary_monthly,
                'salary_per_day' => $salary_per_day,
                'craft_incentives' => $craft_incentives,
                'jumlah_hari_kerja' => $workingDaysInMonth,
                'jumlah_masuk' => $daysPresent,
                'telat_absen' => $lateAbsencesCount,
                'total_earnings' => $total_earnings,
                'salary_daily' => $salary_daily,
                'craft_incentives_payroll' => $craft_incentives_payroll,
                'meal_allowance_payroll' => $totalAllowanceFee,
                'total_deductions' => $total_deductions,
                'potongan_telat_absen' => $potongan_telat_absen,
                'final_salary' => $final_salary,
                'is_send' => 'No',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/monthlies?month=' . $request->month_generate . '&department=' . $request->department_id);
    }


    private function countAmountIsPresentEmployee($period, $employeeId)
    {
        $startDate = (new \DateTime($period . '-01'))->modify('-1 month')->format('Y-m-26');
        $endDate = $period . '-25';

        return Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('employee_id', $employeeId)
            ->where(function ($query) {
                $query->where('is_present', 'Yes')
                    ->orWhere('description', 'Cuti');
            })
            ->count();
    }

    private function countWorkingDays($month)
    {
        // Set the date range from the 26th of the previous month to the 25th of the current month
        $startDate = (new \DateTime($month . '-01'))->modify('-1 month')->format('Y-m-26');
        $endDate = $month . '-25';

        $workingDays = 0;
        $date = new \DateTime($startDate);

        // Loop through the date range
        while ($date->format('Y-m-d') <= $endDate) {
            $dayOfWeek = $date->format('w'); // Get the day of the week (0 = Sunday, 6 = Saturday)

            // Count only weekdays excluding Sundays
            if ($dayOfWeek != 0) { // Exclude Sundays (0 represents Sunday)
                $workingDays++;
            }

            $date->modify('+1 day');
        }

        // Get all offdays for the given date range using query builder
        $offdaysCount = DB::table('offdays')
            ->whereBetween('date', [$startDate, $endDate])
            ->count();

        // Subtract offdays from the working days
        $workingDays -= $offdaysCount;

        return $workingDays;
    }

    protected function calculateLateAbsenceDeduction($employeeId, $monthGenerate)
    {
        $startDate = (new \DateTime($monthGenerate . '-01'))->modify('-1 month')->format('Y-m-26');
        $endDate = $monthGenerate . '-25';

        // Count late absences and calculate the deduction
        $lateAbsencesCount = Attendance::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('clock_in', '>', '08:00')
            ->where('clock_in', '<', '10:00')
            ->count();

        return $lateAbsencesCount;
    }

    private function getTotalMealAllowance($employeeId, $period)
    {
        $startDate = (new \DateTime($period . '-01'))->modify('-1 month')->format('Y-m-26');
        $endDate = $period . '-25';
        return Attendance::where('employee_id', $employeeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('meal_allowance');
    }

    public function storeEarningDeduction(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'employee_id' => 'required|integer',
            'period' => 'required|string',
            'status' => 'required|in:earning,deduction',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        // Gunakan DB transaction untuk memastikan konsistensi data
        DB::beginTransaction();

        try {
            // Simpan data ke database menggunakan Query Builder
            DB::table('monthly_has_earning_and_deductions')->insert([
                'employee_id' => $validatedData['employee_id'],
                'period' => $validatedData['period'],
                'status' => $validatedData['status'],
                'name' => $validatedData['name'],
                'amount' => $validatedData['amount'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Jika status adalah 'earning', hitung total earnings dan update table monthlies
            if ($validatedData['status'] == 'earning') {
                // Sum dari semua earnings untuk employee dan period yang sama
                $totalEarnings = DB::table('monthly_has_earning_and_deductions')
                    ->where('employee_id', $validatedData['employee_id'])
                    ->where('period', $validatedData['period'])
                    ->where('status', 'earning')
                    ->sum('amount');

                // Ambil data monthlies untuk employee dan period
                $monthlyData = DB::table('monthlies')
                    ->where('employee_id', $validatedData['employee_id'])
                    ->where('period', $validatedData['period'])
                    ->first();

                if ($monthlyData) {
                    // Hitung ulang final_salary
                    $final_salary = $monthlyData->salary_monthly
                        + $monthlyData->salary_daily
                        + $totalEarnings
                        + $monthlyData->meal_allowance_payroll
                        + $monthlyData->craft_incentives_payroll
                        - $monthlyData->total_deductions
                        - $monthlyData->potongan_telat_absen;

                    // Update total_earnings dan final_salary di table monthlies
                    DB::table('monthlies')
                        ->where('employee_id', $validatedData['employee_id'])
                        ->where('period', $validatedData['period'])
                        ->update([
                            'total_earnings' => $totalEarnings,
                            'final_salary' => $final_salary,
                            'updated_at' => now(),
                        ]);
                }
            }

            // Jika status adalah 'deduction', hitung total deductions dan update table monthlies
            if ($validatedData['status'] == 'deduction') {
                // Sum dari semua deductions untuk employee dan period yang sama
                $totalDeductions = DB::table('monthly_has_earning_and_deductions')
                    ->where('employee_id', $validatedData['employee_id'])
                    ->where('period', $validatedData['period'])
                    ->where('status', 'deduction')
                    ->sum('amount');

                // Ambil data monthlies untuk employee dan period
                $monthlyData = DB::table('monthlies')
                    ->where('employee_id', $validatedData['employee_id'])
                    ->where('period', $validatedData['period'])
                    ->first();

                if ($monthlyData) {
                    // Hitung ulang final_salary
                    $final_salary = $monthlyData->salary_monthly
                        + $monthlyData->salary_daily
                        + $monthlyData->total_earnings
                        + $monthlyData->meal_allowance_payroll
                        + $monthlyData->craft_incentives_payroll
                        - $totalDeductions
                        - $monthlyData->potongan_telat_absen;

                    // Update total_deductions dan final_salary di table monthlies
                    DB::table('monthlies')
                        ->where('employee_id', $validatedData['employee_id'])
                        ->where('period', $validatedData['period'])
                        ->update([
                            'total_deductions' => $totalDeductions,
                            'final_salary' => $final_salary,
                            'updated_at' => now(),
                        ]);
                }
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Data saved successfully!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            dd($e->getMessage());
            // Redirect kembali dengan pesan error
            return redirect()->back()->withErrors('Data could not be saved. Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Ambil data yang akan dihapus
            $record = DB::table('monthly_has_earning_and_deductions')->where('id', $id)->first();

            // Jika tidak ada data yang ditemukan, kembalikan dengan pesan error
            if (!$record) {
                return redirect()->back()->withErrors('Data not found!');
            }

            // Hapus data dari tabel monthly_has_earning_and_deductions
            DB::table('monthly_has_earning_and_deductions')->where('id', $id)->delete();

            // Ambil data monthlies untuk employee dan period yang bersesuaian
            $monthlyData = DB::table('monthlies')
                ->where('employee_id', $record->employee_id)
                ->where('period', $record->period)
                ->first();

            if ($monthlyData) {
                // Proses berdasarkan status record yang dihapus
                if ($record->status == 'earning') {
                    // Jika status adalah 'earning', kurangi total_earnings
                    $totalEarnings = DB::table('monthly_has_earning_and_deductions')
                        ->where('employee_id', $record->employee_id)
                        ->where('period', $record->period)
                        ->where('status', 'earning')
                        ->sum('amount');

                    // Hitung ulang final_salary
                    $final_salary = $monthlyData->salary_monthly
                        + $monthlyData->salary_daily
                        + $totalEarnings
                        + $monthlyData->meal_allowance_payroll
                        + $monthlyData->craft_incentives_payroll
                        - $monthlyData->total_deductions
                        - $monthlyData->potongan_telat_absen;

                    // Update total_earnings dan final_salary di table monthlies
                    DB::table('monthlies')
                        ->where('employee_id', $record->employee_id)
                        ->where('period', $record->period)
                        ->update([
                            'total_earnings' => $totalEarnings,
                            'final_salary' => $final_salary,
                            'updated_at' => now(),
                        ]);
                }

                if ($record->status == 'deduction') {
                    // Jika status adalah 'deduction', tambahkan total_deductions
                    $totalDeductions = DB::table('monthly_has_earning_and_deductions')
                        ->where('employee_id', $record->employee_id)
                        ->where('period', $record->period)
                        ->where('status', 'deduction')
                        ->sum('amount');

                    // Hitung ulang final_salary
                    $final_salary = $monthlyData->salary_monthly
                        + $monthlyData->salary_daily
                        + $monthlyData->total_earnings
                        + $monthlyData->meal_allowance_payroll
                        + $monthlyData->craft_incentives_payroll
                        - $totalDeductions
                        - $monthlyData->potongan_telat_absen;

                    // Update total_deductions dan final_salary di table monthlies
                    DB::table('monthlies')
                        ->where('employee_id', $record->employee_id)
                        ->where('period', $record->period)
                        ->update([
                            'total_deductions' => $totalDeductions,
                            'final_salary' => $final_salary,
                            'updated_at' => now(),
                        ]);
                }
            }

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Berhasil hapus data!');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            dd($e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->withErrors('Gagal menghapus data. Error: ' . $e->getMessage());
        }
    }
}
