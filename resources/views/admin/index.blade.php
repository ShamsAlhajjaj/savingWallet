@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin - User List</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                {{-- <th>Birthdate</th> --}}
                <th>Total Income</th>
                <th>Total Expenses</th>
                <th>Wallet Balance</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                {{-- <td>{{ $user->birthdate ? $user->birthdate->format('d-m-Y') : 'N/A' }}</td> --}}
                <td>{{ number_format($user->total_income, 2) }}</td>
                <td>{{ number_format($user->total_expense, 2) }}</td>
                <td>{{ number_format($user->wallet_balance, 2) }}</td>
                <td>{{ $user->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
