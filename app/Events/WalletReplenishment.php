<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Wallet;

class WalletReplenishment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    protected $amount;
    protected $wallet;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(float $amount, Wallet $wallet)
    {
        $this->amount = $amount;
        $this->wallet = $wallet;
    }
    
    public function getWallet()
    {
        return $this->wallet;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
