PROMITHEAS PRESS E-SHOP
CS654 — Web Application Development
Semester Assignment

==================================================

PURPOSE

A minimal e-commerce web app for selling books.

STACK

- PHP 8.1
- MySQL 5.7 (works on MariaDB 10.5)
- Apache 2.4
- Bootstrap 5.3 (CDN)
No external PHP libraries; plain PDO.

QUICK START (LOCAL)

- Import the database backup through PhpMyAdmin
- Open terminal in /src/public/ and type: php -S localhost:8000
- Visit http://localhost:8000/

DEFAULT CREDENTIALS

admin@example.com   admin123
giorgos@example.com giorgos123
elena@example.com   elena123
(passwords are bcrypt-hashed in the SQL dump)

TESTING CHECKLIST

- Register, log in, add an address.
- Browse "Browse by Category", add items, checkout.
- Log back in as user.
- Log in as admin. Can access stub admin panel.
- Use the search bar; "Eleni" for example should show two results (one for book title and one for author name).
- Header and footer look identical on every page.

KNOWN LIMITATIONS

- No images of products uploaded.
- Checkout bypasses payment.
- No navigable admin and user panels, dashboards or profiles.
- Only basic server-side validation; no JavaScript form checks.

AUTHOR

Alexandros Merezas
