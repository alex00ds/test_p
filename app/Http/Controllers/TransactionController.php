<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function table()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(config('view.page_size'));

        return view('list-transaction', compact('transactions'));
    }
}
