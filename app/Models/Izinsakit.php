<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izinsakit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'izinsakits';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'date', 'description', 'detailed_description', 'status', 'file_attachment'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['date' => 'date:d/m/Y', 'detailed_description' => 'string', 'file_attachment' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
