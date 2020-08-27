<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Deposit;

class NewDeposit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $deposit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
    }

    public function getDeposit()
    {
        return $this->deposit;
    }
}
