# Nilaya Resort Multi-Panel Filament Application

## Overview

This application provides a multi-panel Filament interface for different user roles:

- **Admin Panel**: For administrators with full system access (Red theme)
- **Employee Panel**: For resort staff managing day-to-day operations (Green theme)
- **Bank Officer Panel**: For bank representatives verifying property purchases (Blue theme)
- **Customer Panel**: For customers booking accommodations and purchasing properties (Teal theme)

## Setup Instructions

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Configuration

Copy the `.env.example` file to `.env` and configure your database settings:

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Migration and Seeding

Run migrations to set up the database structure:

```bash
php artisan migrate
```

Seed the database with test users for each role:

```bash
php artisan db:seed
```

This will create the following test users:

- Admin: admin@example.com / password
- Employee: employee@example.com / password
- Bank Officer: bank@example.com / password
- Customer: customer@example.com / password

### 4. Build Assets

```bash
npm run build
```

### 5. Start the Development Server

```bash
php artisan serve
```

## Panel Access

Each user role has a dedicated panel with specific access permissions:

- **Admin Panel**: `/admin` - Full system access with red theme
- **Employee Panel**: `/employee` - Resort operations with green theme
- **Bank Officer Panel**: `/bank` - Property verification with blue theme
- **Customer Panel**: `/customer` - Booking and property browsing with teal theme

## Role-Based Middleware

Access to each panel is restricted by role-specific middleware:

- `admin` - Restricts access to admin users only
- `employee` - Restricts access to employee users only
- `bank.officer` - Restricts access to bank officer users only

Customer panel allows registration and is the default for authenticated users.

## Directory Structure

Each panel has dedicated directories for resources, pages, and widgets:

```
app/Filament/
├── AdminResources/
├── AdminPages/
├── AdminWidgets/
├── EmployeeResources/
├── EmployeePages/
├── EmployeeWidgets/
├── BankResources/
├── BankPages/
├── BankWidgets/
├── CustomerResources/
├── CustomerPages/
└── CustomerWidgets/
```

Dashboard views are located in:

```
resources/views/filament/
├── admin/pages/
├── employee/pages/
├── bank/pages/
└── customer/pages/
```

## Customization

Each panel can be further customized by modifying its respective panel provider in:

```
app/Providers/Filament/
├── AdminPanelProvider.php
├── EmployeePanelProvider.php
├── BankOfficerPanelProvider.php
└── CustomerPanelProvider.php
```
