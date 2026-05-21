# Quick Start Guide - Tournament Website Backend

## 📋 What You Just Got

A complete PHP backend system with:
- ✅ MySQL Database
- ✅ Admin Panel for content management
- ✅ REST API for frontend integration
- ✅ User authentication
- ✅ File upload system
- ✅ Team management
- ✅ Pages/content management

## 🚀 Quick Setup (3 Steps)

### Step 1: Create the Database
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create database named: `turneu_db`
3. Open the "SQL" tab
4. Copy all content from: `backend/config/setup.sql`
5. Paste and execute

**OR** Run in terminal:
```
mysql -u root -p < backend\config\setup.sql
```

### Step 2: Access Admin Panel
Visit: `http://localhost/turneu1/backend/admin/login.php`

**Default Login:**
- Username: `admin`
- Password: `admin123`

### Step 3: Change Admin Password
1. Login to admin panel
2. Go to Users section
3. Edit admin user
4. Change password to something secure

## 📁 File Structure

```
turneu1/
├── index.html                 # Your frontend (existing)
├── api-integration.js         # JavaScript for connecting frontend to backend
└── backend/
    ├── admin/
    │   ├── login.php         # Admin login page
    │   ├── index.php         # Admin dashboard
    │   └── assets/
    │       ├── style.css     # Admin styling
    │       └── script.js     # Admin functionality
    ├── api/
    │   ├── auth.php          # User authentication
    │   ├── pages.php         # Content management API
    │   ├── teams.php         # Teams API
    │   └── upload.php        # File uploads
    ├── config/
    │   ├── database.php      # Database connection
    │   └── setup.sql         # Database schema
    ├── includes/
    │   ├── User.php          # User class
    │   ├── Page.php          # Page class
    │   └── Team.php          # Team class
    ├── uploads/              # User uploads (images, docs)
    └── README.md             # Full documentation
```

## 🎯 What You Can Do Now

### In Admin Panel
- ✅ Create/edit/delete pages
- ✅ Manage teams
- ✅ Upload images and files
- ✅ Configure site settings
- ✅ Manage admin users

### In Frontend (Your index.html)
- ✅ Display dynamic content from database
- ✅ Show team list from database
- ✅ Fetch news articles
- ✅ Use REST APIs to get content

## 🔗 Connect Frontend to Backend

Add this one line to your `index.html` before closing `</body>`:

```html
<script src="api-integration.js"></script>
```

Then use these functions:

```javascript
// Display all pages
displayPages('pages-container');

// Display all teams
displayTeams('teams-container');

// Get single page content
displayPageContent(pageId);
```

## 📊 Admin Panel Features

### Pages Manager
- Create unlimited pages
- Set as draft or published
- SEO title, description, keywords
- Feature images
- Rich HTML content

### Teams Manager
- Add tournament teams
- Set coach names
- Add team descriptions
- Upload team logos
- Activate/deactivate teams

### Settings
- Site title and description
- Contact information
- Social media links
- Email configuration

## 🔒 Security

**Important: Change Default Password!**
1. Login with default credentials
2. Edit admin user profile
3. Change password to something strong

**Database Credentials** (in `backend/config/database.php`):
- Username: `root`
- Password: `` (empty)
- Host: `localhost`

Change these for production!

## 🌐 API Endpoints

### Get Published Pages
```
GET /backend/api/pages.php?action=published
```

### Get All Teams
```
GET /backend/api/teams.php?action=get
```

### Upload File
```
POST /backend/api/upload.php
```

See `backend/README.md` for complete API documentation.

## 📱 Mobile Responsive Admin Panel
The admin panel works on:
- ✅ Desktop (full features)
- ✅ Tablet (optimized layout)
- ✅ Mobile (touch-friendly)

## ⚙️ Configuration

### Database Settings
File: `backend/config/database.php`
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'turneu_db');
```

### Upload Limits
File: `backend/api/upload.php`
- Max file size: 5MB
- Allowed types: jpg, jpeg, png, gif, pdf, doc, docx

## 🆘 Troubleshooting

### Login doesn't work
- ✓ Verify MySQL is running
- ✓ Check database was created
- ✓ Check database credentials in `database.php`

### API returns 404
- ✓ Check file paths
- ✓ Verify PHP is running
- ✓ Check web server configuration

### Pages don't show
- ✓ Create pages in admin panel first
- ✓ Make sure pages are "published" status
- ✓ Check browser console for errors (F12)

## 📚 Next Steps

1. **Create some pages** in admin panel
2. **Add some teams** with coach info
3. **Upload images** for teams/pages
4. **Integrate API** in your frontend
5. **Customize** admin panel styling as needed
6. **Deploy** to your web host

## 🎓 Learning Resources

- **Admin Panel:** `backend/admin/index.php`
- **API Examples:** `backend/README.md`
- **Frontend Integration:** `api-integration.js`
- **Database Schema:** `backend/config/setup.sql`

## 📞 Support

For detailed documentation, see:
- `backend/README.md` - Complete backend guide
- `api-integration.js` - Frontend integration examples
- `backend/admin/` - Admin panel code

## ✨ You're All Set!

Your tournament website now has:
✅ Professional admin panel
✅ Dynamic database-driven content
✅ Secure authentication
✅ File management
✅ Team management
✅ Scalable API

Enjoy! 🎉

---

**Remember:** Always backup your database before making major changes!
