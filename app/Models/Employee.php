<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'age',
        'department_id', 'country', 'state', 'city'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
