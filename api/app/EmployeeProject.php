<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeProject extends Model
{
    protected $table = 'employees_has_projects';

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
