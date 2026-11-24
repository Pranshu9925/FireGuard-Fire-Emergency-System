FIREGUARD - FIRE EMERGENCY SYSTEM
=================================
Technology: PHP 8+, MySQL, HTML, CSS, JavaScript
Recommended local environment: Laragon

FEATURES
- Responsive landing page
- User registration and login
- Secure password hashing
- Session-based authentication
- User emergency report submission
- User report history and status tracking
- Admin dashboard with report statistics
- Admin report review, status updates and notes
- PDO prepared statements, basic CSRF protection and server-side validation

INSTALLATION IN LARAGON
1. Copy the complete fire-emergency-system folder into: C:\laragon\www\
2. Start Apache and MySQL in Laragon.
3. Open http://localhost/phpmyadmin (or Laragon Database) and import database.sql.
   This creates the fire_emergency_system database and its tables.
4. Open config/config.php and confirm DB_HOST, DB_NAME, DB_USER and DB_PASS.
   Default Laragon MySQL commonly uses user root and an empty password; change if yours differs.
5. Open http://localhost/fire-emergency-system/ in your browser.
6. Create a normal user account using Create account.
7. To make your account an administrator, open phpMyAdmin, select fire_emergency_system,
   open the users table, find your account, and run this SQL (replace the email):

   UPDATE users SET role='admin' WHERE email='your-email@example.com';

8. Log out and log back in. The Admin dashboard link will appear.

IMPORTANT
- This is an academic demonstration project, not an emergency dispatch service.
- It does not automatically call 112, fire stations, or emergency responders.
- For a real fire emergency, move to safety and contact emergency services directly.
- Before public deployment, add HTTPS, rate limiting, audit logging, backups, stronger
  operational security controls and a reviewed privacy policy.
- Use PHP 8.1+ and MySQL 5.7+/MariaDB 10.4+.

MAIN FILES
index.php             Public landing page
register.php          User registration
login.php             User login
report.php            Submit incident report
my-reports.php        User report history and tracking
dashboard.php         Admin dashboard
manage-report.php     Admin review and status update
logout.php            Logout
config/config.php     Database and shared helper functions
database.sql          Database schema
assets/style.css      UI styles
assets/app.js         Frontend JavaScript
