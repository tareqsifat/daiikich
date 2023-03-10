<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class ReferralEarning extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
