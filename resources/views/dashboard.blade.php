@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Welcome, {{ $user->name }}!</h5>

            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Birthdate:</strong> {{ $user->birthdate ?? 'Not provided' }}</p>
            <p><strong>Registered At:</strong> {{ $user->created_at->format('d M Y') }}</p>

            <a href="{{ route('logout') }}" class="btn btn-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
