@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Transactions</h2>

    <!-- Wallet Information Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Wallet Information</h5>
            <p class="mb-1"><strong>Balance:</strong> {{ $wallet->balance }}</p>
            <p class="mb-1"><strong>Total Income:</strong> {{ $totalIncome }}</p>
            <p class="mb-1"><strong>Total Expense:</strong> {{ $totalExpense }}</p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Filters</h5>
            <form id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" id="categoryFilter">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="typeFilter">
                            <option value="">Select Type</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="dateFilter" placeholder="Select Date" />
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="clearFilters" class="btn btn-secondary">Clear Filters</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-responsive">
        <table id="transactionsTable" class="table table-bordered table-hover">
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
                    <td>{{ $transaction->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <!-- Transactions Overview Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 text-center">Transactions Overview</h5>
                </div>
                <div class="card-body">
                    <div id="transactionsOverview" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Total Income vs Total Expenses Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 text-center">Total Income vs Total Expenses</h5>
                </div>
                <div class="card-body">
                    <div id="incomeVsExpense" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Include Datepicker (for Date Filter) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    $(document).ready(function() {
        var table = $('#transactionsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });

        // Initialize Datepicker for Date Filter with time format
        flatpickr('#dateFilter', {
            dateFormat: 'd-m-Y H:i',
            enableTime: true, 
            noCalendar: false, 
        });

        // Apply Filters to DataTable
        $('#filterForm').on('change', function() {
            var category = $('#categoryFilter').val();
            var type = $('#typeFilter').val();
            var date = $('#dateFilter').val();

            table
                .columns(0).search(category ? '^' + category + '$' : '', true, false) // Category filter
                .columns(2).search(type ? '^' + type + '$' : '', true, false) // Type filter
                .draw();
        });

        // Clear Filters
        $('#clearFilters').on('click', function() {
            $('#filterForm')[0].reset();
            table.search('').columns().search('').draw();
        });

        // Transactions Overview Chart
        var transactionsOverviewOptions = {
            chart: {
                type: 'pie',
            },
            series: [
                @php
                    $totalIncome = $transactions->where('type', 'income')->sum('amount');
                    $totalExpense = $transactions->where('type', 'expense')->sum('amount');
                    echo $totalIncome . ',' . $totalExpense;
                @endphp
            ],
            labels: ['Total Income', 'Total Expenses'],
            title: {
                align: 'center',
                style: {
                    fontSize: '18px',
                    fontWeight: 'bold',
                }
            }
        };
        var transactionsOverviewChart = new ApexCharts(document.querySelector("#transactionsOverview"), transactionsOverviewOptions);
        transactionsOverviewChart.render();

        // Total Income vs Total Expenses Chart
        var incomeVsExpenseOptions = {
            chart: {
                type: 'bar',
            },
            series: [{
                name: 'Income',
                data: [
                    @foreach ($transactions as $transaction)
                        {{ $transaction->type == 'income' ? $transaction->amount : 0 }},
                    @endforeach
                ]
            }, {
                name: 'Expense',
                data: [
                    @foreach ($transactions as $transaction)
                        {{ $transaction->type == 'expense' ? $transaction->amount : 0 }},
                    @endforeach
                ]
            }],
            xaxis: {
                categories: [
                    @foreach ($transactions as $transaction)
                        '{{ $transaction->created_at->format('d-m-Y H:i:s') }}',
                    @endforeach
                ],
            },
            title: {
                align: 'center',
                style: {
                    fontSize: '18px',
                    fontWeight: 'bold',
                }
            }
        };
        var incomeVsExpenseChart = new ApexCharts(document.querySelector("#incomeVsExpense"), incomeVsExpenseOptions);
        incomeVsExpenseChart.render();
    });
</script>
@endsection
