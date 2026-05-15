<div class="user-management">
    <!-- Add Officer Form -->
    <div class="dash-card" style="margin-bottom: 22px;">
        <div class="dash-card-head">
            <h3><i class="fas fa-user-plus"></i> Add New Officer</h3>
        </div>
        <div class="dash-card-body">
            <div id="officerAlert" style="display:none;" class="alert"></div>
            <div class="form-row" style="grid-template-columns: repeat(4, 1fr);">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" id="newUsername" placeholder="e.g., john_doe" class="form-control">
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" id="newFullname" placeholder="e.g., John Doe" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="newEmail" placeholder="john@example.com" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password *</label>
                    <input type="text" id="newPassword" placeholder="Enter password (min 4 chars)" class="form-control">
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 10px;">
                <button class="btn btn-primary" onclick="addOfficer()">
                    <i class="fas fa-save"></i> Add Officer
                </button>
            </div>
        </div>
    </div>
    
    <!-- Users List Table -->
    <div class="dash-card">
        <div class="dash-card-head">
            <h3><i class="fas fa-users"></i> System Users</h3>
            <button class="btn btn-sm btn-ghost" onclick="loadUsers()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr><td colspan="8"><div class="empty-state">Loading users...</div></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Load users on page load
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

async function loadUsers() {
    try {
        const response = await fetch('/umuganda-mvc/api/users');
        const data = await response.json();
        if (data.success) {
            renderUsersTable(data.users);
        } else {
            document.getElementById('usersTableBody').innerHTML = '<tr><td colspan="8"><div class="empty-state">Failed to load users: ' + (data.message || 'Unknown error') + '</div></td></tr>';
        }
    } catch (error) {
        console.error('Error loading users:', error);
        document.getElementById('usersTableBody').innerHTML = '<tr><td colspan="8"><div class="empty-state">Error loading users</div></td></tr>';
    }
}

function renderUsersTable(users) {
    const tbody = document.getElementById('usersTableBody');
    if (!users || users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state">No users found</div></td></tr>';
        return;
    }
    
    tbody.innerHTML = users.map(user => `
        <tr>
            <td>${user.id}</td>
            <td><strong>${escapeHtml(user.username)}</strong></td>
            <td>${escapeHtml(user.full_name)}</td>
            <td><span class="status-badge" style="background: ${user.role === 'admin' ? '#e8a020' : '#1d6fa4'}; color:white; padding:4px 12px; border-radius:20px; font-size:12px;">${user.role}</span></td>
            <td>${escapeHtml(user.email) || '—'}</td>
            <td>${user.is_active ? '<span style="color:green">● Active</span>' : '<span style="color:red">● Inactive</span>'}</td>
            <td>${formatDate(user.created_at)}</td>
            <td>
                ${user.role !== 'admin' ? `
                    <button class="btn btn-xs btn-primary" onclick="changePassword(${user.id}, '${escapeHtml(user.username)}')" style="margin-right: 5px;">
                        <i class="fas fa-key"></i> Change PW
                    </button>
                    ${user.is_active ? 
                        `<button class="btn btn-xs btn-danger" onclick="removeOfficer(${user.id}, '${escapeHtml(user.username)}')">
                            <i class="fas fa-trash"></i> Remove
                        </button>` : 
                        `<button class="btn btn-xs btn-success" onclick="reactivateOfficer(${user.id}, '${escapeHtml(user.username)}')">
                            <i class="fas fa-undo"></i> Reactivate
                        </button>`
                    }
                ` : '<span style="color:#888; font-size:11px">Protected Account</span>'}
            </td>
        </tr>
    `).join('');
}

async function addOfficer() {
    const username = document.getElementById('newUsername').value.trim();
    const fullname = document.getElementById('newFullname').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const password = document.getElementById('newPassword').value.trim();
    const alertBox = document.getElementById('officerAlert');
    
    if (!username || !fullname || !password) {
        showAlert('officerAlert', 'Please fill in username, full name and password', 'error');
        return;
    }
    
    if (password.length < 4) {
        showAlert('officerAlert', 'Password must be at least 4 characters', 'error');
        return;
    }
    
    // Show loading
    alertBox.style.display = 'block';
    alertBox.className = 'alert alert-info';
    alertBox.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding officer...';
    
    try {
        const response = await fetch('/umuganda-mvc/api/add-officer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, full_name: fullname, email, password })
        });
        const result = await response.json();
        
        if (result.success) {
            showAlert('officerAlert', 'Officer added successfully!', 'success');
            document.getElementById('newUsername').value = '';
            document.getElementById('newFullname').value = '';
            document.getElementById('newEmail').value = '';
            document.getElementById('newPassword').value = '';
            loadUsers(); // Refresh the list
        } else {
            showAlert('officerAlert', result.message || 'Failed to add officer', 'error');
        }
    } catch (error) {
        showAlert('officerAlert', 'Network error - please try again', 'error');
    }
}

async function removeOfficer(userId, username) {
    if (confirm(`⚠️ Are you sure you want to remove "${username}"?\n\nThey will no longer be able to login.`)) {
        try {
            const response = await fetch('/umuganda-mvc/api/remove-officer', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: userId })
            });
            const result = await response.json();
            
            if (result.success) {
                alert('✓ Officer removed successfully');
                loadUsers();
            } else {
                alert('✗ ' + (result.message || 'Failed to remove officer'));
            }
        } catch (error) {
            alert('Network error - please try again');
        }
    }
}

async function reactivateOfficer(userId, username) {
    if (confirm(`Reactivate "${username}"?\n\nThey will be able to login again.`)) {
        try {
            const response = await fetch('/umuganda-mvc/api/reactivate-officer', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: userId })
            });
            const result = await response.json();
            
            if (result.success) {
                alert('✓ Officer reactivated successfully');
                loadUsers();
            } else {
                alert('✗ ' + (result.message || 'Failed to reactivate officer'));
            }
        } catch (error) {
            alert('Network error - please try again');
        }
    }
}

async function changePassword(userId, username) {
    const newPassword = prompt(`Enter new password for "${username}":\n(Minimum 4 characters)`);
    if (newPassword && newPassword.length >= 4) {
        try {
            const response = await fetch('/umuganda-mvc/api/change-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: userId, new_password: newPassword })
            });
            const result = await response.json();
            
            if (result.success) {
                alert('✓ Password changed successfully');
            } else {
                alert('✗ ' + (result.message || 'Failed to change password'));
            }
        } catch (error) {
            alert('Network error - please try again');
        }
    } else if (newPassword) {
        alert('Password must be at least 4 characters');
    }
}

function showAlert(alertId, message, type) {
    const alertBox = document.getElementById(alertId);
    alertBox.style.display = 'block';
    alertBox.className = `alert alert-${type === 'error' ? 'error' : 'success'}`;
    alertBox.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i> ${message}`;
    setTimeout(() => {
        alertBox.style.display = 'none';
    }, 3000);
}

function formatDate(dateString) {
    if (!dateString) return '—';
    const d = new Date(dateString);
    return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}
</script>

<style>
.user-management {
    padding: 0;
}
.btn-xs {
    padding: 5px 10px;
    font-size: 0.75rem;
    border-radius: 5px;
    cursor: pointer;
    border: none;
}
.btn-danger {
    background: #c0392b;
    color: white;
}
.btn-danger:hover {
    background: #a93226;
}
.btn-success {
    background: #1a6b35;
    color: white;
}
.btn-success:hover {
    background: #145c2e;
}
.btn-primary {
    background: #1a6b35;
    color: white;
}
.btn-primary:hover {
    background: #145c2e;
}
.btn-ghost {
    background: #e0d8cf;
    color: #444;
}
.form-control {
    width: 100%;
    padding: 10px;
    border: 2px solid #e0d8cf;
    border-radius: 8px;
    font-family: inherit;
}
</style>