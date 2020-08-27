<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Deposit extends Model
{
    const UPDATED_AT = null;

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function getPercentRate()
    {
        return 20;
    }

    public static function getAccrueTimes()
    {
        return 10;
    }
    
    public static function getMinLimit()
    {
        return 10;
    }
    
    public static function getMaxLimit()
    {
        return 100;
    }
}
