<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function accountCategory()
    {
        return $this->belongsTo(AccountCategory::class);
    }

    public function columnData()
    {
        return $this->hasMany(ColumnData::class, 'column_id', 'id');
    }

}
