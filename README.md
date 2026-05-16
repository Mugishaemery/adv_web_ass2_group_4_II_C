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

## Verify Database Import
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

## 🔐 Login Credentials for Testing

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

Role Service Officer
What Each Role Can Do

Feature             	Admin	Officer
View Dashboard         	✅  	✅
View All Requests     	✅  	✅
Update Request Status	  ✅  	✅
Add Notes to Requests 	✅  	✅
View Reports          	✅  	✅
Print Reports         	✅  	✅
User Management       	✅  	❌
Add/Remove Officers    	✅  	❌
Change Any Password   	✅  	❌

## 🌐 Live Link

Local Access
text
http://localhost/umuganda-mvc/

## 👥 Team Members and Roles

Name                             Reg numbers                         	Role	
Blessing Pleasant Korvah          25/24766                         	    Manager 
MIZERO JOY Octavier               25/                          	Frontend Developer 
ISHIMWE Mugisha Emery             25/32638                      Backend Developer 
Uwase Sagamba jean arsen          25/27163                      Database Administrator	
Simon                        25/                          	Quality Assurance / Tester
NIYONKURU Promesse                25/                               Deployer


## 📁 Project Structure
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


## Open Source

Font Awesome - For beautiful icons

Google Fonts - For typography

PHP Community - For excellent documentation

MySQL - For reliable database system

XAMPP - For easy local development

Individual Contributors
All team members for their dedication and hard work

Project supervisor for valuable feedback

Classmates for testing and suggestions

## 🎯 Project Status

Aspect               	Status   	Completion
Requirements Analysis  	✅ Complete 	100%
Database Design     	✅ Complete 	100%
MVC Architecture    	✅ Complete 	100%
Frontend Development	✅ Complete 	100%
Backend Development	    ✅ Complete 	100%
API Development      	✅ Complete 	100%
User Management     	✅ Complete 	100%
Reports Feature     	✅ Complete  	100%
Testing & Debugging  	✅ Complete 	100%
Documentation       	✅ Complete  	100%
Deployment           	✅ Ready    	100%

Overall Project Completion: 100% 🎉


🎉 Congratulations!
Your Umuganda Smart Service Request Platform is now fully installed and ready to use!

Quick Start
Access the website: https://umuganda-smart-plattform.rf.gd
Login as Admin: username admin, password admin

© 2026 Umuganda Smart Platform - Empowering communities through transparent service delivery.

