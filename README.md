Taja Beauty web application
Name: Maab Nahar
Group No.: 24
ID: 10002608

PROJECT DESCRIPTION
Taja Beauty is a full-stack PHP shopping website built with:
-	PHP and MYSQL – backend
-	JavaScript, HTML and CSS – frontend
-	Bootstrap – responsive design
-	Apache server via XAMPP

REQUIREMENTS
-	PHP 8.0 or higher
-	MYSQL 5.7 or higher
-	XAMPP (Apache + MySQL + PHP)
-	Web browser (Chrome recommended)

INSTALLATION INSTRUCTIONS
1-	Install XAMPP
2-	Copy project folders to /Applications/XAMPP/xamppfiles/htdocs/  (Mac)
,or , C:\xampp\htdocs\ (Windows)
3-	Import Database :
o	Open phpMyAdmin at http://localhost/phpmyadmin
o	Create a new database (taja_db)
o	Click import
o	Select the file (taja_db.sql)
o	Click go
4-	Configure database: make sure it contains ($conn = mysqli_connect(“localhost”, “root”, “”, “taja_db”);
5-	Run the project on the browser( http://localhost/folder_name/login.php)

LOCAL CREDENTIALS
Username: Maab Nahar
Password: 123456

LIVE DEMO
URL: https://tajabeauty.infinityfreeapp.com

FEATURES
1.	Register and Login System
-	bcrypt password hashing
-	Remember Me cookie (30 days)
-	Session management

2.	Homepage
-	Hero image section
-	Bestsellers section
-	New Arrivals section
-	Footer with social links

3.	Five CRUD Forms
-	Products (Create, Read, Update, Delete)
-	Categories (Create, Read, Update, Delete)
-	Cart (Create, Read, Update, Delete)
-	Orders (Create, Read, Update, Delete)
-	Users (Create, Read, Update, Delete)

4.	AJAX Live Search
-	Real time product search
-	No page reload using Fetch API

5.	Security Features
-	SQL injection protection (prepared statements)
-	XSS protection (htmlspecialchars)
-	Password hashing (bcrypt)
-	Form validation (client and server side)

6.	Responsive Design
-	Mobile friendly layout
-	Bootstrap grid system
-	Sidebar navigation

TECHNOLOGIES USED
Frontend:
-	HTML5 
-	CSS3 (Flexbox, Variables, Animations)
-	JavaScript (Fetch API, DOM Manipulation)
-	Bootstarp 5.3
-	Google Fonts (Playfair Display, Jost)
Backend:
-	Prepared statements (mysql improved procedural)
-	Bcrypt Password hashing
-	Session cookie management
-	XSS Prevention













FILE STRUCTURE
/
├── index.php            (Homepage)
├── login.php            (Login page)
├── register.php         (Registeration page)
├── logout.php           (Logout handler)
├── db.php               (Database connection)
├── db_live.php          (Domain Database connection)
├── search.php           (AJAX search endpoint)
├── products.php         (View all products)
├── add_product.php      (Add new product)
├── edit_product.php     (Edit product)
├── delete_product.php   (Delete product)
├── categories.php.      (View all categories)
├── add_category.php.    (Add new category)
├── edit_category.php    (Edit category)
├── delete_category.php  (Delete category)
├── cart.php             (View cart)
├── add_to_cart.php      (Add to cart handler)
├── update_cart.php      (Update cart quantity)
├── delete_cart.php      (Remove from cart)
├── orders.php           (View orders)
├── place_order.php      (Delete order)
├── view_order.php       (View order details)
├── delete_order.php     (Delete order)
├── user.php             (View all users)
├── edit_user.php        (Edit user deatails)
├── delete_user.php      (Delete user)
├── css/
│   └── styles.css         (Custom styles)
├── includes/
│   ├── navbar.php         (Share navbar)
│   ├── footer.php         (Share footer)
│   └── sidebar_script.php (Sidebar JavaScript)
└── uploads/             (Product Images)







DATABASE TABLES 
-	Products (id, product_name , description, price, stock, category_id , image, created_at)
-	Categories (id, name, created_at)
-	Cart (id, user_id, product_id, quantity)
-	Orders (id, user_id, total, ststus, created_at)
-	Users (id, username, password, created_at)
-	order_items (id, order_id, product_id, quantity, price)
DATABASE CONFIGURATION
LOCAL ( XAMPP)
File: db.php
Host:localhost
Username: root
Password: --
Database: taja_db

LIVE SERVER (InfinityFree)
File: db_live.php
Host: sql111.infinityfree.com








