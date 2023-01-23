<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TotalConvert extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
