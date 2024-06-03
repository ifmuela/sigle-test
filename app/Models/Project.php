<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    /*
    |------------------------------------------------------------------------------------
    | attibutes
    |------------------------------------------------------------------------------------
    */
    protected $fillable = [
        'description'
    ];

    /*
    |------------------------------------------------------------------------------------
    | relationships
    |------------------------------------------------------------------------------------
    */
    // 1:m
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /*
    |------------------------------------------------------------------------------------
    | functions
    |------------------------------------------------------------------------------------
    */
}
