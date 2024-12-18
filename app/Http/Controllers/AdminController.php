<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all users with related wallet and transactions (use eager loading for efficiency)
        $users = User::with(['wallet', 'transactions'])->get();

        // Calculate totals for each user
        foreach ($users as $user) {
            $totalIncome = $user->transactions->where('type', 'income')->sum('amount');
            $totalExpense = $user->transactions->where('type', 'expense')->sum('amount');
            $walletBalance = $user->wallet ? $user->wallet->balance : 0;  // Handle cases where wallet might not exist

            $user->total_income = $totalIncome;
            $user->total_expense = $totalExpense;
            $user->wallet_balance = $walletBalance;
        }

        return view('admin.index', compact('users'));
    }

}
