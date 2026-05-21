// Admin Panel JavaScript

// Navigation
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all nav items
        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.remove('active');
        });
        
        // Add active class to clicked item
        this.classList.add('active');
        
        // Hide all pages
        document.querySelectorAll('.page-content').forEach(page => {
            page.classList.remove('active');
        });
        
        // Show selected page
        const pageName = this.dataset.page;
        const pageEl = document.getElementById(pageName + '-page');
        if (pageEl) {
            pageEl.classList.add('active');
            
            // Load data
            if (pageName === 'pages') loadPages();
            if (pageName === 'teams') loadTeams();
            if (pageName === 'news') loadNews();
            if (pageName === 'users') loadUsers();
        }
    });
});

// Modal functions
function openModal(title) {
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal').classList.add('active');
    document.getElementById('modal-overlay').classList.add('active');
}

function closeModal() {
    document.getElementById('modal').classList.remove('active');
    document.getElementById('modal-overlay').classList.remove('active');
}

// Pages Management
function loadPages() {
    fetch('/backend/api/pages.php?action=get')
        .then(res => res.json())
        .then(data => {
            const tableBody = document.getElementById('pages-table');
            
            if (data.success && data.data.length > 0) {
                tableBody.innerHTML = data.data.map(page => `
                    <tr>
                        <td>${page.title}</td>
                        <td><code>${page.slug}</code></td>
                        <td><span class="badge badge-${page.status}">${page.status}</span></td>
                        <td>${page.author_id || 'N/A'}</td>
                        <td>${new Date(page.created_at).toLocaleDateString()}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-secondary btn-small" onclick="editPage(${page.id})">Edit</button>
                                <button class="btn btn-danger btn-small" onclick="deletePage(${page.id})">Delete</button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } else {
                tableBody.innerHTML = '<tr><td colspan="6">No pages found.</td></tr>';
            }
        });
}

function openPageModal() {
    openModal('Add New Page');
    document.getElementById('modal-content').innerHTML = `
        <form onsubmit="savePage(event)">
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="page_title" required>
            </div>
            <div class="form-group">
                <label>Slug</label>
                <input type="text" id="page_slug" required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea id="page_content" required></textarea>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="page_description"></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="page_status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Page</button>
            </div>
        </form>
    `;
}

function savePage(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('action', 'create');
    formData.append('title', document.getElementById('page_title').value);
    formData.append('slug', document.getElementById('page_slug').value);
    formData.append('content', document.getElementById('page_content').value);
    formData.append('description', document.getElementById('page_description').value);
    formData.append('status', document.getElementById('page_status').value);
    
    fetch('/backend/api/pages.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Page saved successfully!');
            closeModal();
            loadPages();
        } else {
            alert('Error saving page: ' + (data.message || 'Unknown error'));
        }
    });
}

function editPage(id) {
    fetch('/backend/api/pages.php?action=get&id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const page = data.data;
                openModal('Edit Page');
                document.getElementById('modal-content').innerHTML = `
                    <form onsubmit="updatePage(${id}, event)">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" id="page_title" value="${page.title}" required>
                        </div>
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" id="page_slug" value="${page.slug}" required>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea id="page_content" required>${page.content}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="page_description">${page.description || ''}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="page_status">
                                <option value="draft" ${page.status === 'draft' ? 'selected' : ''}>Draft</option>
                                <option value="published" ${page.status === 'published' ? 'selected' : ''}>Published</option>
                            </select>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Page</button>
                        </div>
                    </form>
                `;
            }
        });
}

function updatePage(id, e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', id);
    formData.append('title', document.getElementById('page_title').value);
    formData.append('slug', document.getElementById('page_slug').value);
    formData.append('content', document.getElementById('page_content').value);
    formData.append('description', document.getElementById('page_description').value);
    formData.append('status', document.getElementById('page_status').value);
    
    fetch('/backend/api/pages.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Page updated successfully!');
            closeModal();
            loadPages();
        } else {
            alert('Error updating page');
        }
    });
}

function deletePage(id) {
    if (confirm('Are you sure you want to delete this page?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        
        fetch('/backend/api/pages.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Page deleted successfully!');
                loadPages();
            }
        });
    }
}

// Teams Management
function loadTeams() {
    fetch('/backend/api/teams.php?action=get')
        .then(res => res.json())
        .then(data => {
            const tableBody = document.getElementById('teams-table');
            
            if (data.success && data.data.length > 0) {
                tableBody.innerHTML = data.data.map(team => `
                    <tr>
                        <td>${team.name}</td>
                        <td>${team.coach_name || 'N/A'}</td>
                        <td><span class="badge badge-${team.status}">${team.status}</span></td>
                        <td>${new Date(team.created_at).toLocaleDateString()}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-secondary btn-small" onclick="editTeam(${team.id})">Edit</button>
                                <button class="btn btn-danger btn-small" onclick="deleteTeam(${team.id})">Delete</button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } else {
                tableBody.innerHTML = '<tr><td colspan="5">No teams found.</td></tr>';
            }
        });
}

function openTeamModal() {
    openModal('Add New Team');
    document.getElementById('modal-content').innerHTML = `
        <form onsubmit="saveTeam(event)">
            <div class="form-group">
                <label>Team Name</label>
                <input type="text" id="team_name" required>
            </div>
            <div class="form-group">
                <label>Coach Name</label>
                <input type="text" id="team_coach" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="team_desc"></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="team_status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Team</button>
            </div>
        </form>
    `;
}

function saveTeam(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('action', 'create');
    formData.append('name', document.getElementById('team_name').value);
    formData.append('coach_name', document.getElementById('team_coach').value);
    formData.append('description', document.getElementById('team_desc').value);
    formData.append('status', document.getElementById('team_status').value);
    
    fetch('/backend/api/teams.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Team saved successfully!');
            closeModal();
            loadTeams();
        }
    });
}

function editTeam(id) {
    fetch('/backend/api/teams.php?action=get&id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const team = data.data;
                openModal('Edit Team');
                document.getElementById('modal-content').innerHTML = `
                    <form onsubmit="updateTeam(${id}, event)">
                        <div class="form-group">
                            <label>Team Name</label>
                            <input type="text" id="team_name" value="${team.name}" required>
                        </div>
                        <div class="form-group">
                            <label>Coach Name</label>
                            <input type="text" id="team_coach" value="${team.coach_name || ''}" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="team_desc">${team.description || ''}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select id="team_status">
                                <option value="active" ${team.status === 'active' ? 'selected' : ''}>Active</option>
                                <option value="inactive" ${team.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                            </select>
                        </div>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Team</button>
                        </div>
                    </form>
                `;
            }
        });
}

function updateTeam(id, e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', id);
    formData.append('name', document.getElementById('team_name').value);
    formData.append('coach_name', document.getElementById('team_coach').value);
    formData.append('description', document.getElementById('team_desc').value);
    formData.append('status', document.getElementById('team_status').value);
    
    fetch('/backend/api/teams.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Team updated successfully!');
            closeModal();
            loadTeams();
        }
    });
}

function deleteTeam(id) {
    if (confirm('Are you sure you want to delete this team?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);
        
        fetch('/backend/api/teams.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Team deleted successfully!');
                loadTeams();
            }
        });
    }
}

// News Management
function loadNews() {
    document.getElementById('news-table').innerHTML = '<tr><td colspan="6">News management coming soon...</td></tr>';
}

function openNewsModal() {
    openModal('Add New Article');
    document.getElementById('modal-content').innerHTML = `<p>News module coming soon...</p>`;
}

// Users Management
function loadUsers() {
    document.getElementById('users-table').innerHTML = '<tr><td colspan="6">User management coming soon...</td></tr>';
}

function openUserModal() {
    openModal('Add New User');
    document.getElementById('modal-content').innerHTML = `<p>User module coming soon...</p>`;
}

// Logout
function logout() {
    fetch('/backend/api/auth.php?action=logout')
        .then(() => {
            window.location.href = 'login.php';
        });
}

// Close modal on overlay click
document.addEventListener('click', function(e) {
    if (e.target.id === 'modal-overlay') {
        closeModal();
    }
});

// Add CSS for badges
const style = document.createElement('style');
style.textContent = `
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-published, .badge-active {
        background: #d4edda;
        color: #155724;
    }
    .badge-draft, .badge-inactive {
        background: #fff3cd;
        color: #856404;
    }
    .badge-archived {
        background: #e2e3e5;
        color: #383d41;
    }
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }
    select:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
    }
`;
document.head.appendChild(style);
