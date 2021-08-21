<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function rfq()
    {
        return $this->belongsTo(RFQ::class);
    }
}
