# Jay Shree Mahakal Finance Services (JSMF) Website

Complete PHP/MySQL finance services website for loan applications, DSA management, and admin control.

## Features

- **Homepage**: Hero section, loan products, statistics, features showcase
- **Loan Application System**: Complete application form with validation
- **EMI Calculator**: Interactive calculator with charts and breakdown
- **Status Tracking**: Check loan application status
- **DSA Portal**: Direct Selling Agent registration and dashboard
- **Admin Panel**: Complete admin dashboard for managing loans and DSAs
- **Contact System**: Contact forms and customer support
- **Responsive Design**: Bootstrap-based responsive layout

## Installation Steps for Hostinger

### 1. Upload Files
1. Download and extract the zip file
2. Upload all files to your Hostinger public_html directory
3. Ensure the file structure remains intact

### 2. Database Setup
1. Login to Hostinger control panel
2. Go to MySQL Databases
3. Import the `database.sql` file to create tables
4. Update database credentials in `config.php` if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'u900473099_gourav');
   define('DB_USER', 'u900473099_gourav');
   define('DB_PASS', 'Gourav@9111968788');
   ```

### 3. File Permissions
Set the following permissions:
- `uploads/` directory: 755 or 777
- `assets/` directory: 755

### 4. Admin Access
- **URL**: `https://jsmf.in/admin/login.php`
- **Username**: `admin`
- **Password**: `Harsh@9131`

### 5. Website URLs
- **Homepage**: `https://jsmf.in/`
- **Apply Loan**: `https://jsmf.in/apply-loan.php`
- **EMI Calculator**: `https://jsmf.in/emi/calculator.php`
- **Check Status**: `https://jsmf.in/check-status.php`
- **DSA Portal**: `https://jsmf.in/dsa/login.php`
- **Admin Panel**: `https://jsmf.in/admin/login.php`

## Directory Structure

```
/
├── admin/                 # Admin panel
│   ├── dashboard.php     # Admin dashboard
│   └── login.php         # Admin login
├── assets/               # Static assets
│   ├── css/             # Stylesheets
│   ├── js/              # JavaScript files
│   └── images/          # Images and logo
├── dsa/                 # DSA portal
│   ├── dashboard.php    # DSA dashboard
│   ├── login.php        # DSA login
│   └── register.php     # DSA registration
├── emi/                 # EMI calculator
│   └── calculator.php   # EMI calculator page
├── includes/            # Common includes
│   ├── header.php       # Common header
│   └── footer.php       # Common footer
├── uploads/             # File uploads directory
├── index.php            # Homepage
├── apply-loan.php       # Loan application
├── check-status.php     # Status checker
├── contact-us.php       # Contact form
├── config.php           # Database configuration
├── database.sql         # Database schema
└── README.md           # This file
```

## Database Tables

1. **loan_applications** - Stores loan applications
2. **dsa_users** - DSA user accounts
3. **admin_users** - Admin user accounts
4. **contact_messages** - Contact form submissions
5. **notifications** - System notifications
6. **loan_types** - Available loan types
7. **lead_assignments** - DSA lead assignments

## Key Features

### For Customers
- Apply for various types of loans
- Calculate EMI with interactive tools
- Track application status
- Contact support

### For DSAs (Direct Selling Agents)
- Register and manage account
- View assigned leads
- Update lead status
- Track performance

### For Administrators
- Manage all loan applications
- Approve/reject DSAs
- Assign leads to DSAs
- View system statistics
- Send notifications

## Customization

### Changing Colors
Update CSS variables in `assets/css/style.css`:
```css
:root {
    --primary-red: #dc3545;
    --primary-red-light: #f8d7da;
    --primary-red-dark: #721c24;
}
```

### Adding New Loan Types
Add entries to the `loan_types` table in the database.

### Email Configuration
Update the `sendEmail()` function in `config.php` for email notifications.

## Support

For any issues or customization needs:
- Email: costumercare@jsmf.in
- Phone: +91 62620 79180

## Security Notes

- All forms include CSRF protection
- Passwords are hashed using PHP's password_hash()
- SQL injection protection with prepared statements
- Input validation and sanitization
- Session management for user authentication

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

---

**Jay Shree Mahakal Finance Services**  
Professional loan management system built with PHP & MySQL