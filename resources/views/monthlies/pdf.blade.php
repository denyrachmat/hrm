<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            /* text-align: center; */
        }

        .bordered-div {
            border: 1px solid black;
            padding-right: 30px;
            padding-left: 30px;
            padding-top: 30px;
            padding-bottom: 5px;
            margin: 20px;
            border-radius: 5px;
        }

        .bordered-text {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid black;
            text-decoration: none;
            color: black;
            font-weight: bold;
            border-radius: 2px;
        }
    </style>
</head>

<body>
    <div class="bordered-div">
        <img style="width: 120px" src="../public/storage/uploads/logos/{{ getCompany()->logo }}" alt="">
        <center>
            <span style="font-size: 16px; margin-botto"><b>{{ getCompany()->company_name }}</b></span>
            <p> <b style="font-size: 12px;">Salary Slip</b> </p>
        </center>
        <p style="text-align: right;margin-right:55px;font-size: 12px;"><b>Period</b> <br>
        </p>
        <p style="text-align: right;margin-right:20px;font-size: 16px;margin-top:-10px">
            <span class="bordered-text">{{ convertDate($monthlies->period) }}</span>
        </p>
        <hr>
        <center><span style="font-size: 12px"><b>Employee Details</b></span></center>
        <hr>
        <table style="font-size: 11px; width:100%; text-align:left" class="table">
            <tr>
                <th style="text-align: left">Employee Name</th>
                <th>:</th>
                <td>{{ $monthlies->full_name }}</td>
                <th style="text-align: left">Tax ID Number</th>
                <th>:</th>
                <td>{{ $monthlies->tax_id }}</td>
            </tr>
            <tr>
                <th style="text-align: left">KTP</th>
                <th>:</th>
                <td>{{ $monthlies->national_id_no }}</td>
                <th style="text-align: left">Branch Office</th>
                <th>:</th>
                <td>{{ $monthlies->branch_office_name }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Designation</th>
                <th>:</th>
                <td>{{ $monthlies->job_position }}</td>
                <th style="text-align: left">Department</th>
                <th>:</th>
                <td>{{ $monthlies->department_name }}</td>
            </tr>
            <tr>
                <th style="text-align: left">Employee ID</th>
                <th>:</th>
                <td>{{ $monthlies->employee_id }}</td>
                <th style="text-align: left">Email</th>
                <th>:</th>
                <td>{{ $monthlies->email }}</td>
            </tr>
        </table>
        <hr>
        <center><span style="font-size: 12px"><b>Salary Details</b></span></center>
        <hr>

        <table style="width: 100%; margin: 5px 0;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style=" font-size: 11px;">Salary Monthly</td>
                            <td>:</td>
                            <td style=" font-size: 11px;">{{ currency($monthlies->salary_monthly) }}</td>
                        </tr>
                        <tr>
                            <td style=" font-size: 11px;">Salary Daily</td>
                            <td>:</td>
                            <td style=" font-size: 11px;">{{ currency($monthlies->salary_daily) }}</td>
                        </tr>
                        <tr>
                            <td style=" font-size: 11px;">Craft Incentives</td>
                            <td>:</td>
                            <td style=" font-size: 11px;">{{ currency($monthlies->craft_incentives_payroll) }}</td>
                        </tr>
                        <tr>
                            <td style=" font-size: 11px;">Meal Allowance</td>
                            <td>:</td>
                            <td style=" font-size: 11px;">{{ currency($monthlies->meal_allowance_payroll) }}</td>
                        </tr>
                        @foreach ($earnings as $earning)
                            <tr>
                                <td style=" font-size: 11px;">{{ $earning->name }}</td>
                                <td>:</td>
                                <td style=" font-size: 11px;">{{ currency($earning->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style=" font-size: 11px;"><b>Total Earnings</b></td>
                            <td>:</td>
                            <td style=" font-size: 11px;">
                                <b>{{ currency($monthlies->salary_monthly + $monthlies->salary_daily + $monthlies->total_earnings + $monthlies->craft_incentives_payroll + $monthlies->meal_allowance_payroll) }}</b>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style=" font-size: 11px;">Potongan Telat Absen</td>
                            <td>:</td>
                            <td style=" font-size: 11px;">{{ currency($monthlies->potongan_telat_absen) }}</td>
                        </tr>

                        @foreach ($deductions as $deduction)
                            <tr>
                                <td style=" font-size: 11px;">{{ $deduction->name }}</td>
                                <td>:</td>
                                <td style=" font-size: 11px;">{{ currency($deduction->amount) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style=" font-size: 11px;"><b>Total Deduction</b></td>
                            <td>:</td>
                            <td style=" font-size: 11px;">
                                <b>{{ currency($monthlies->potongan_telat_absen + $monthlies->total_deductions) }}</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        <table style="font-size: 11px; width:100%; text-align:left" class="table">
            <tr>
                <td style="width: 30%"> <b>Nett Salary</b> </td>
                <td style="width: 1px"> <b>:</b></td>
                <td><b>{{ $monthlies->currency . ' ' . currency($monthlies->final_salary) }}</b> </td>
            </tr>
            <tr>
                <td style="width: 30%"></td>
                <td></td>
                <td><b><i>{{ convertToWords($monthlies->final_salary) }}</i> </b>
                </td>
            </tr>
        </table>
        <hr>
        <br>
        <center> <i style="font-size: 10px">This is an electronic generated statement, signature is not require</i>
        </center>
    </div>
</body>

</html>
