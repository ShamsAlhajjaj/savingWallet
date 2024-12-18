@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Transactions</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Wallet Information</h5>
            <p class="mb-1"><strong>Balance:</strong> {{ $wallet->balance }}</p>
            <p class="mb-1"><strong>Total Income:</strong> {{ $totalIncome }}</p>
            <p class="mb-1"><strong>Total Expense:</strong> {{ $totalExpense }}</p>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
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
                    <td>{{ $transaction->category ? $transaction->category->name : 'N/A' }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ ucfirst($transaction->type) }}</td>
                    <td>{{ $transaction->note }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
