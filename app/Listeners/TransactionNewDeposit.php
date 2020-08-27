<?php

namespace App\Listeners;

use App\Events\NewDeposit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Transaction;

class TransactionNewDeposit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewDeposit  $event
     * @return void
     */
    public function handle(NewDeposit $event)
    {
        $deposit = $event->getDeposit();

        $transaction = new Transaction();
        $transaction->type = 'create_deposit';
        $transaction->user_id = $deposit->user_id;
        $transaction->wallet_id = $deposit->wallet_id;
        $transaction->deposit_id = $deposit->id;
        $transaction->amount = $deposit->invested;
        $transaction->save();
        
    }
}
