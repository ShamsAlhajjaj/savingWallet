<!-- resources/views/user_transactions.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateTransactionForm() {
            const amount = parseFloat(document.getElementById('amount').value);
            const balance = parseFloat(document.getElementById('remaining_balance').value);
            const category = document.getElementById('category').value;

            if (!category) {
                alert('Please select a category.');
                return false;
            }

            if (isNaN(amount) || amount <= 0) {
                alert('Please enter a valid amount.');
                return false;
            }

            if (amount > balance) {
                alert('Expense exceeds remaining balance!');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white text-center py-3">
        <h1>User Transactions</h1>
    </header>

    <!-- Main Content -->
    <div class="container my-5">
<!-- resources/views/user_transactions.blade.php -->
<form onsubmit="return validateTransactionForm()" method="POST" action="{{ route('transaction.store') }}">
    @csrf
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-select" id="category" name="category_id" required onchange="setCategoryType()">
            <option value="" selected disabled>Select Category</option>
            
            @foreach ($categories as $type => $categoryGroup)
                <optgroup label="{{ $type }}">
                    @foreach ($categoryGroup as $category)
                        <option value="{{ $category->id }}" data-type="{{ $type }}">{{ $category->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary mt-2" onclick="toggleCategoryForm()">Add new category</button>
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
    </div>

    <div class="mb-3">
        <label for="note" class="form-label">Note</label>
        <textarea class="form-control" id="note" name="note" rows="3" placeholder="Optional"></textarea>
    </div>

    <!-- Hidden input field for type -->
    <input type="hidden" id="transaction_type" name="type">

    <button type="submit" class="btn btn-success">Add Transaction</button>
</form>

<!-- Hidden form to add a new category -->
<div id="newCategoryForm" style="display: none;">
    <hr>
    <h5>Add New Category</h5>
    <form method="POST" action="{{ route('category.store') }}">
        @csrf
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <div class="mb-3">
            <label for="category_type" class="form-label">Category Type</label>
            <select class="form-select" id="category_type" name="category_type" required>
                <option value="Income">Income</option>
                <option value="Expense">Expense</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Save Category</button>
    </form>
</div>

<script>
    function toggleCategoryForm() {
        const form = document.getElementById('newCategoryForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
    
    function setCategoryType() {
        const selectedOption = document.getElementById('category').selectedOptions[0];
        const categoryType = selectedOption.getAttribute('data-type');
        document.getElementById('transaction_type').value = categoryType;
    }
</script>

        
        <script>
            // Toggle visibility of the "Add New Category" form
            function toggleNewCategoryForm() {
                const newCategoryForm = document.getElementById('newCategoryForm');
                const categorySelect = document.getElementById('category');
                
                // Show or hide the form
                if (newCategoryForm.style.display === 'none') {
                    newCategoryForm.style.display = 'block';
                    categorySelect.disabled = true; // Disable the select dropdown when adding a new category
                } else {
                    newCategoryForm.style.display = 'none';
                    categorySelect.disabled = false; // Enable the select dropdown again
                }
            }
        
            // Set the category type based on the selected option
            function setCategoryType() {
                const selectedOption = document.getElementById('category').selectedOptions[0];
                const categoryType = selectedOption.getAttribute('data-type');
                document.getElementById('transaction_type').value = categoryType;
            }
        </script>
        

    <script>
        function setCategoryType() {
            // Get selected category option
            const selectedOption = document.getElementById('category').selectedOptions[0];

            // Get the type from the selected option's data attribute
            const categoryType = selectedOption.getAttribute('data-type');

            // Set the hidden input field with the type
            document.getElementById('transaction_type').value = categoryType;
        }
    </script>

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; {{ date('Y') }} User Transactions App</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
