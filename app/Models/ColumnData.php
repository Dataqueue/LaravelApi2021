<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
