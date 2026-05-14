<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpslocation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gpslocations';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['gpc_location_name', 'latitude', 'longitude', 'radius'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['gpc_location_name' => 'string', 'latitude' => 'string', 'longitude' => 'string', 'radius' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
