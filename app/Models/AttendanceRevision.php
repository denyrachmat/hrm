<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRevision extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance_revisions';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'date', 'clock_in','masuk_istirahat','clock_out', 'reason'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['date' => 'date:d/m/Y', 'clock_in' => 'string', 'clock_out' => 'string', 'reason' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
