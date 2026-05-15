<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Umuganda Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,600;12..96,700;12..96,800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/umuganda-mvc/public/assets/css/style.css">
</head>
<body>
<div class="login-body">
    <div class="login-card">
        <div class="login-brand">
            <span class="leaf">🌿</span>
            <h2>Umuganda Platform</h2>
            <p>Admin &amp; Officer Access</p>
        </div>
        <div id="loginAlert"></div>
        <div class="form-group">
            <label><i class="fas fa-user"></i> Username</label>
            <input type="text" id="loginUser" class="form-control" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Password</label>
            <div class="pw-wrap">
                <input type="password" id="loginPass" class="form-control" placeholder="Enter password">
                <button type="button" class="pw-toggle" onclick="togglePassword()"><i class="fas fa-eye" id="pwIcon"></i></button>
            </div>
        </div>
        <button class="btn btn-primary btn-block" onclick="doLogin()"><i class="fas fa-sign-in-alt"></i> Login</button>
        <div class="login-hint">
            <i class="fas fa-info-circle"></i> Demo credentials:<br>
            Username: <code>admin</code> &nbsp;|&nbsp; Password: <code>admin</code><br>
            Username: <code>officer</code> &nbsp;|&nbsp; Password: <code>officer</code>
        </div>
        <div class="login-back">
            <a href="/umuganda-mvc/home"><i class="fas fa-arrow-left"></i> Back to Public Site</a>
        </div>
    </div>
</div>

<script>
async function doLogin() {
    const username = document.getElementById('loginUser').value.trim();
    const password = document.getElementById('loginPass').value;
    const alertEl = document.getElementById('loginAlert');
    
    if (!username || !password) {
        alertEl.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Please enter username and password.</div>';
        return;
    }
    
    alertEl.innerHTML = '<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Logging in...</div>';
    
    try {
        const response = await fetch('/umuganda-mvc/api/admin-login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username: username, password: password })
        });
        
        const result = await response.json();
        
        if (result.success) {
            window.location.href = '/umuganda-mvc/admin/dashboard';
        } else {
            alertEl.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> ' + (result.message || 'Invalid credentials') + '</div>';
        }
    } catch (error) {
        console.error('Login error:', error);
        alertEl.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> Network error. Please try again.</div>';
    }
}

function togglePassword() {
    const pw = document.getElementById('loginPass');
    const icon = document.getElementById('pwIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        pw.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Allow Enter key to submit
document.getElementById('loginPass')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') doLogin();
});
document.getElementById('loginUser')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') doLogin();
});
</script>
</body>
</html>