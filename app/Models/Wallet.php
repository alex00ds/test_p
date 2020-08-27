<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Wallet extends Model
{
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
