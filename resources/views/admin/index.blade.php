@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="display-4 text-center mb-4">Admin Dashboard</h2>
    <p class="lead text-center mb-5">Manage and analyze users data</p>

    <!-- User Table -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">User List</h4>
        </div>
        <div class="card-body">
            <table id="userTable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
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
                        <td>{{ number_format($user->total_income, 2) }}</td>
                        <td>{{ number_format($user->total_expense, 2) }}</td>
                        <td>{{ number_format($user->wallet_balance, 2) }}</td>
                        <td class="font-weight-bold">{{ $user->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

    <!-- Top Spenders or Earners Chart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0 text-center">Top Earners</h5>
                </div>
                <div class="card-body">
                    <div id="topSpenders" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTables
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "responsive": true
        });

        // Transactions Overview
        var transactionsOverviewOptions = {
            chart: {
                type: 'pie',
            },
            series: [
                @php
                    $totalIncome = $users->sum('total_income');
                    $totalExpense = $users->sum('total_expense');
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

        // Total Income vs Total Expenses
        var incomeVsExpenseOptions = {
            chart: {
                type: 'bar',
            },
            series: [{
                name: 'Income',
                data: [
                    @foreach ($users as $user)
                        {{ $user->total_income }},
                    @endforeach
                ]
            }, {
                name: 'Expense',
                data: [
                    @foreach ($users as $user)
                        {{ $user->total_expense }},
                    @endforeach
                ]
            }],
            xaxis: {
                categories: [
                    @foreach ($users as $user)
                        '{{ $user->name }}',
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

        // Top Spenders or Earners
        var topSpendersOptions = {
            chart: {
                type: 'bar',
            },
            series: [{
                name: 'Total Income',
                data: [
                    @foreach ($users as $user)
                        {{ $user->total_income }},
                    @endforeach
                ]
            }],
            xaxis: {
                categories: [
                    @foreach ($users as $user)
                        '{{ $user->name }}',
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
        var topSpendersChart = new ApexCharts(document.querySelector("#topSpenders"), topSpendersOptions);
        topSpendersChart.render();
    });
</script>
@endsection
