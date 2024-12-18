@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Transaction</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('transactions.store') }}" id="transaction-form">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category_id" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <!-- Income categories -->
                        <optgroup id="income-categories" label="Income" style="display:none;">
                            @foreach ($categories['income'] as $category)
                                <option value="{{ $category->id }}" 
                                    @if(old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                        <!-- Expense categories -->
                        <optgroup id="expense-categories" label="Expense" style="display:none;">
                            @foreach ($categories['expense'] as $category)
                                <option value="{{ $category->id }}" 
                                    @if(old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
            <small class="form-text text-muted">Enter the amount for this transaction.</small>
        </div>

        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>
        
        <div class="form-group text-right p-2">
            <button type="submit" class="btn btn-primary" id="submit-btn">
                <span id="submit-text">Add Transaction</span>
                <span id="loading-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
            <a href="{{ route('categories.create') }}" class="btn btn-secondary">Add New Category</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const selectedType = this.value;
        
        // Hide all categories
        document.getElementById('income-categories').style.display = 'none';
        document.getElementById('expense-categories').style.display = 'none';

        // Show categories based on selected type
        if (selectedType === 'income') {
            document.getElementById('income-categories').style.display = 'block';
        } else if (selectedType === 'expense') {
            document.getElementById('expense-categories').style.display = 'block';
        }
    });

    // Trigger the change event on page load to show the correct categories
    document.getElementById('type').dispatchEvent(new Event('change'));

    // Optional: Show loading spinner when form is submitting
    document.getElementById('transaction-form').addEventListener('submit', function() {
        document.getElementById('submit-btn').disabled = true;
        document.getElementById('submit-text').classList.add('d-none');
        document.getElementById('loading-spinner').classList.remove('d-none');
    });
</script>
@endsection
