<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFamily extends Model
{
    use HasFactory;

    protected $table = 'employee_families';

    protected $fillable = [
        'employee_id', 'name', 'relationship', 'date_of_birth','contact_person',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
