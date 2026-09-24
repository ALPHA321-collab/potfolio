# PhotoFolio – Complete Backend

This package turns the static PhotoFolio Bootstrap photography template into a working site with a real contact form backend and a simple admin panel.

## What’s included

| Path | Description |
|------|-------------|
| `forms/contact.php` | Fully working AJAX contact form handler. Validates, sanitizes, rate-limits, stores messages, optional email. Returns `"OK"` so the existing BootstrapMade JS works perfectly. |
| `admin/index.php` | Password-protected admin panel to view, mark-as-read and delete messages. |
| `data/` | Stores `messages.json` + rate-limit log. Protected by `.htaccess`. |
| `README-BACKEND.md` | This file. |

## Requirements

- PHP 7.4+ (8.x recommended)
- No special extensions needed (uses only core PHP + JSON)

## Quick Start

1. Copy the original **assets** folder from the PhotoFolio template into this project (CSS, JS, images, vendor libraries are required for the frontend to look correct).

2. Make the `data/` directory writable by the web server:
   ```bash
   chmod 755 data
   ```

3. **Security (important):**
   - Edit `admin/index.php` → change `$ADMIN_PASSWORD = 'admin123';` to a strong password.
   - Edit `forms/contact.php` → set `'receiving_email' => 'your-real@email.com'`.
   - Optionally set `'enable_mail' => true` if your host allows PHP `mail()`.

4. Test the form on `contact.html`. Success shows the green “Your message has been sent. Thank you!” message.

5. View messages at: `/admin/`

## Local testing

```bash
cd photofolio
php -S localhost:8000
```

Open:
- http://localhost:8000/contact.html
- http://localhost:8000/admin/   (password: admin123)

## How the contact form works

1. User submits the form on `contact.html`.
2. The BootstrapMade `validate.js` sends an AJAX POST to `forms/contact.php`.
3. The PHP script validates name, email, subject, message.
4. Message is saved into `data/messages.json`.
5. Script returns the plain text `OK`.
6. Frontend shows the success message and resets the form.

## Features of the backend

- Input sanitization & length validation
- Rate limiting (default: 5 submissions / IP / hour)
- Honeypot ready (add a hidden field named `website` to the form for extra spam protection)
- Optional real email via PHP `mail()`
- Admin panel with mark-read / delete
- No database required – pure JSON storage

## Optional: enable real emails

In `forms/contact.php`:

```php
'enable_mail'     => true,
'receiving_email' => 'you@yourdomain.com',
```

If `mail()` is disabled on your host you can later replace the mail block with PHPMailer + SMTP.

## Project structure after setup

```
photofolio/
├── index.html, about.html, contact.html, ...
├── assets/               ← copy from original template
├── forms/
│   └── contact.php       ← the backend handler
├── admin/
│   └── index.php         ← admin panel
├── data/
│   ├── messages.json     ← stored messages
│   ├── contact.log       ← rate-limit log
│   └── .htaccess         ← denies web access
└── README-BACKEND.md
```

---

The contact form is now fully functional and the site has a complete, lightweight backend ready for production use after you change the default password and email address.
