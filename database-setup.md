# Database Setup Guide

## Issue
The collections data is not being stored in the database due to database connection issues.

## Steps to Fix

### 1. Check Database Configuration
Make sure your `.env` file has the correct database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=realestate_crm
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Create Database
Create the database if it doesn't exist:
```sql
CREATE DATABASE realestate_crm;
```

### 3. Install MySQL Driver
Make sure the MySQL PDO driver is installed:
```bash
# For Windows with XAMPP, it should already be installed
# Check if pdo_mysql extension is enabled in php.ini
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Test Database Connection
Visit: `/collections/test` to test the database connection and table structure.

## Common Issues

1. **"could not find driver"** - MySQL PDO driver not installed
2. **"Access denied"** - Wrong database credentials
3. **"Database doesn't exist"** - Database not created
4. **"Table doesn't exist"** - Migrations not run

## Quick Fix Commands

```bash
# Check if migrations are pending
php artisan migrate:status

# Run all pending migrations
php artisan migrate

# Reset and re-run all migrations (WARNING: This will delete all data)
php artisan migrate:fresh

# Seed the database with sample data
php artisan db:seed
```

## Collections Table Structure
The collections table should have these columns:
- id (primary key)
- booking_id (unsigned big integer)
- customer_id (unsigned big integer)
- partner_id (unsigned big integer)
- project_id (unsigned big integer)
- date (date)
- amount (decimal 10,2)
- mode (string)
- created_at (timestamp)
- updated_at (timestamp) 