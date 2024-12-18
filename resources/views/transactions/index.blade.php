@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Transactions</h2>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Wallet Information</h5>
            <p class="card-text">
                <strong>Balance: </strong>{{ $wallet->balance }} 
            </p>
            <p class="card-text">
                <strong>Total Income: </strong>{{ $totalIncome }}
            </p>
            <p class="card-text">
                <strong>Total Expense: </strong>{{ $totalExpense }}
            </p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Category</th>
                <th scope="col">Amount</th>
                <th scope="col">Type</th>
                <th scope="col">Note</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->category ? $transaction->category->name : 'N/A' }}</td> <!-- Display category name -->
                <td>{{ $transaction->amount }}</td>
                <td>{{ ucfirst($transaction->type) }}</td>
                <td>{{ $transaction->note }}</td>
                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
