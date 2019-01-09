<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

//    public $timestamps = true;

    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employees_has_projects', 'employee_id', 'project_id');
    }


}
