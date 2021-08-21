<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
