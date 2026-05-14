<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['title', 'categorynews_id', 'thumbnail', 'user_id', 'date', 'description', 'file_attachment'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['title' => 'string', 'thumbnail' => 'string', 'date' => 'date:d/m/Y', 'description' => 'string', 'file_attachment' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];


    public function categorynews()
    {
        return $this->belongsTo(\App\Models\Categorynews::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
