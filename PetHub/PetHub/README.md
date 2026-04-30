# PetHub PHP + MySQL

A clean and simple PHP/MySQL version of PetHub for ICT312.

## Features
- User registration and login
- Admin login and dashboard
- Product listing and product details
- Session cart
- Checkout and order creation
- Admin views for products, orders, and customers

## Demo accounts
- Admin: `admin@pethub.local` / `admin123`
- Customer: `keane@example.com` / `password123`

## Setup
1. Copy the folder into `htdocs` if using XAMPP.
2. Create a MySQL database by importing `database/pethub.sql` in phpMyAdmin.
3. Update `config/config.php` if your MySQL username or password is different.
4. Open `http://localhost/PetHub_PHP_MySQL/index.php`

## Notes
This is a student-friendly starter backend. It is clean and simple, and can be extended with CRUD features and stronger validation later.

## Product image update
This version includes corrected local product images in:
`assets/images/products/`

If you already imported the old database, run this SQL file in phpMyAdmin:
`database/update_product_images.sql`

If you are setting up the project from the beginning, just import:
`database/pethub.sql`


## Customer account upgrade
This version includes a cleaner customer account flow:
- customers can create an account through `register.php`
- customers can log in through `login.php`
- the navigation bar shows login status and customer name
- checkout is protected and requires login
- customers can view previous orders in `my-orders.php`
- administrators use the separate admin dashboard

Demo logins:
- Customer: `keane@example.com` / `password123`
- Admin: `admin@pethub.local` / `admin123`
