<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'monthlies';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'currency', 'period', 'salary', 'daily_salary', 'final_salary', 'payroll_type', 'total_earnings', 'total_deductions', 'is_send', 'craft_incentives'];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }
}
