<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'date', 'clock_in','clock_istirahat','clock_istirahat_out','clock_out', 'latitude', 'longitude', 'file_attachment', 'is_present', 'description', 'selisih', 'activity', 'image_clock_out','image_istirahat','point'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['date' => 'date:d/m/Y', 'latitude' => 'string', 'longitude' => 'string', 'file_attachment' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i', 'selisih' => 'integer', 'activity' => 'string'];


    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
