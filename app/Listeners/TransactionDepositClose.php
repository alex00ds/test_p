<?php

namespace App\Listeners;

use App\Events\DepositClose;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Transaction;

class TransactionDepositClose
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
     * @param  DepositClose  $event
     * @return void
     */
    public function handle(DepositClose $event)
    {
        $deposit = $event->getDeposit();

        $deposit->wallet->balance += $deposit->balance + $deposit->invested;
        $deposit->wallet->save();

        $transaction = new Transaction();
        $transaction->type = 'close_deposit';
        $transaction->user_id = $deposit->user_id;
        $transaction->wallet_id = $deposit->wallet_id;
        $transaction->deposit_id = $deposit->id;
        $transaction->amount = $deposit->balance;
        $transaction->save();
    }
}
