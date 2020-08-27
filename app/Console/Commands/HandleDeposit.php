<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Deposit;
use App\Events\DepositAccrue;
use App\Events\DepositClose;

class HandleDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle active deposits';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deposits = Deposit::where('active', 1)->cursor();
        foreach ($deposits as $deposit) {
            DB::transaction(function() use ($deposit) {

                $deposit->balance += $deposit->invested / 100.0 * $deposit->percent;
                $deposit->duration ++;
                if ($deposit->duration >= $deposit->accrue_times) {
                    $deposit->active = 0;
                }
                $deposit->save();
                
                event(new DepositAccrue($deposit));
                
                if (! $deposit->active) {
                    event(new DepositClose($deposit));
                }
            });
        }
        return 0;
    }
}
