<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['company_name', 'start_clock_in', 'start_clock_out','start_clock_out_saturday', 'late_absence', 'address', 'phone', 'logo', 'email_remainder_first', 'email_remainder_second', 'app_name'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['company_name' => 'string', 'address' => 'string', 'phone' => 'string', 'logo' => 'string', 'email_remainder_first' => 'string', 'email_remainder_second' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
}
