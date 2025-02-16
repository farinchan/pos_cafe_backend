<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
