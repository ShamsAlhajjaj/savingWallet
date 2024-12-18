<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->groupBy('type');

        // Pass categories to the view
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'category_id' => 'required|numeric',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:500',
            'type' => 'required|string|in:income,expense',
        ]);

        $category_id = $request->input('category_id');
        $amount = $request->input('amount');
        $type = $request->input('type');
        $note = $request->input('note', '');//empty if no note

        $transaction = new Transaction();
        $transaction->category_id = $category_id;
        $transaction->amount = $amount;
        $transaction->type = $type;
        $transaction->note = $note;
        $transaction->user_id = Auth::id();

        $transaction->save();

        return redirect()->route('transaction.create')->with('success', 'Transaction added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
