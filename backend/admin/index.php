<?php
/**
 * Admin Dashboard
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tournament Management</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="#dashboard" class="nav-item active" data-page="dashboard">
                    <span class="icon">📊</span> Dashboard
                </a>
                <a href="#pages" class="nav-item" data-page="pages">
                    <span class="icon">📄</span> Pages
                </a>
                <a href="#teams" class="nav-item" data-page="teams">
                    <span class="icon">👥</span> Teams
                </a>
                <a href="#news" class="nav-item" data-page="news">
                    <span class="icon">📰</span> News
                </a>
                <a href="#users" class="nav-item" data-page="users">
                    <span class="icon">👤</span> Users
                </a>
                <a href="#settings" class="nav-item" data-page="settings">
                    <span class="icon">⚙️</span> Settings
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <p><?php echo htmlspecialchars($user['fullname']); ?></p>
                    <small><?php echo ucfirst($user['role']); ?></small>
                </div>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <h1>Tournament Management System</h1>
                <div class="user-menu">
                    <span>Welcome, <?php echo htmlspecialchars($user['username']); ?></span>
                </div>
            </header>

            <div class="content-area">
                <!-- Dashboard -->
                <div id="dashboard-page" class="page-content active">
                    <h2>Dashboard</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h3>Total Pages</h3>
                            <p class="stat-number">0</p>
                        </div>
                        <div class="stat-card">
                            <h3>Total Teams</h3>
                            <p class="stat-number">0</p>
                        </div>
                        <div class="stat-card">
                            <h3>Total News</h3>
                            <p class="stat-number">0</p>
                        </div>
                        <div class="stat-card">
                            <h3>Total Users</h3>
                            <p class="stat-number">0</p>
                        </div>
                    </div>
                </div>

                <!-- Pages Management -->
                <div id="pages-page" class="page-content">
                    <div class="page-header">
                        <h2>Pages Management</h2>
                        <button class="btn btn-primary" onclick="openPageModal()">Add New Page</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="pages-table">
                            <tr><td colspan="6">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Teams Management -->
                <div id="teams-page" class="page-content">
                    <div class="page-header">
                        <h2>Teams Management</h2>
                        <button class="btn btn-primary" onclick="openTeamModal()">Add New Team</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Coach</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teams-table">
                            <tr><td colspan="5">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- News Management -->
                <div id="news-page" class="page-content">
                    <div class="page-header">
                        <h2>News Management</h2>
                        <button class="btn btn-primary" onclick="openNewsModal()">Add New Article</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="news-table">
                            <tr><td colspan="6">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Users Management -->
                <div id="users-page" class="page-content">
                    <div class="page-header">
                        <h2>Users Management</h2>
                        <button class="btn btn-primary" onclick="openUserModal()">Add New User</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-table">
                            <tr><td colspan="6">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Settings -->
                <div id="settings-page" class="page-content">
                    <h2>Site Settings</h2>
                    <form id="settings-form" class="settings-form">
                        <div class="form-group">
                            <label>Site Title</label>
                            <input type="text" id="site_title" placeholder="Site Title">
                        </div>
                        <div class="form-group">
                            <label>Site Description</label>
                            <textarea id="site_description" placeholder="Site Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Contact Email</label>
                            <input type="email" id="contact_email" placeholder="Contact Email">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" id="phone" placeholder="Phone">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" id="address" placeholder="Address">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Modals -->
    <div id="modal-overlay" class="modal-overlay" onclick="closeModal()"></div>
    <div id="modal" class="modal">
        <div class="modal-header">
            <h3 id="modal-title">Edit Item</h3>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <div id="modal-content" class="modal-content"></div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
