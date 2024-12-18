
# Saving Walllet

This is a Laravel 11 project that allows users to manage their transactions, wallets, and categories. Users can add income and expense transactions, view their wallet balance, and the admin can manage users and see their financial statistics.

## Features

- **User Authentication**: Login and Registration using Laravel Breeze.
- **Transaction Management**: Users can add transactions with categories (Income and Expense).
- **Wallet Management**: Displays wallet balance, total income, and total expenses.
- **Admin Dashboard**: Admin users can view a list of registered users and their financial details, and show interactive charts of statistics.
- **Category Management**: Predefined and custom categories for income and expenses.

## Technologies Used

- **Laravel 11**: PHP framework for the backend.
- **Laravel Breeze**: Authentication system.
- **Blade**: Templating engine for views.
- **MySQL**: Database to store user data, transactions, and categories.

## Requirements

- PHP >= 8.1
- Composer
- MySQL or any other relational database
- Node.js (for front-end assets)
- Laravel 11

## Installation

### Step 1: Clone the repository

Clone the project repository to your local machine.

```bash
git clone https://github.com/ShamsAlhajjaj/savingWallet.git
cd savingWallet
```

### Step 2: Install dependencies

Run Composer to install the backend dependencies:

```bash
composer install
```

### Step 3: Set up the environment file

Copy the `.env.example` file to `.env` and configure the database connection and other settings.

```bash
cp .env.example .env
```

Update the `.env` file with your database details:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Step 4: Generate the application key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### Step 5: Run migrations

Run the database migrations to create the necessary tables:

```bash
php artisan migrate
```

### Step 6: Install front-end dependencies

Install NPM dependencies and compile the assets:

```bash
npm install
npm run dev
```

### Step 7: Seed the database (optional)

If you want to seed the database with sample data, you can run:

```bash
php artisan db:seed
```

### Step 8: Serve the application

Run the Laravel development server:

```bash
php artisan serve
```

The application should now be accessible at `http://127.0.0.1:8000`.

## Routes

### Public Routes
- **Home**: `/` - The welcome page (can be customized to show a landing page).
  
### Authenticated User Routes
- **Dashboard**: `/dashboard` - Displays the user's dashboard (accessible only by authenticated users).

#### Profile Routes
- **Profile Edit**: `/profile` - View and edit the user's profile.
- **Profile Update**: `/profile` (PATCH) - Update the user's profile information.
- **Profile Delete**: `/profile` (DELETE) - Delete the user's profile.

#### Transaction Routes
- **View Transactions**: `/transactions` - Display the list of user transactions.
- **Create Transaction**: `/transactions/create` - Display the form to add a new transaction.
- **Store Transaction**: `/transactions` (POST) - Store a new transaction in the database.

#### Category Routes
- **Create Category**: `/categories/create` - Display the form to add a new category.
- **Store Category**: `/categories` (POST) - Store a new category in the database.

### Admin Routes
- **Admin Page**: `/admin` - Accessible only by users with the admin role. Displays a list of registered users and financial data.
  
### Middleware
- **auth**: Protects routes so they can only be accessed by authenticated users (e.g., `/dashboard`, `/transactions`).
- **admin**: Restricts access to the admin page to users with the `admin` role (e.g., `/admin`).


## Acknowledgements

- Laravel Framework
- Laravel Breeze for authentication
- Blade templating engine

## Contact

For any issues or questions, feel free to open an issue on GitHub or contact me directly.
