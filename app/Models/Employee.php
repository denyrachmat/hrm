<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'device_id', 'token_fcm', 'currency', 'use_gps_location', 'password', 'full_name', 'gender', 'date_of_birth', 'martial_status', 'id_type', 'national_id_no', 'start_contract_date', 'end_contract_date', 'job_position', 'branch_office_id', 'bpjs_tk_no', 'bpjs_health_no', 'medical_insurance', 'work_status', 'salary', 'address', 'department_id', 'tax_id', 'email', 'photo', 'bank_id', 'bank_account_name', 'bank_account_number', 'payroll_type', 'daily_salary', 'meal_allowance', 'craft_incentives'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['employee_id' => 'string', 'full_name' => 'string', 'date_of_birth' => 'date:d/m/Y', 'national_id_no' => 'string', 'start_contract_date' => 'date:d/m/Y', 'end_contract_date' => 'date:d/m/Y', 'job_position' => 'string', 'bpjs_tk_no' => 'string', 'bpjs_health_no' => 'string', 'medical_insurance' => 'string', 'salary' => 'integer', 'address' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i', 'photo' => 'string'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function families()
    {
        return $this->hasMany(EmployeeFamily::class);
    }
}
