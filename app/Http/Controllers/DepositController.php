<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\NewDeposit;
use App\Models\Deposit;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function table()
    {
        $deposits = Deposit::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(config('view.page_size'));

        return view('list-deposit', compact('deposits'));
    }

    public function index()
    {
        $limit_max = min(Deposit::getMaxLimit(), Auth::user()->wallet->balance);
        $limit_min = Deposit::getMinLimit();
        return view('deposit', compact('limit_min', 'limit_max'));
    }

    public function addDeposit(Request $request)
    {
        $wallet = Auth::user()->wallet;
        
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|regex:/^\d+(\.[\d]{1,2})?$/|min:' . Deposit::getMinLimit() . '|max:' . min(Deposit::getMaxLimit(), $wallet->balance)
        ]);

        
        if ($validator->fails()) {
            return redirect('deposit')->withErrors($validator)->withInput();
        }

        $amount = $request->get('amount');

        $transactionResult = DB::transaction(function() use ($amount, $wallet) {
            
            $wallet->balance -= $amount;
            $wallet->save();
            
            $deposit = new Deposit;

            $deposit->user_id = $wallet->user_id;
            $deposit->wallet_id = $wallet->id;
            $deposit->active = 1;
            $deposit->balance = 0;
            $deposit->invested = $amount;
            $deposit->percent = Deposit::getPercentRate();
            $deposit->accrue_times = Deposit::getAccrueTimes();
            $deposit->duration = 0;

            $deposit->save();
            
            event(new NewDeposit($deposit));
            
            return true;
        });
        
        if ($transactionResult) {
            return redirect('/')->with('success', 'Your deposit was started');
        }
        
        return redirect('deposit')->withErrors(['error' => 'There was an error while transaction processing'])->withInput();
    }
}
