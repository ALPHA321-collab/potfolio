# PhotoFolio - Complete Backend Setup Guide

This package converts the PhotoFolio static HTML template into a full-featured PHP + MySQL dynamic web application.

## Directory Structure
```
photofolio-backend/
├── database/
│   └── schema.sql          # MySQL database schema with sample data
├── includes/
│   └── db.php              # PDO database connection
├── forms/
│   └── contact.php         # AJAX contact form processor (compatible with validate.js)
├── index.php               # Dynamic home page
├── about.php               # About page with dynamic testimonials
├── gallery.php             # Dynamic gallery with category filters
├── gallery-single.php      # Dynamic single portfolio details
├── services.php            # Dynamic services and pricing tables
├── contact.php             # Contact page
└── README.md               # Instructions
```

## How to Install and Run

1. **Copy into your Web Server**:
   - Move the contents into your root/vhost directory (e.g. `htdocs/photofolio` in XAMPP or `/var/www/html/photofolio` in Apache/Nginx).
   - Ensure the template's `assets/` directory (CSS, JS, vendor folders, images) is located in the same root.

2. **Import Database**:
   - Open phpMyAdmin or your MySQL CLI.
   - Run the script located at `database/schema.sql`.

3. **Configure Database Credentials**:
   - Open `includes/db.php`.
   - Update `$user` and `$pass` if your local MySQL setup requires credentials.

4. **Verify Contact Form**:
   - The contact form submits to `forms/contact.php` via AJAX.
   - Messages are automatically stored in the `contact_messages` table and an email notification is triggered.
