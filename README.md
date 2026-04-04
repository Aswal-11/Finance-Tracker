# Finance Tracker

A comprehensive Laravel-based finance tracking application with role-based access control, user management, and detailed financial record management.

## Features

### User and Role Management
- **Multi-user Authentication**: Support for main users (admins) and subusers with role-based permissions
- **Role-Based Access Control**: Define roles (Viewer, Analyst, Admin) with granular permissions
- **Automatic Status Management**: Subusers are automatically marked as active when logged in and inactive when logged out
- **Secure Authentication**: Session-based auth with guards for different user types

### Financial Records Management
- **Complete CRUD Operations**: Create, read, update, and delete financial records
- **Record Fields**: Amount, type (income/expense), category, date, and notes
- **Advanced Filtering**: Filter records by type, category, and date range
- **Categories**: Organize records with predefined income/expense categories

### Dashboard and Analytics
- **Real-time Dashboard**: View financial summaries and trends
- **Summary Statistics**: Total income, expenses, net balance
- **Category Analytics**: Breakdown by categories
- **Trend Analysis**: Monthly and weekly financial trends
- **Recent Activity**: Latest transactions overview

### Access Control
- **Policy-Based Authorization**: Laravel policies enforce permissions
- **Table-Level Permissions**: Assign permissions per database table
- **Middleware Protection**: Route protection with custom authentication middleware

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm (for frontend assets)
- MySQL or compatible database

### Setup Steps

1. **Clone the repository**
   `
   git clone https://github.com/Aswal-11/Finance-Tracker.git
   cd Finance-Tracker
   `

2. **Install PHP dependencies**
   `composer install`

3. **Install Node.js dependencies**
   `npm install`

4. **Environment Configuration**
   - Copy .env.example to .env
   - Configure your database settings in .env:  
      <small>
         DB_CONNECTION=mysql  
         DB_HOST=127.0.0.1  
         DB_PORT=port_number  
         DB_DATABASE=finance_tracker  
         DB_USERNAME=your_username  
         DB_PASSWORD=your_password  
      </small>

5. **Generate Application Key**
   `php artisan key:generate`

6. **Run Database Migrations**
   `php artisan migrate`

7. **Seed the Database** (Optional - creates sample data)
   `php artisan db:seed`

8. **Build Frontend Assets**
   `npm install
   # or for development
   npm run dev
   `

9. **Start the Development Server**
   `php artisan serve`

The application will be available at http://localhost:8000

## Usage

### Authentication
- Visit the homepage to access the login form
- Use admin credentials     
  Login id: superadmin@gmail.com   
  password: password123
- Once logged in, you'll be redirected to the dashboard

### Managing Users and Roles

#### As an Admin User:
1. **Create Roles**: Navigate to Roles section to create roles like "Viewer", "Analyst", "Admin"
2. **Assign Permissions**: For each role, assign permissions (read, create, update, delete) to specific tables
3. **Create Subusers**: Add subusers and assign them roles
4. **Monitor Status**: Subuser status is automatically managed based on login activity

#### Role Permissions:
- **Viewer**: Can view dashboard and financial records (read-only)
- **Analyst**: Can view records and access analytics/insights
- **Admin**: Full access to create, update, and manage all data

### Managing Financial Records
1. **View Records**: Access the Records section to see all financial entries
2. **Add Records**: Create new income or expense entries with categories
3. **Filter Records**: Use filters for type, category, and date range
4. **Edit/Delete**: Update or remove records (based on permissions)

### Dashboard
- **Summary Cards**: View total income, expenses, and net balance
- **Category Breakdown**: See spending/income by category
- **Recent Activity**: Latest transactions
- **Trends**: Monthly and weekly financial trends

## API Endpoints

### Dashboard Data
`
GET /api/dashboard-data
`
Returns JSON with financial summaries, category totals, recent activity, and trends.

**Response Example:**
`json
{
  "total_income": 5000.00,
  "total_expenses": 3200.00,
  "net_balance": 1800.00,
  "category_totals": {
    "Salary": {"income": 5000.00, "expense": 0, "net": 5000.00},
    "Food": {"income": 0, "expense": 800.00, "net": -800.00}
  },
  "recent_activity": [...],
  "monthly_trends": {...},
  "weekly_trends": {...}
}
`

## Database Schema

### Key Tables
- users: Main admin users
- subusers: Role-based users
- Roles: User roles
- permissions: Available permissions
- Role_permission: Role-permission assignments
- Financial_records: Financial transactions
- categories: Income/expense categories

## Security Features
- **CSRF Protection**: All forms protected against cross-site request forgery
- **Input Validation**: Comprehensive validation on all user inputs
- **Authorization**: Policy-based access control
- **Session Management**: Secure session handling
- **Password Hashing**: Bcrypt password hashing

#### Video Link: https://drive.google.com/drive/folders/1YxeUxSosUIHE38E-L6XGErYz9CnDYK2K?usp=sharing
- See the video that how to install or run the project