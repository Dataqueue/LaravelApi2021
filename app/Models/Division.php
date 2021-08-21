<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function department()
    {
        return $this->hasMany('App\Models\Department');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
}
