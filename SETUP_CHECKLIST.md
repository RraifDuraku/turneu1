# Setup Checklist - Complete Backend System

Use this checklist to ensure everything is properly configured.

---

## ✅ Pre-Setup Requirements

- [ ] **PHP 7.4+** installed and running
- [ ] **MySQL 5.7+** installed and running
- [ ] **Web server** (Apache, Nginx, or PHP Built-in)
- [ ] **phpMyAdmin** or MySQL CLI access
- [ ] **Text editor/IDE** for making changes if needed

---

## 📦 Installation Checklist

### Phase 1: File Creation ✓ DONE
- [x] Created `backend/` directory structure
- [x] Created PHP classes for User, Page, Team management
- [x] Created API endpoints for auth, pages, teams, upload
- [x] Created admin panel with login and dashboard
- [x] Created admin styling and JavaScript
- [x] Created API integration file for frontend

### Phase 2: Database Setup

- [ ] **Create Database**
  - [ ] Open phpMyAdmin or terminal
  - [ ] Create new database: `turneu_db`
  - [ ] Import `backend/config/setup.sql`
  - [ ] Verify all tables created (users, pages, teams, matches, news, etc.)
  - [ ] Check default admin user exists

**Commands to run:**
```bash
# MySQL CLI method:
mysql -u root -p < backend\config\setup.sql

# Or use phpMyAdmin:
# 1. Create database "turneu_db"
# 2. Go to SQL tab
# 3. Paste contents of backend/config/setup.sql
# 4. Execute
```

### Phase 3: Web Server Setup

- [ ] **XAMPP Users:**
  - [ ] Move project to `C:\xampp\htdocs\turneu1\`
  - [ ] Start Apache from XAMPP Control Panel
  - [ ] Start MySQL from XAMPP Control Panel
  - [ ] Test: Visit `http://localhost/turneu1`

- [ ] **PHP Built-in Server:**
  - [ ] Open terminal in project directory
  - [ ] Run: `php -S localhost:8000`
  - [ ] Test: Visit `http://localhost:8000`

- [ ] **Other Servers:**
  - [ ] Copy project to your web root
  - [ ] Configure virtual host or path mapping
  - [ ] Ensure PHP and MySQL are running
  - [ ] Test web access

### Phase 4: Database Configuration

- [ ] **Verify Database Connection**
  - [ ] Check: `backend/config/database.php`
  - [ ] Verify DB_HOST = `localhost`
  - [ ] Verify DB_USER = `root` (or your user)
  - [ ] Verify DB_PASS = `` (empty) or your password
  - [ ] Verify DB_NAME = `turneu_db`

- [ ] **Update if needed:**
  ```php
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');  // Add password if needed
  define('DB_NAME', 'turneu_db');
  ```

### Phase 5: Admin Panel Access

- [ ] **Login to Admin Panel**
  - [ ] Visit: `http://localhost/turneu1/backend/admin/login.php`
  - [ ] Enter credentials:
    - Username: `admin`
    - Password: `admin123`
  - [ ] Successfully logs in to dashboard

- [ ] **Test Admin Features**
  - [ ] Can see Dashboard page
  - [ ] Can access Pages section
  - [ ] Can access Teams section
  - [ ] Can access Settings section

### Phase 6: Security Configuration

- [ ] **Change Default Password**
  - [ ] Login with admin/admin123
  - [ ] Go to Users section
  - [ ] Edit admin user
  - [ ] Change password to something secure
  - [ ] Save changes

- [ ] **Update Database Credentials (Production)**
  - [ ] Plan strong DB user credentials
  - [ ] Update `backend/config/database.php`
  - [ ] Create new DB user in MySQL
  - [ ] Test connection still works

- [ ] **Set File Permissions**
  - [ ] Make `backend/uploads/` writable (755)
  - [ ] Make `backend/config/` readable (644)
  - [ ] Make `backend/admin/` readable (644)

### Phase 7: API Testing

- [ ] **Test Auth API**
  - [ ] Visit: `http://localhost/turneu1/backend/api/auth.php?action=check`
  - [ ] Should return JSON response

- [ ] **Test Pages API**
  - [ ] Visit: `http://localhost/turneu1/backend/api/pages.php?action=get`
  - [ ] Should return JSON with pages data

- [ ] **Test Teams API**
  - [ ] Visit: `http://localhost/turneu1/backend/api/teams.php?action=get`
  - [ ] Should return JSON with teams data

- [ ] **Test Upload API**
  - [ ] Try uploading a file from admin panel
  - [ ] File should appear in `backend/uploads/`

### Phase 8: Frontend Integration

- [ ] **Add Integration Script**
  - [ ] Copy `api-integration.js` to your frontend directory
  - [ ] Add to index.html: `<script src="api-integration.js"></script>`

- [ ] **Test Data Fetching**
  - [ ] Create a test page in admin panel (mark as published)
  - [ ] Create a test team in admin panel
  - [ ] Verify APIs return the data
  - [ ] Test frontend functions:
    ```javascript
    getPages().then(pages => console.log(pages));
    getTeams().then(teams => console.log(teams));
    ```

---

## 📝 Data Entry Checklist

- [ ] **Add Initial Content**
  - [ ] Create 2-3 sample pages
  - [ ] Create tournament teams
  - [ ] Add coaches to teams
  - [ ] Upload team logos (optional)

- [ ] **Configure Site Settings**
  - [ ] Set Site Title
  - [ ] Set Site Description
  - [ ] Add Contact Email
  - [ ] Add Phone Number
  - [ ] Add Address
  - [ ] Add Social Media Links

- [ ] **Test Publishing**
  - [ ] Create a page and set to "Draft"
  - [ ] Verify it's NOT visible in public API
  - [ ] Change to "Published"
  - [ ] Verify it appears in public API

---

## 🧪 Testing Checklist

- [ ] **Admin Panel Tests**
  - [ ] Login works
  - [ ] Can create pages
  - [ ] Can edit pages
  - [ ] Can delete pages
  - [ ] Can create teams
  - [ ] Can edit teams
  - [ ] Can delete teams
  - [ ] Can upload files
  - [ ] Can save settings

- [ ] **API Tests**
  - [ ] Auth endpoints work
  - [ ] Pages endpoints work
  - [ ] Teams endpoints work
  - [ ] Upload endpoint works
  - [ ] Authentication required for admin actions

- [ ] **Frontend Tests**
  - [ ] Can fetch published pages
  - [ ] Can fetch teams
  - [ ] Can display content
  - [ ] Pages display correctly
  - [ ] Teams display correctly

- [ ] **Error Handling**
  - [ ] Invalid login returns error
  - [ ] 404 on missing page
  - [ ] Proper error messages shown
  - [ ] Console shows no critical errors

---

## 🚀 Deployment Checklist (Before Going Live)

- [ ] **Security**
  - [ ] Changed default admin password
  - [ ] Updated database credentials
  - [ ] Set proper file permissions
  - [ ] Enabled HTTPS/SSL
  - [ ] Removed setup files if not needed

- [ ] **Performance**
  - [ ] Tested page load times
  - [ ] Optimized images
  - [ ] Minified CSS/JS if needed
  - [ ] Database indexes created

- [ ] **Backups**
  - [ ] Setup automated database backups
  - [ ] Setup file backups
  - [ ] Document backup procedure
  - [ ] Test restore process

- [ ] **Monitoring**
  - [ ] Setup error logging
  - [ ] Setup uptime monitoring
  - [ ] Setup backup verification
  - [ ] Document support process

---

## 📋 Quick Troubleshooting

| Issue | Checklist |
|-------|-----------|
| Can't connect to database | [ ] MySQL running [ ] DB created [ ] Credentials correct [ ] Check error logs |
| Admin panel blank | [ ] Check browser console (F12) [ ] Check PHP errors [ ] Verify API endpoints [ ] Test API directly |
| Pages don't show | [ ] Create page in admin [ ] Set to published [ ] Check API response [ ] Check JavaScript console |
| File upload fails | [ ] Check uploads folder exists [ ] Check folder permissions [ ] Check file size [ ] Check file type |
| Login fails | [ ] Admin user exists [ ] Password correct [ ] Session enabled [ ] Check cookies |

---

## 📞 Support Resources

- **Documentation:** `backend/README.md`
- **Quick Start:** `QUICKSTART.md`
- **System Summary:** `SYSTEM_SUMMARY.md`
- **API Examples:** `api-integration.js`
- **Database Schema:** `backend/config/setup.sql`

---

## ✨ Completion Status

When you've checked ALL items in this list, your backend system is:
- ✅ Fully installed
- ✅ Properly configured
- ✅ Security hardened
- ✅ Ready for production

---

## 🎯 Next: Create Content

Once everything is checked off:
1. Login to admin panel
2. Create your tournament pages
3. Add your teams
4. Upload images
5. Configure settings
6. Test frontend integration

---

**Date Checked:** _______________

**Checked By:** _______________

**Status:** [ ] Ready [ ] Needs Work [ ] In Progress

---

Good luck! 🏆
