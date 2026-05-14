<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'earnings';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['employee_id', 'description', 'nominal'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['description' => 'string', 'nominal' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


	public function employee()
	{
		return $this->belongsTo(\App\Models\Employee::class);}
}
