# Tournament Management System - Backend Setup Guide

## Overview

Complete PHP backend system with MySQL database and admin panel for managing:
- **Pages** - Create and manage website content
- **Teams** - Manage tournament teams
- **News** - Post tournament news and articles
- **Users** - Admin user management
- **Settings** - Site configuration
- **File Uploads** - Image and document uploads

## Project Structure

```
backend/
├── config/
│   ├── database.php       # Database configuration & connection class
│   └── setup.sql          # Database schema and initial data
├── includes/
│   ├── User.php           # User authentication & management
│   ├── Page.php           # Page/content management
│   └── Team.php           # Team management
├── api/
│   ├── auth.php           # Authentication API endpoints
│   ├── pages.php          # Pages API endpoints
│   ├── teams.php          # Teams API endpoints
│   └── upload.php         # File upload endpoint
├── admin/
│   ├── index.php          # Admin dashboard
│   ├── login.php          # Admin login page
│   └── assets/
│       ├── style.css      # Admin panel styling
│       └── script.js      # Admin panel functionality
└── uploads/               # Uploaded files directory
```

## Setup Instructions

### 1. Database Setup

#### Option A: Using phpMyAdmin
1. Open phpMyAdmin in your browser (usually `http://localhost/phpmyadmin`)
2. Create a new database named `turneu_db`
3. Select the database and go to the "SQL" tab
4. Copy the contents of `backend/config/setup.sql`
5. Paste and execute

#### Option B: Using Command Line
```bash
cd c:\Users\Student\Desktop\pppp\turneu1\backend\config
mysql -u root -p < setup.sql
```

#### Option C: Manual Setup
- Create database: `CREATE DATABASE turneu_db;`
- Run the SQL commands from `setup.sql` file

### 2. Web Server Setup

#### Using XAMPP (Windows)
1. Place the project in `C:\xampp\htdocs\turneu1`
2. Start Apache and MySQL from XAMPP Control Panel
3. Access at `http://localhost/turneu1`

#### Using Built-in PHP Server
```bash
cd c:\Users\Student\Desktop\pppp\turneu1
php -S localhost:8000
```
Then access at `http://localhost:8000`

### 3. Admin Login

Navigate to: `http://localhost/turneu1/backend/admin/login.php`

**Default credentials:**
- **Username:** `admin`
- **Password:** `admin123`

⚠️ **Change these credentials after first login!**

## API Endpoints

### Authentication
- `POST /backend/api/auth.php?action=login` - Login user
- `GET /backend/api/auth.php?action=logout` - Logout user
- `GET /backend/api/auth.php?action=check` - Check login status
- `POST /backend/api/auth.php?action=register` - Register new user

### Pages
- `GET /backend/api/pages.php?action=get` - Get all pages
- `GET /backend/api/pages.php?action=get&id=1` - Get specific page
- `GET /backend/api/pages.php?action=published` - Get published pages
- `POST /backend/api/pages.php?action=create` - Create new page
- `POST /backend/api/pages.php?action=update` - Update page
- `POST /backend/api/pages.php?action=delete` - Delete page

### Teams
- `GET /backend/api/teams.php?action=get` - Get all teams
- `GET /backend/api/teams.php?action=get&id=1` - Get specific team
- `POST /backend/api/teams.php?action=create` - Create new team
- `POST /backend/api/teams.php?action=update` - Update team
- `POST /backend/api/teams.php?action=delete` - Delete team

### File Upload
- `POST /backend/api/upload.php` - Upload file (requires authentication)

## Database Tables

### Users
- `id` - User ID
- `username` - Unique username
- `password` - Hashed password (bcrypt)
- `email` - User email
- `fullname` - Full name
- `role` - admin or editor
- `status` - active or inactive
- `created_at` - Account creation date

### Pages
- `id` - Page ID
- `title` - Page title
- `slug` - URL-friendly slug
- `content` - Page content
- `description` - Short description
- `featured_image` - Image filename
- `status` - published, draft, or archived
- `seo_title` - SEO title tag
- `seo_description` - SEO meta description
- `seo_keywords` - SEO keywords
- `author_id` - User ID of author
- `created_at` - Creation date
- `updated_at` - Last update date

### Teams
- `id` - Team ID
- `name` - Team name
- `description` - Team description
- `logo` - Logo filename
- `coach_name` - Coach name
- `status` - active or inactive
- `created_at` - Creation date

### Matches
- `id` - Match ID
- `team1_id` - First team ID
- `team2_id` - Second team ID
- `match_date` - Match date/time
- `location` - Match location
- `team1_score` - Team 1 score
- `team2_score` - Team 2 score
- `status` - scheduled, live, or finished
- `created_at` - Creation date

### News
- `id` - Article ID
- `title` - Article title
- `content` - Article content
- `featured_image` - Featured image
- `category` - Article category
- `author_id` - Author user ID
- `status` - published or draft
- `views` - View count
- `created_at` - Creation date

### Settings
- `id` - Setting ID
- `setting_key` - Setting name
- `setting_value` - Setting value
- `created_at` - Creation date

## Using the Admin Panel

### Dashboard
- View basic statistics about content

### Pages
- **Add New Page:** Click "Add New Page" button, fill in details, and save
- **Edit Page:** Click "Edit" button in the table
- **Delete Page:** Click "Delete" button to remove page
- **Status:** Set as Draft or Published

### Teams
- **Add Team:** Click "Add New Team"
- **Edit Team:** Modify team information
- **Delete Team:** Remove team from system
- **Coach Management:** Add coach name for each team

### File Uploads
- Upload images and documents using the file upload API
- Maximum file size: 5MB
- Allowed formats: jpg, jpeg, png, gif, pdf, doc, docx

## Frontend Integration

### Displaying Published Pages
```javascript
// Fetch published pages from frontend
fetch('/backend/api/pages.php?action=published&limit=10')
    .then(res => res.json())
    .then(data => {
        // Display data in your frontend
        data.data.forEach(page => {
            console.log(page.title, page.content);
        });
    });
```

### Displaying Teams
```javascript
// Fetch all teams
fetch('/backend/api/teams.php?action=get')
    .then(res => res.json())
    .then(data => {
        // Display teams
        data.data.forEach(team => {
            console.log(team.name, team.coach_name);
        });
    });
```

## Security Considerations

1. **Change Default Password:** First thing to do after setup
2. **Use HTTPS:** Enable SSL/TLS on production
3. **Database Credentials:** Update `database.php` with strong credentials
4. **File Permissions:** Set proper permissions on `uploads` folder
5. **Session Security:** Configure session settings in production
6. **Input Validation:** All inputs are validated and escaped

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running
- Check credentials in `backend/config/database.php`
- Verify database `turneu_db` exists

### Login Not Working
- Clear browser cookies
- Check if `admin` user exists in `users` table
- Verify MySQL/PHP connection

### File Upload Not Working
- Check folder permissions on `backend/uploads/`
- Ensure PHP file upload settings are configured
- Verify file size limits

### Admin Panel Not Loading
- Check browser console for JavaScript errors
- Verify API endpoints are accessible
- Check PHP error logs

## Next Steps

1. ✅ Set up database
2. ✅ Configure web server
3. ✅ Login to admin panel
4. ✅ Create content pages
5. ✅ Add teams
6. ✅ Configure site settings
7. ✅ Connect frontend to API endpoints

## Support

For issues or questions about the backend system, check:
- PHP error logs
- MySQL error logs
- Browser console (F12)
- API response messages

## License

This backend system is provided for the tournament website project.
