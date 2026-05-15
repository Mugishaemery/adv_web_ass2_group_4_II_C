// ============================================
// UMUGANDA MVC - Frontend JavaScript
// ============================================

// API Configuration
const API_BASE = '/umuganda-mvc/api/';

// Categories data
const CATEGORIES = [
    {id: 1, name: 'Water & Sanitation', icon: 'fa-tint'},
    {id: 2, name: 'Street Lighting', icon: 'fa-lightbulb'},
    {id: 3, name: 'Cleaning & Waste', icon: 'fa-trash'},
    {id: 4, name: 'ICT & Lab Support', icon: 'fa-desktop'},
    {id: 5, name: 'Accommodation', icon: 'fa-home'},
    {id: 6, name: 'Event Support', icon: 'fa-calendar-alt'},
    {id: 7, name: 'Road & Infrastructure', icon: 'fa-road'},
    {id: 8, name: 'Other', icon: 'fa-question-circle'},
];

// Global variables
let currentAdmin = null;

// ============================================
// API CALL FUNCTION
// ============================================
async function apiCall(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        }
    };
    
    if (data && (method === 'POST' || method === 'PUT' || method === 'DELETE')) {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(API_BASE + endpoint, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('API Error:', error);
        return { success: false, message: 'Network error' };
    }
}

// ============================================
// HELPER FUNCTIONS
// ============================================
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function formatDate(dateString) {
    if (!dateString) return '—';
    const d = new Date(dateString);
    return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function statusBadge(status) {
    const colors = { pending: '#e8a020', in_progress: '#1d6fa4', resolved: '#1a6b35', cancelled: '#888' };
    const labels = { pending: 'Pending', in_progress: 'In Progress', resolved: 'Resolved', cancelled: 'Cancelled' };
    return `<span class="status-badge" style="background:${colors[status]}; color:white; padding:4px 12px; border-radius:20px; font-size:12px;">${labels[status] || status}</span>`;
}

// ============================================
// HOME PAGE FUNCTIONS
// ============================================
async function loadHomeStats() {
    try {
        const result = await apiCall('stats');
        if (result.success && result.stats) {
            animateCount('stat-total', result.stats.total || 0);
            animateCount('stat-pending', result.stats.pending || 0);
            animateCount('stat-progress', result.stats.in_progress || 0);
            animateCount('stat-resolved', result.stats.resolved || 0);
        }
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}

function animateCount(id, target) {
    const el = document.getElementById(id);
    if (!el) return;
    let cur = 0;
    const step = Math.max(1, Math.ceil(target / 40));
    const timer = setInterval(() => {
        cur = Math.min(cur + step, target);
        el.textContent = cur;
        if (cur >= target) clearInterval(timer);
    }, 30);
}

function loadCategoriesGrid() {
    const grid = document.getElementById('homeCatGrid');
    if (grid) {
        grid.innerHTML = CATEGORIES.map(c => `
            <div class="cat-chip" onclick="window.location.href='/umuganda-mvc/submit'">
                <i class="fas ${c.icon}"></i>
                <span>${c.name}</span>
            </div>
        `).join('');
    }
}

// ============================================
// SUBMIT REQUEST FUNCTIONS
// ============================================
function loadCategorySelect() {
    const sel = document.getElementById('f_cat');
    if (sel) {
        sel.innerHTML = '<option value="">— Select a category —</option>' +
            CATEGORIES.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
    }
}

function updatePreview() {
    const name = document.getElementById('f_name')?.value.trim();
    const email = document.getElementById('f_email')?.value.trim();
    const phone = document.getElementById('f_phone')?.value.trim();
    const catSel = document.getElementById('f_cat');
    const cat = catSel?.options[catSel.selectedIndex]?.text || '—';
    const title = document.getElementById('f_title')?.value.trim();
    const desc = document.getElementById('f_desc')?.value.trim();
    const loc = document.getElementById('f_loc')?.value.trim();
    const pri = document.querySelector('input[name="priority"]:checked')?.value || 'medium';
    const body = document.getElementById('previewBody');
    
    if (!body) return;
    
    if (!name && !title && !desc) {
        body.innerHTML = '<p class="preview-empty">Start filling the form to see a preview of your request here.</p>';
        return;
    }
    
    const priColors = { low: '#1a6b35', medium: '#9a6010', high: '#c0392b' };
    const priBg = { low: '#e8f8ee', medium: '#fff3dc', high: '#fdecea' };
    
    body.innerHTML = `
        <div class="preview-ticket">TICKET # Auto-generated on submit</div>
        <table class="preview-table">
            <tr><th>Name</th><td>${escapeHtml(name) || '<em>—</em>'}</td></tr>
            <tr><th>Email</th><td>${escapeHtml(email) || '<em>—</em>'}</td></tr>
            <tr><th>Phone</th><td>${escapeHtml(phone) || '<em>—</em>'}</td></tr>
            <tr><th>Category</th><td>${escapeHtml(cat)}</td></tr>
            <tr><th>Priority</th><td><span style="background:${priBg[pri]};color:${priColors[pri]};padding:2px 10px;border-radius:20px;font-size:.75rem;font-weight:800;text-transform:uppercase">${pri}</span></td></tr>
            <tr><th>Location</th><td>${escapeHtml(loc) || '<em>Not specified</em>'}</td></tr>
        </table>
        <div class="preview-title">${escapeHtml(title) || '<em style="color:var(--ink-lite)">No title yet…</em>'}</div>
        ${desc ? `<div class="preview-desc">${escapeHtml(desc)}</div>` : ''}
    `;
}

function clearForm() {
    ['f_name', 'f_email', 'f_phone', 'f_title', 'f_desc', 'f_loc'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.value = '';
            el.classList.remove('input-err');
        }
    });
    const cat = document.getElementById('f_cat');
    if (cat) cat.value = '';
    const med = document.querySelector('input[value="medium"]');
    if (med) med.checked = true;
    setTimeout(updatePreview, 50);
}

async function submitRequest() {
    const name = document.getElementById('f_name')?.value.trim();
    const email = document.getElementById('f_email')?.value.trim();
    const phone = document.getElementById('f_phone')?.value.trim();
    const catId = parseInt(document.getElementById('f_cat')?.value);
    const title = document.getElementById('f_title')?.value.trim();
    const desc = document.getElementById('f_desc')?.value.trim();
    const loc = document.getElementById('f_loc')?.value.trim();
    const pri = document.querySelector('input[name="priority"]:checked')?.value || 'medium';
    const alertBox = document.getElementById('submitAlert');
    
    if (!alertBox) return;
    
    // Validation
    let errs = [];
    if (!name) errs.push('Full Name');
    if (!catId) errs.push('Category');
    if (!title) errs.push('Title');
    if (!desc) errs.push('Description');
    
    if (errs.length) {
        alertBox.innerHTML = `<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Please fill in: <strong>${errs.join(', ')}</strong>.</div>`;
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        return;
    }
    
    const submitBtn = document.querySelector('#page-submit .btn-primary');
    const originalText = submitBtn?.innerHTML || 'Submit';
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        submitBtn.disabled = true;
    }
    
    const result = await apiCall('submit-request', 'POST', {
        full_name: name,
        email: email,
        phone: phone,
        category: catId,
        title: title,
        description: desc,
        location: loc,
        priority: pri
    });
    
    if (submitBtn) {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
    
    if (result.success) {
        alertBox.innerHTML = `<div class="alert alert-success" style="flex-direction:column;align-items:flex-start">
            <div style="display:flex;align-items:center;gap:8px"><i class="fas fa-check-circle"></i> <strong>Request submitted successfully!</strong></div>
            <div style="margin-top:8px">Your ticket number is: <strong style="font-family:'DM Mono',monospace;font-size:1.1rem;color:var(--green)">${result.ticket}</strong></div>
            <div style="font-size:.86rem;margin-top:6px;color:#1a5e2a">Save this number to track your request status.</div>
            <button class="btn btn-sm" style="background:#1a5e2a;color:#fff;margin-top:12px" onclick="window.location.href='/umuganda-mvc/track'"><i class="fas fa-search"></i> Track this request</button>
        </div>`;
        clearForm();
    } else {
        alertBox.innerHTML = `<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> ${result.message || 'Failed to submit request. Please try again.'}</div>`;
    }
    alertBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// ============================================
// TRACK REQUEST FUNCTIONS
// ============================================
async function doTrack() {
    const ticket = document.getElementById('trackInput')?.value.trim().toUpperCase();
    const box = document.getElementById('trackResult');
    
    if (!box) return;
    
    if (!ticket) {
        box.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Please enter a ticket number.</div>';
        return;
    }
    
    box.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Loading request details...</div>';
    
    const result = await apiCall(`track-request?ticket=${encodeURIComponent(ticket)}`);
    
    if (!result.success) {
        box.innerHTML = `<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> ${result.message || 'No request found with this ticket number.'}</div>`;
        return;
    }
    
    const req = result.request;
    const history = result.history || [];
    const statusLabels = { pending: 'Pending', in_progress: 'In Progress', resolved: 'Resolved', cancelled: 'Cancelled' };
    const priColors = { low: '#1a6b35', medium: '#9a6010', high: '#c0392b' };
    const steps = ['pending', 'in_progress', 'resolved'];
    const curIdx = steps.indexOf(req.status);
    
    const stepsHtml = steps.map((s, i) => `
        <div class="progress-step ${i <= curIdx ? 'done' : ''} ${req.status === s ? 'current' : ''}">
            <div class="pdot"></div>
            <span>${statusLabels[s]}</span>
        </div>
        ${i < steps.length - 1 ? `<div class="pline ${i < curIdx ? 'done' : ''}"></div>` : ''}
    `).join('');
    
    const histHtml = history.length ? `<div class="history-box">
        <h4><i class="fas fa-history"></i> Status History</h4>
        <ul class="hist-list">
            ${history.map(h => `<li class="hist-item">
                <span class="hist-date">${formatDate(h.changed_at)}</span>
                <span>${h.old_status === 'new' ? 'Submitted' : '→ ' + (h.old_status || 'new')} <span class="hist-arrow">→</span> <strong>${h.new_status}</strong></span>
                ${h.changed_by ? `<span style="color:var(--ink-lite);font-size:.78rem">by ${escapeHtml(h.changed_by)}</span>` : ''}
                ${h.notes ? `<span class="hist-note">"${escapeHtml(h.notes)}"</span>` : ''}
            </li>`).join('')}
        </ul>
    </div>` : '';
    
    box.innerHTML = `<div class="track-result">
        <div class="track-header">
            <div>
                <div class="track-ticket">${escapeHtml(req.ticket)}</div>
                <div class="track-date">Submitted: ${formatDate(req.submitted_at)}</div>
            </div>
            ${statusBadge(req.status)}
        </div>
        <div class="track-body">
            <div class="track-title">${escapeHtml(req.title)}</div>
            <div class="track-meta">
                <span><i class="fas fa-tag"></i> ${escapeHtml(req.category_name || 'Other')}</span>
                <span><i class="fas fa-flag" style="color:${priColors[req.priority]}"></i> ${req.priority.charAt(0).toUpperCase() + req.priority.slice(1)} Priority</span>
                ${req.location ? `<span><i class="fas fa-map-marker-alt"></i> ${escapeHtml(req.location)}</span>` : ''}
            </div>
            <div class="track-desc">${escapeHtml(req.description)}</div>
            ${req.notes ? `<div class="admin-note"><strong><i class="fas fa-comment-dots"></i> Officer Notes:</strong> ${escapeHtml(req.notes)}</div>` : ''}
            ${req.resolved_at ? `<div class="resolved-tag"><i class="fas fa-check-circle"></i> Resolved on ${formatDate(req.resolved_at)}</div>` : ''}
        </div>
        <div class="progress-bar">${stepsHtml}</div>
        ${histHtml}
    </div>`;
}

// ============================================
// LOGIN FUNCTIONS
// ============================================
async function doLogin() {
    const user = document.getElementById('loginUser')?.value.trim();
    const pass = document.getElementById('loginPass')?.value;
    const alertEl = document.getElementById('loginAlert');
    
    if (!alertEl) return;
    
    if (!user || !pass) {
        alertEl.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Please enter username and password.</div>';
        return;
    }
    
    const loginBtn = document.querySelector('#page-login .btn-primary');
    const originalText = loginBtn?.innerHTML || 'Login';
    if (loginBtn) {
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        loginBtn.disabled = true;
    }
    
    const result = await apiCall('admin-login', 'POST', { username: user, password: pass });
    
    if (loginBtn) {
        loginBtn.innerHTML = originalText;
        loginBtn.disabled = false;
    }
    
    if (result.success) {
        window.location.href = '/umuganda-mvc/admin/dashboard';
    } else {
        alertEl.innerHTML = `<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> ${result.message || 'Invalid credentials'}</div>`;
    }
}

function togglePw() {
    const pw = document.getElementById('loginPass');
    const ic = document.getElementById('pwIcon');
    if (pw && ic) {
        if (pw.type === 'password') {
            pw.type = 'text';
            ic.className = 'fas fa-eye-slash';
        } else {
            pw.type = 'password';
            ic.className = 'fas fa-eye';
        }
    }
}

function toggleNav() {
    const navLinks = document.getElementById('navLinks');
    if (navLinks) navLinks.classList.toggle('open');
}

// ============================================
// ADMIN DASHBOARD FUNCTIONS
// ============================================
async function loadAdminStats() {
    const result = await apiCall('stats');
    if (result.success && result.stats) {
        const stats = result.stats;
        const statsContainer = document.getElementById('adminStats');
        if (statsContainer) {
            statsContainer.innerHTML = `
                <div class="stat-card c-total"><div class="sc-info"><strong>${stats.total || 0}</strong><span>Total</span></div></div>
                <div class="stat-card c-pend"><div class="sc-info"><strong>${stats.pending || 0}</strong><span>Pending</span></div></div>
                <div class="stat-card c-prog"><div class="sc-info"><strong>${stats.in_progress || 0}</strong><span>In Progress</span></div></div>
                <div class="stat-card c-res"><div class="sc-info"><strong>${stats.resolved || 0}</strong><span>Resolved</span></div></div>
                <div class="stat-card c-high"><div class="sc-info"><strong>${stats.high_priority || 0}</strong><span>High Priority</span></div></div>
            `;
        }
    }
}

// ============================================
// INITIALIZATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    // Load categories for submit form
    loadCategorySelect();
    
    // Load categories grid on home page
    loadCategoriesGrid();
    
    // Load stats on home page
    if (document.getElementById('stat-total')) {
        loadHomeStats();
    }
    
    // Load admin stats on dashboard
    if (document.getElementById('adminStats')) {
        loadAdminStats();
    }
    
    // Setup preview listeners on submit page
    if (document.getElementById('previewBody')) {
        const inputs = ['f_name', 'f_email', 'f_phone', 'f_title', 'f_desc', 'f_loc', 'f_cat'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.addEventListener('input', updatePreview);
        });
        document.querySelectorAll('input[name="priority"]').forEach(radio => {
            radio.addEventListener('change', updatePreview);
        });
    }
    
    // Track enter key on track page
    const trackInput = document.getElementById('trackInput');
    if (trackInput) {
        trackInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') doTrack();
        });
    }
    
    // Track enter key on login page
    const loginPass = document.getElementById('loginPass');
    if (loginPass) {
        loginPass.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') doLogin();
        });
    }
    
    // Start clock on admin pages
    if (document.getElementById('topbarClock')) {
        startClock();
    }
});

function startClock() {
    setInterval(() => {
        const el = document.getElementById('topbarClock');
        if (el) {
            el.textContent = new Date().toLocaleTimeString();
        }
    }, 1000);
}

// Make functions globally available
window.submitRequest = submitRequest;
window.doTrack = doTrack;
window.doLogin = doLogin;
window.clearForm = clearForm;
window.updatePreview = updatePreview;
window.togglePw = togglePw;
window.toggleNav = toggleNav;