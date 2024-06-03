<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    /*
    |------------------------------------------------------------------------------------
    | attibutes
    |------------------------------------------------------------------------------------
    */
    protected $fillable = [
        'description',
        'project_id',
        'user_id',
        'date_star',
        'date_end',
        'comment'
    ];

    /*
    |------------------------------------------------------------------------------------
    | relationships
    |------------------------------------------------------------------------------------
    */
    // m:1
    public function user()
	{
		return $this->belongsTo(User::class);
	}

    // m:1
    public function project()
	{
		return $this->belongsTo(Project::class);
	}

    /*
    |------------------------------------------------------------------------------------
    | functions
    |------------------------------------------------------------------------------------
    */
}
