@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <div class="mb-4">
                        <img 
                            src="{{ $user->image ? asset('images/' . $user->image) : asset('images/default-user.png') }}" 
                            alt="{{ $user->name }}" 
                            class="rounded-circle border" 
                            style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <h3 class="card-title mb-3">Welcome, {{ $user->name }}!</h3>
                    
                    <!-- User Details -->
                    <div class="mb-4">
                        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $user->phone }}</p>
                        <p class="mb-1"><strong>Birthdate:</strong> {{ $user->birthdate ?? 'Not provided' }}</p>
                        <p class="mb-1"><strong>Registered At:</strong> {{ $user->created_at->format('d M Y') }}</p>
                    </div>

                    <!-- Logout Button -->
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
    </div>
</div>
@endsection
