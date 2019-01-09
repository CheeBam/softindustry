<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'employees_has_projects', 'employee_id', 'project_id')
            ->withTimestamps();
    }
}
