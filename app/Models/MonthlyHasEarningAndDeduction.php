<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyHasEarningAndDeduction extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'period', 'status', 'name', 'amount'];
}
