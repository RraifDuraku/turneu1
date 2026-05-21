/**
 * Frontend API Integration Guide
 * 
 * This file shows how to connect your frontend (index.html) with the backend APIs
 * Copy these functions to your frontend JavaScript
 */

// ============================================
// API CONFIGURATION
// ============================================

const API_BASE = '/backend/api';

// ============================================
// PAGES API
// ============================================

/**
 * Get all published pages
 * @param {number} limit - Number of pages to fetch
 * @param {number} offset - Pagination offset
 */
async function getPages(limit = 10, offset = 0) {
    try {
        const response = await fetch(`${API_BASE}/pages.php?action=published&limit=${limit}&offset=${offset}`);
        const data = await response.json();
        return data.data || [];
    } catch (error) {
        console.error('Error fetching pages:', error);
        return [];
    }
}

/**
 * Get single page by ID
 * @param {number} id - Page ID
 */
async function getPage(id) {
    try {
        const response = await fetch(`${API_BASE}/pages.php?action=get&id=${id}`);
        const data = await response.json();
        return data.data || null;
    } catch (error) {
        console.error('Error fetching page:', error);
        return null;
    }
}

/**
 * Get page by slug (URL-friendly name)
 */
async function getPageBySlug(slug) {
    const pages = await getPages(1000);
    return pages.find(p => p.slug === slug) || null;
}

// ============================================
// TEAMS API
// ============================================

/**
 * Get all teams
 */
async function getTeams() {
    try {
        const response = await fetch(`${API_BASE}/teams.php?action=get`);
        const data = await response.json();
        return data.data || [];
    } catch (error) {
        console.error('Error fetching teams:', error);
        return [];
    }
}

/**
 * Get single team by ID
 */
async function getTeam(id) {
    try {
        const response = await fetch(`${API_BASE}/teams.php?action=get&id=${id}`);
        const data = await response.json();
        return data.data || null;
    } catch (error) {
        console.error('Error fetching team:', error);
        return null;
    }
}

// ============================================
// AUTHENTICATION API
// ============================================

/**
 * Check if user is logged in
 */
async function checkAuth() {
    try {
        const response = await fetch(`${API_BASE}/auth.php?action=check`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error checking auth:', error);
        return { loggedIn: false };
    }
}

/**
 * Login user (for admin area)
 */
async function loginUser(username, password) {
    try {
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        
        const response = await fetch(`${API_BASE}/auth.php?action=login`, {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error logging in:', error);
        return { success: false, message: 'Login failed' };
    }
}

// ============================================
// EXAMPLE: Display Pages in HTML
// ============================================

/**
 * Display pages from database
 * Usage: Call this function to populate a pages section
 */
async function displayPages(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    const pages = await getPages();
    
    if (pages.length === 0) {
        container.innerHTML = '<p>No pages found.</p>';
        return;
    }
    
    let html = '';
    pages.forEach(page => {
        html += `
            <div class="page-item">
                <h3>${page.title}</h3>
                <p>${page.description || page.content.substring(0, 150)}...</p>
                <a href="page.html?id=${page.id}">Read More</a>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

/**
 * Display teams in a grid
 * Usage: displayTeams('teams-container')
 */
async function displayTeams(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    const teams = await getTeams();
    
    if (teams.length === 0) {
        container.innerHTML = '<p>No teams found.</p>';
        return;
    }
    
    let html = '';
    teams.forEach(team => {
        html += `
            <div class="team-card">
                ${team.logo ? `<img src="${team.logo}" alt="${team.name}">` : ''}
                <h3>${team.name}</h3>
                <p>Coach: ${team.coach_name || 'Not assigned'}</p>
                <p>${team.description || ''}</p>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

/**
 * Display single page content
 * Usage: displayPageContent('page-id')
 */
async function displayPageContent(pageId) {
    const page = await getPage(pageId);
    
    if (!page) {
        console.error('Page not found');
        return;
    }
    
    // Update page title
    document.title = page.seo_title || page.title;
    
    // Update meta tags
    document.querySelector('meta[name="description"]').content = 
        page.seo_description || page.description || '';
    
    // Display content
    const contentContainer = document.getElementById('page-content');
    if (contentContainer) {
        contentContainer.innerHTML = `
            <article>
                <h1>${page.title}</h1>
                ${page.featured_image ? `<img src="${page.featured_image}" alt="${page.title}">` : ''}
                <div class="content">${page.content}</div>
            </article>
        `;
    }
}

// ============================================
// EXAMPLE: URL Parameter Handling
// ============================================

/**
 * Get URL parameters
 * Usage: const id = getUrlParameter('id');
 */
function getUrlParameter(name) {
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

// ============================================
// EXAMPLE: Initialize Page on Load
// ============================================

/**
 * Initialize when page loads
 * Add this to your HTML: <script>window.addEventListener('DOMContentLoaded', initPage);</script>
 */
async function initPage() {
    // Check what page we're on
    const pageId = getUrlParameter('id');
    const pageSlug = getUrlParameter('slug');
    
    if (pageId) {
        // Display single page
        displayPageContent(pageId);
    } else if (pageSlug) {
        // Display page by slug
        const page = await getPageBySlug(pageSlug);
        if (page) {
            displayPageContent(page.id);
        }
    } else {
        // Display list of pages
        displayPages('pages-container');
        displayTeams('teams-container');
    }
}

// ============================================
// HOW TO USE IN YOUR HTML
// ============================================

/*

1. ADD SCRIPT TO YOUR HTML:
<script src="path/to/this/file.js"></script>

2. ADD CONTAINERS IN HTML:
<div id="pages-container"></div>
<div id="teams-container"></div>
<div id="page-content"></div>

3. INITIALIZE ON PAGE LOAD:
<script>
    window.addEventListener('DOMContentLoaded', initPage);
</script>

4. FOR DYNAMIC PAGE DISPLAY:
<script>
    // Get page ID from URL parameter
    const pageId = getUrlParameter('id');
    if (pageId) {
        displayPageContent(pageId);
    }
</script>

5. DISPLAY TEAMS ANYWHERE:
<script>
    displayTeams('teams-container');
</script>

6. DISPLAY PAGES ANYWHERE:
<script>
    displayPages('pages-container');
</script>

*/

// ============================================
// EXAMPLE: AJAX FORM SUBMISSION
// ============================================

/**
 * Handle form submission for newsletter signup or contact
 */
async function submitForm(formId, endpoint) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                alert('Success!');
                form.reset();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred');
        }
    });
}

// ============================================
// EXPORT FOR USE IN MODULES
// ============================================

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        getPages,
        getPage,
        getPageBySlug,
        getTeams,
        getTeam,
        checkAuth,
        loginUser,
        displayPages,
        displayTeams,
        displayPageContent,
        getUrlParameter,
        initPage,
        submitForm
    };
}
