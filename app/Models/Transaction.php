<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaction extends Model
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
}
