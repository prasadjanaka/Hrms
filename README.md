# HRMS - Human Resource Management System

A comprehensive Human Resource Management System built with CodeIgniter 3.1.1, MySQL, and Bootstrap 5.

## 🚀 Features

### ✅ Authentication System
- Admin, HR, and Employee role-based access control
- Secure login with password hashing
- Session management
- Password reset functionality

### ✅ Dashboard
- Real-time statistics (Total Employees, Departments, Present Today, On Leave)
- Interactive charts (Attendance Trend, Department Distribution)
- Recent activities feed
- Quick action buttons

### ✅ Employee Management
- Complete CRUD operations for employees
- Profile photo upload
- Advanced search and filtering
- Employee profile pages
- Support for Daily and Monthly salary modes
- Cadre and Shift assignment

### ✅ Cadre Management
- Create and manage cadre positions
- Salary scale tracking
- Hierarchy management

### ✅ Shift Management
- Flexible shift creation with custom timings
- Working days configuration
- Late detection based on shift start time

### ✅ Department & Designation Management
- Organizational structure management
- Department-wise employee tracking

### ✅ Attendance Management
- Check-in/Check-out functionality
- Manual attendance marking (Admin)
- Late detection and reporting
- Daily and monthly summaries
- Export to CSV/PDF

### ✅ Leave Management
- Leave request system
- Approval workflow
- Multiple leave types (Sick, Casual, Annual, etc.)
- Leave balance tracking
- Calendar view

### ✅ Salary Management
- Dual salary modes (Daily Rate × Present Days / Monthly Basic)
- Automatic payslip generation
- Deductions for leaves/absences
- Salary history tracking
- Export functionality

### ✅ Reports
- Attendance reports (Daily/Monthly)
- Salary reports
- Employee summaries
- Leave reports

### ✅ Settings & Configuration
- Company information management
- Holiday calendar
- System configuration

## 🛠 Technology Stack

- **Backend**: PHP 7.4+ with CodeIgniter 3.1.1
- **Database**: MySQL 5.7+
- **Frontend**: Bootstrap 5, jQuery, Chart.js
- **UI Components**: DataTables, Font Awesome
- **Security**: CSRF protection, Input validation, SQL injection prevention

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (for clean URLs)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd hrms
```

### 2. Database Setup
1. Create a MySQL database named `hrms_db`
2. Import the database schema:
```bash
mysql -u root -p hrms_db < database/hrms_schema.sql
```

### 3. Configuration
1. Update database configuration in `application/config/database.php`:
```php
'hostname' => 'localhost',
'username' => 'your_username',
'password' => 'your_password',
'database' => 'hrms_db',
```

2. Update base URL in `application/config/config.php`:
```php
$config['base_url'] = 'http://your-domain.com/hrms/';
```

### 4. File Permissions
Set proper permissions for upload directories:
```bash
chmod 755 assets/uploads/
chmod 755 assets/uploads/employees/
```

### 5. Web Server Configuration
For Apache, ensure mod_rewrite is enabled and create `.htaccess`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

## 🔐 Default Login Credentials

### Admin Account
- **Username**: admin
- **Password**: admin123
- **Role**: Administrator

### Sample Employee Accounts
- **Username**: john.doe
- **Password**: admin123
- **Role**: Employee

- **Username**: jane.smith
- **Password**: admin123
- **Role**: Employee

## 📁 Project Structure

```
hrms/
├── application/
│   ├── config/          # Configuration files
│   ├── controllers/     # Controllers
│   ├── models/          # Models
│   ├── views/           # Views
│   │   ├── auth/        # Authentication views
│   │   ├── dashboard/   # Dashboard views
│   │   ├── employees/   # Employee management views
│   │   ├── layouts/     # Layout templates
│   │   └── ...
│   └── core/            # Core extensions
├── assets/
│   ├── css/            # Custom CSS
│   ├── js/             # Custom JavaScript
│   ├── images/         # Images
│   └── uploads/        # File uploads
├── database/           # Database schema
├── system/            # CodeIgniter system files
└── index.php          # Entry point
```

## 🎯 Key Features Explained

### Salary Modes
The system supports two salary calculation modes:

1. **Monthly Basic Salary**: Fixed monthly salary with deductions for absences
2. **Daily Rate × Present Days**: Daily wage multiplied by actual working days

### Cadre System
- Cadres represent job levels/positions
- Used for salary scale and hierarchy tracking
- Examples: Technical Officer, Assistant, Clerk, Supervisor

### Shift Management
- Flexible shift timings
- Late detection based on shift start time
- Working days configuration
- Attendance validation against assigned shifts

### Attendance System
- Real-time check-in/check-out
- Automatic late detection
- Manual marking for admins
- Comprehensive reporting

## 🔧 Customization

### Adding New Modules
1. Create controller in `application/controllers/`
2. Create model in `application/models/`
3. Create views in `application/views/`
4. Add routes in `application/config/routes.php`

### Styling
- Main styles are in `application/views/layouts/header.php`
- Custom CSS can be added to `assets/css/`
- Bootstrap 5 classes are used throughout

### Database Modifications
- All tables include `created_at` and `updated_at` timestamps
- Foreign key relationships are properly defined
- Indexes are optimized for performance

## 📊 Database Schema

### Core Tables
- `users` - User authentication and roles
- `employees` - Employee information and salary data
- `departments` - Organizational departments
- `designations` - Job titles
- `cadres` - Job levels/positions
- `shifts` - Work shift definitions
- `attendances` - Daily attendance records
- `leaves` - Leave requests and approvals
- `salary_payments` - Monthly salary records
- `settings` - System configuration

## 🚨 Security Features

- Password hashing using PHP's `password_hash()`
- CSRF protection
- Input validation and sanitization
- SQL injection prevention
- Session security
- Role-based access control

## 📈 Performance Optimization

- Database indexes on frequently queried columns
- Efficient JOIN queries
- Pagination for large datasets
- Caching for static data
- Optimized image uploads

## 🐛 Troubleshooting

### Common Issues

1. **404 Errors**: Ensure mod_rewrite is enabled and .htaccess is properly configured
2. **Database Connection**: Verify database credentials and MySQL service status
3. **Upload Errors**: Check file permissions on upload directories
4. **Session Issues**: Ensure session directory is writable

### Debug Mode
Enable debug mode in `application/config/config.php`:
```php
$config['log_threshold'] = 4;
```

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the CodeIgniter user guide

## 🔄 Updates

To update the system:
1. Backup your database and files
2. Download the latest version
3. Replace files (except config and uploads)
4. Run any database migrations
5. Test thoroughly

---

**Note**: This is a production-ready HRMS system. Always backup your data before making changes and test thoroughly in a development environment first.