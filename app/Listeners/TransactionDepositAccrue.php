<?php

namespace App\Listeners;

use App\Events\DepositAccrue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Transaction;

class TransactionDepositAccrue
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
     * @param  DepositAccrue  $event
     * @return void
     */
    public function handle(DepositAccrue $event)
    {
        $deposit = $event->getDeposit();

        $transaction = new Transaction();
        $transaction->type = 'accrue';
        $transaction->user_id = $deposit->user_id;
        $transaction->wallet_id = $deposit->wallet_id;
        $transaction->deposit_id = $deposit->id;
        $transaction->amount = $deposit->balance;
        $transaction->save();
    }
}
