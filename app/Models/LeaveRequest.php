<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leave_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'start_date', 'end_date', 'reason', 'file_attachment'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['start_date' => 'date:d/m/Y', 'end_date' => 'date:d/m/Y', 'reason' => 'string', 'file_attachment' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
