# 🌿 Umuganda Smart Service Request Platform

## 📋 Project Description

The **Umuganda Smart Service Request Platform** is a comprehensive web-based system that digitizes community service requests, replacing informal communication methods (WhatsApp, phone calls) with a transparent, accountable digital system. Built for Rwandan communities and campuses, this platform enables citizens to submit service requests, track their status in real-time, and holds service providers accountable through complete audit trails.

### Key Features

#### Public Features
- **Submit Service Requests** - Easy-to-use form with live preview
- **Track Request Status** - Real-time tracking with unique ticket number
- **View Live Statistics** - Platform-wide metrics on dashboard
- **Responsive Design** - Works on desktop, tablet, and mobile

#### Admin Dashboard
- **Complete Analytics** - Visual charts and statistics
- **Request Management** - View, filter, search all requests
- **Status Updates** - Change status (Pending → In Progress → Resolved)
- **Audit Trail** - Complete history of all status changes
- **Reports Generation** - Print and export PDF reports
- **User Management** - Add/remove officers, change passwords

#### Officer Features
- **View Assigned Requests** - See requests assigned to them
- **Update Status** - Mark requests as In Progress or Resolved
- **Add Notes** - Leave comments for requesters
- **Track History** - View complete request timeline

### Request Categories

| ID | Category | Icon |
|----|----------|------|
| 1 | Water & Sanitation | fa-tint |
| 2 | Street Lighting | fa-lightbulb |
| 3 | Cleaning & Waste | fa-trash |
| 4 | ICT & Lab Support | fa-desktop |
| 5 | Accommodation | fa-home |
| 6 | Event Support | fa-calendar-alt |
| 7 | Road & Infrastructure | fa-road |
| 8 | Other | fa-question-circle |

### Priority Levels

| Level | Color | Description |
|-------|-------|-------------|
| Low | 🟢 Green | Non-urgent issues |
| Medium | 🟡 Yellow | Standard priority |
| High | 🔴 Red | Urgent issues requiring immediate attention |

### Status Flow
Pending → In Progress → Resolved

### Technology Stack

| Component | Technology |
|-----------|------------|
| Architecture | MVC (Model-View-Controller) |
| Frontend | HTML5, CSS3, JavaScript (ES6+) |
| Backend | PHP 7.4+ with PDO |
| Database | MySQL / MariaDB |
| Styling | Custom CSS with CSS Grid/Flexbox |
| Icons | Font Awesome 6 |
| Fonts | Google Fonts |

---

## 🚀 Installation Steps

### Prerequisites

- **XAMPP** (or WAMP/MAMP) with PHP 7.4+
- **MySQL** 5.7+ or MariaDB 10+
- **Web browser** (Chrome/Firefox recommended)

### Step-by-Step Installation

#### Step 1: Install XAMPP
Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/)

#### Step 2: Copy Project Files

```bash
# Navigate to XAMPP htdocs folder
cd C:\xampp\htdocs\

# Create project folder
mkdir umuganda-mvc

# Copy all project files into this folder
Step 3: Start XAMPP Services
Open XAMPP Control Panel and start:

Apache (Web Server)

MySQL (Database)

Step 4: Configure Apache (Enable mod_rewrite)
Open C:\xampp\apache\conf\httpd.conf

Find and uncomment: LoadModule rewrite_module modules/mod_rewrite.so

Find AllowOverride None and change to AllowOverride All

Restart Apache

Step 5: Set Up .htaccess Files
Root .htaccess (C:\xampp\htdocs\umuganda-mvc\.htaccess):
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/umuganda-mvc/public/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /umuganda-mvc/public/$1 [L]
Options -Indexes
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]

## 💾 Database Import Steps

Method 1: Using phpMyAdmin (Recommended)
Open your browser and go to: http://localhost/phpmyadmin

Click New in the left sidebar

Enter database name: umuganda

Choose collation: utf8_general_ci

Click Create

Click on the new umuganda database

Click the SQL tab

Copy and paste the entire contents of database/schema.sql

Click Go to execute

Verify Database Import
After successful import, run this query in phpMyAdmin:
SELECT 'Setup Complete!' AS Status;
SELECT COUNT(*) AS TotalCategories FROM categories;
SELECT COUNT(*) AS TotalUsers FROM users;
SELECT COUNT(*) AS TotalRequests FROM requests;
SELECT COUNT(*) AS TotalHistory FROM request_history;

Database Tables Structure
Table	Description	Records
categories	Request categories (Water, Lighting, Waste, ICT, etc.)	8
users	Admin and officer accounts	2
requests	Service requests submitted by citizens	3 (sample)
request_history	Audit trail of all status changes	6 (sample)
🔐 Login Credentials for Testing
Admin Access (Full Control)
Field	Value
URL	http://localhost/umuganda-mvc/login
Username	admin
Password	admin
Role	Administrator
Officer Access (Limited Access)
Field	Value
URL	http://localhost/umuganda-mvc/login
Username	officer
Password	officer
Role	Service Officer
What Each Role Can Do
Feature	Admin	Officer
View Dashboard	✅	✅
View All Requests	✅	✅
Update Request Status	✅	✅
Add Notes to Requests	✅	✅
View Reports	✅	✅
Print Reports	✅	✅
User Management	✅	❌
Add/Remove Officers	✅	❌
Change Any Password	✅	❌
🌐 Live Link
Local Access
text
http://localhost/umuganda-mvc/
Direct Page Access
Page	URL
Homepage	http://localhost/umuganda-mvc/
Submit Request	http://localhost/umuganda-mvc/submit
Track Request	http://localhost/umuganda-mvc/track
Admin Login	http://localhost/umuganda-mvc/login
Admin Dashboard	http://localhost/umuganda-mvc/admin/dashboard
All Requests	http://localhost/umuganda-mvc/admin/requests
Reports	http://localhost/umuganda-mvc/admin/reports
User Management	http://localhost/umuganda-mvc/admin/users
Print Reports	http://localhost/umuganda-mvc/admin/print-reports
API Endpoints
Endpoint	Method	Description
/api/stats	GET	Platform statistics
/api/categories	GET	Request categories
/api/track-request?ticket=XXX	GET	Track request by ticket
/api/submit-request	POST	Submit new request
/api/admin-login	POST	Admin authentication
/api/update-request	POST	Update request status
/api/users	GET	Get all users (admin only)
/api/add-officer	POST	Add new officer (admin only)
/api/remove-officer	POST	Remove officer (admin only)
/api/reactivate-officer	POST	Reactivate officer (admin only)
/api/change-password	POST	Change user password (admin only)
👥 Team Members and Roles
Name	Role	Responsibilities
Jean Paul N.	Lead Developer / System Architect	MVC architecture design, database schema, core functionality, project coordination
Marie Claire U.	Frontend Developer / UI/UX Designer	HTML/CSS styling, responsive design, JavaScript interactions, live preview feature
Eric M.	Backend Developer / API Specialist	PHP controllers, database operations, API endpoints, authentication system
Diane I.	Database Administrator	Database design, optimization, data integrity, audit trail system
Olivier K.	Quality Assurance / Tester	Testing, bug fixes, validation, user acceptance testing
Development Contributions Breakdown
Component	Primary Contributor	Secondary
MVC Structure	Jean Paul N.	Eric M.
Frontend (HTML/CSS)	Marie Claire U.	Jean Paul N.
JavaScript (app.js)	Marie Claire U.	Olivier K.
PHP Controllers	Eric M.	Jean Paul N.
PHP Models	Eric M.	Diane I.
Database Schema	Diane I.	Eric M.
API Endpoints	Eric M.	Jean Paul N.
User Management	Eric M.	Jean Paul N.
Print Reports	Marie Claire U.	Olivier K.
Testing & Debugging	Olivier K.	All Members
Documentation	All Members	Jean Paul N.
Contact Information
Role	Email
Lead Developer	jean.n@umuganda.com
Frontend Developer	marie.u@umuganda.com
Backend Developer	eric.m@umuganda.com
Database Admin	diane.i@umuganda.com
QA Tester	olivier.k@umuganda.com
📁 Project Structure
text
umuganda-mvc/
├── .htaccess                          # URL rewriting (root)
├── public/
│   ├── .htaccess                      # Front controller routing
│   ├── index.php                      # Front controller
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css              # Main stylesheet (800+ lines)
│   │   └── js/
│   │       └── app.js                 # JavaScript (600+ lines)
│   ├── test_api.html                  # API testing tool
│   ├── test_db.php                    # Database testing
│   └── check_mod_rewrite.php          # Apache module checker
├── config/
│   ├── db.php                         # Database connection (PDO)
│   └── routes.php                     # URL routes definition
├── app/
│   ├── controllers/                   # PHP Controllers
│   │   ├── HomeController.php         # Public pages
│   │   ├── AuthController.php         # Login/authentication
│   │   ├── AdminController.php        # Admin dashboard (15+ methods)
│   │   ├── ApiController.php          # REST API endpoints
│   │   └── RequestController.php      # Request submission/tracking
│   ├── models/                        # PHP Models
│   │   ├── User.php                   # User CRUD operations
│   │   ├── Request.php                # Request CRUD operations
│   │   ├── Category.php               # Category operations
│   │   └── History.php                # Audit trail operations
│   └── views/                         # Templates
│       ├── layouts/
│       │   ├── main.php               # Public layout
│       │   ├── admin.php              # Admin layout
│       │   └── print.php              # Print layout
│       ├── home/
│       │   ├── index.php              # Homepage
│       │   ├── submit.php             # Submit form
│       │   └── track.php              # Track page
│       ├── admin/
│       │   ├── dashboard.php          # Admin dashboard
│       │   ├── requests.php           # All requests list
│       │   ├── view-request.php       # Request details
│       │   ├── reports.php            # Reports page
│       │   └── users.php              # User management
│       └── auth/
│           └── login.php              # Login page
├── database/
│   └── schema.sql                     # Complete database schema
└── docs/
    └── README.md                      # Documentation (this file)
🧪 Testing Checklist
After Installation, Verify:
Frontend Testing
Homepage loads with animated statistics

Submit a request with all fields

Live preview updates as you type

Receive ticket number after submission

Track request using ticket number

Status history displays correctly

Responsive design on mobile/tablet

Admin Testing
Login with admin/admin

Dashboard shows correct statistics

View all requests in table

Search and filter requests

View individual request details

Update request status (Pending → In Progress → Resolved)

Add notes to requests

View status history timeline

Generate and print reports

Export to PDF works

User Management Testing
View all users in table

Add new officer account

Change officer password

Remove/deactivate officer

Reactivate deactivated officer

Admin account is protected

Security Testing
Cannot access admin pages without login

Session expires after logout

Officer cannot access user management

SQL injection prevention works

XSS prevention works

🛠️ Troubleshooting Guide
Common Issues and Solutions
Issue	Possible Cause	Solution
Database connection failed	MySQL not running	Start MySQL in XAMPP Control Panel
Wrong database name	Verify database name is 'umuganda'
Wrong credentials	Check db.php username/password
404 Not Found	.htaccess not working	Enable mod_rewrite in Apache
Wrong file paths	Check asset paths start with /umuganda-mvc/public/
Login not working	Passwords not hashed	Run password fix SQL query
Session not started	Check session_start() in index.php
Blank white page	PHP error	Enable error reporting in index.php
Syntax error	Check Apache error logs
CSS not loading	Wrong path	Verify CSS link in layout files
.htaccess blocking	Check .htaccess rules
API endpoint not found	Route not defined	Add route in config/routes.php
Wrong HTTP method	Check if using GET/POST correctly
Cannot add officer	Database permission	Check users table write access
Duplicate username	Use unique username
Print report not working	JavaScript error	Check browser console
CSS media print	Verify print.css styles
Debugging Tools
Check PHP Version:
Create version.php:

php
<?php phpinfo(); ?>
Check Database Connection:
Visit http://localhost/umuganda-mvc/test_db.php

Check API Endpoints:
Visit http://localhost/umuganda-mvc/test_api.html

Check Apache mod_rewrite:
Visit http://localhost/umuganda-mvc/check_mod_rewrite.php

Enable Error Reporting:
Add to public/index.php:

php
error_reporting(E_ALL);
ini_set('display_errors', 1);
Check Apache Error Logs:
Location: C:\xampp\apache\logs\error.log

Check PHP Error Logs:
Location: C:\xampp\php\logs\php_error_log

Quick Commands
bash
# Windows - Check if Apache is running
netstat -an | find ":80"

# Windows - Check if MySQL is running
netstat -an | find "3306"

# Check if mod_rewrite is enabled
httpd -M | find "rewrite"
📞 Support
Technical Support Contacts
Issue Type	Contact	Response Time
Installation Issues	Lead Developer	24 hours
Bug Reports	QA Tester	48 hours
Feature Requests	Project Manager	72 hours
Database Issues	Database Admin	24 hours
API Issues	Backend Developer	48 hours
Reporting Issues
When reporting an issue, please include:

Error message (screenshot if possible)

Steps to reproduce

Browser and version

PHP version

MySQL version

Online Resources
Project Documentation: /docs/README.md

API Documentation: /docs/API.md

Database Schema: /database/schema.sql

Testing Tool: /public/test_api.html

📄 License
This project is developed for INES-Ruhengeri - Advanced Web Design Assignment

Copyright Information
© 2026 Umuganda Smart Platform

All rights reserved

Educational purposes only

🙏 Acknowledgments
Institutional
INES-Ruhengeri - For project requirements and academic guidance

Department of Computer Science - For technical support

Community
Rwandan Community - For inspiration and user personas

Umuganda Initiative - For the community service concept

Open Source
Font Awesome - For beautiful icons

Google Fonts - For typography

PHP Community - For excellent documentation

MySQL - For reliable database system

XAMPP - For easy local development

Individual Contributors
All team members for their dedication and hard work

Project supervisor for valuable feedback

Classmates for testing and suggestions

🎯 Project Status
Aspect	Status	Completion
Requirements Analysis	✅ Complete	100%
Database Design	✅ Complete	100%
MVC Architecture	✅ Complete	100%
Frontend Development	✅ Complete	100%
Backend Development	✅ Complete	100%
API Development	✅ Complete	100%
User Management	✅ Complete	100%
Reports Feature	✅ Complete	100%
Testing & Debugging	✅ Complete	100%
Documentation	✅ Complete	100%
Deployment	✅ Ready	100%
Overall Project Completion: 100% 🎉

📝 Version History
Version	Date	Changes
1.0.0	2026-05-10	Initial release with basic features
1.1.0	2026-05-12	Added admin dashboard
1.2.0	2026-05-13	Added user management
1.3.0	2026-05-14	Added print reports
2.0.0	2026-05-15	MVC architecture complete
🚀 Future Enhancements
Email notifications for status updates

SMS notifications for mobile users

Mobile app version

Multi-language support (Kinyarwanda, French)

Advanced analytics dashboard

Request assignment automation

File upload for evidence/photos

Rating system for resolved requests

Export to Excel/CSV

REST API for third-party integration

✅ Final Checklist Before Deployment
All files uploaded to server

Database imported successfully

Database credentials updated

.htaccess files configured

mod_rewrite enabled

PHP 7.4+ installed

MySQL 5.7+ installed

Session directory writable

Error reporting disabled in production

Backup system in place

SSL certificate installed (for HTTPS)

Security headers configured

Performance optimized

🎉 Congratulations!
Your Umuganda Smart Service Request Platform is now fully installed and ready to use!

Quick Start
Access the website: http://localhost/umuganda-mvc/

Login as Admin: username admin, password admin

Start managing service requests!

© 2026 Umuganda Smart Platform - Empowering communities through transparent service delivery.

