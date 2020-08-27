<?php

namespace App\Listeners;

use App\Events\WalletReplenishment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Transaction;

class TransactionWalletReplenishment
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
     * @param  WalletReplenishment  $event
     * @return void
     */
    public function handle(WalletReplenishment $event)
    {
        $wallet = $event->getWallet();
        $amount = $event->getAmount();

        $transaction = new Transaction();
        $transaction->type = 'enter';
        $transaction->user_id = $wallet->user_id;
        $transaction->wallet_id = $wallet->id;
        $transaction->amount = $amount;
        $transaction->save();
    }
}
