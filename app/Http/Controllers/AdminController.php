<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with(['wallet', 'transactions'])->get();

        foreach ($users as $user) {
            $totalIncome = $user->transactions->where('type', 'income')->sum('amount');
            $totalExpense = $user->transactions->where('type', 'expense')->sum('amount');
            $walletBalance = $user->wallet ? $user->wallet->balance : 0;

            $user->total_income = $totalIncome;
            $user->total_expense = $totalExpense;
            $user->wallet_balance = $walletBalance;
        }

        return view('admin.index', compact('users'));
    }

}
