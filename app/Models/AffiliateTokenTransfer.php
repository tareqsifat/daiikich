<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateTokenTransfer extends Model
{

    protected $table = 'transfer_token_history';
    protected $guarded='id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transferUser(){
    	return $this->belongsTo(User::class,'transfer_user_id');
    }
}
