<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function department()
    {
        return $this->belongsTo('App\Models\Deparment');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', "user_id");
    }
}
