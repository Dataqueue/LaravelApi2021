<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Department extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function role()
    {
        return $this->hasMany('App\Models\Role');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class, 'department','id')
    }
}
