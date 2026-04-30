# 🔐 LAMP Stack Login System

A simple and secure login system built with Linux, Apache, MySQL, and PHP.

---

## 🧰 Stack

| Layer | Technology |
|-------|-----------|
| OS | Linux (Ubuntu) |
| Web Server | Apache2 |
| Database | MySQL |
| Backend | PHP |

---

## 📁 Folder Structure

```
loginapp/
├── db.php          # Database connection
├── register.php    # User registration
├── login.php       # User login
├── dashboard.php   # Protected page
├── logout.php      # Session destroy
└── setup.sql       # DB & table setup
```

---

## ⚙️ Setup Guide

### 1. Database
```bash
sudo mysql < setup.sql
```

### 2. Create MySQL User
```sql
CREATE USER 'loginuser'@'localhost' IDENTIFIED BY 'YourPassword';
GRANT ALL PRIVILEGES ON loginapp.* TO 'loginuser'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Update db.php
```php
define('DB_USER', 'loginuser');
define('DB_PASS', 'YourPassword');
```

### 4. Apache Virtual Host
```bash
sudo nano /etc/apache2/sites-available/loginapp.conf
```
```apache
<VirtualHost *:443>
    ServerName login.local
    DocumentRoot /var/www/html/loginapp
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/loginapp.crt
    SSLCertificateKeyFile /etc/ssl/private/loginapp.key
</VirtualHost>
```
```bash
sudo a2ensite loginapp.conf
sudo a2enmod ssl
sudo systemctl reload apache2
```

### 5. Hosts File
```bash
echo "127.0.0.1 login.local" | sudo tee -a /etc/hosts
```

### 6. SSL Certificate
```bash
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
-keyout /etc/ssl/private/loginapp.key \
-out /etc/ssl/certs/loginapp.crt \
-subj "/C=IN/ST=Tamil Nadu/L=Dharmapuri/O=LoginApp/CN=login.local"
```

---

## 🔒 Security Features

- `password_hash()` — bcrypt password storage
- `password_verify()` — secure login check
- `mysqli_real_escape_string()` — SQL injection basic protection
- PHP Session — protected dashboard access
- HTTPS — self-signed SSL certificate

---

## 🌐 Access

```
https://login.local/register.php   → Create account
https://login.local/login.php      → Login
https://login.local/dashboard.php  → Protected page
https://login.local/logout.php     → Logout
```

---

## 👩‍💻 Author

**Thaimozhi** — LAMP Stack Demo Project
