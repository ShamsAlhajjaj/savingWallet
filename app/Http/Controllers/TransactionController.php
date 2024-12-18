<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $wallet = Auth::user()->wallet;
        $transactions = Auth::user()->transactions()->with('category')->get();
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $categories = Category::all();
        return view('transactions.index', compact('transactions', 'wallet', 'totalIncome', 'totalExpense', 'categories'));
    }
    
    

    public function create()
    {
        $categories = Category::all()->groupBy('type');
        return view('transactions.create', compact('categories'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string',
        ]);

        $wallet = Auth::user()->wallet;

        if ($request->type == 'expense' && $request->amount > $wallet->balance) {
            return back()->withErrors(['amount' => 'Expense amount exceeds wallet balance.']);
        }

        // Create transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'wallet_id' => $wallet->id,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        // Update wallet balance
        $wallet->balance += $request->type == 'income' ? $request->amount : -$request->amount;
        $wallet->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
    }
}

