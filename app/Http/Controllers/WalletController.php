<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RequestAmount;
use App\Events\WalletReplenishment;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('balance');
    }

    public function addBalance(RequestAmount $request)
    {
        $amount = $request->get('amount');

        DB::transaction(function() use ($amount) {
            $wallet = Auth::user()->wallet;
            $wallet->balance += $amount;
            $wallet->save();

            event(new WalletReplenishment($amount, $wallet));
        });
        
        return redirect('/')->with('success', 'Your balance was updated');
    }
}
