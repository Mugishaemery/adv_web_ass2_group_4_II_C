<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Admin Panel'; ?> - Umuganda Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,600;12..96,700;12..96,800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/umuganda-mvc/public/assets/css/style.css">
</head>
<body>

<div class="admin-page active" style="display:flex">
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-logo">
            <span class="leaf">🌿</span>
            <strong>Umuganda</strong>
            <small>Admin Panel</small>
        </div>
        <nav class="sidebar-nav">
            <a href="/umuganda-mvc/admin/dashboard"><i class="fas fa-chart-pie"></i> Dashboard</a>
            <a href="/umuganda-mvc/admin/requests"><i class="fas fa-list-alt"></i> All Requests</a>
            <a href="/umuganda-mvc/admin/reports"><i class="fas fa-chart-bar"></i> Reports</a>
            <?php if(isset($session) && $session['role'] === 'admin'): ?>
            <a href="/umuganda-mvc/admin/users"><i class="fas fa-users-cog"></i> User Management</a>
            <?php endif; ?>
            <hr class="sidebar-divider">
            <a href="/umuganda-mvc/home"><i class="fas fa-globe"></i> Public Site</a>
            <a href="#" onclick="logout()" class="nav-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
        <div class="sidebar-user">
            <div class="sidebar-avi"><i class="fas fa-user-shield"></i></div>
            <div>
                <strong><?php echo isset($session['full_name']) ? htmlspecialchars($session['full_name']) : 'Admin'; ?></strong>
                <small><?php echo isset($session['role']) ? htmlspecialchars($session['role']) : 'administrator'; ?></small>
            </div>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button class="ham-btn" onclick="document.getElementById('adminSidebar').classList.toggle('open')"><i class="fas fa-bars"></i></button>
            <div class="topbar-title"><?php echo isset($title) ? htmlspecialchars($title) : 'Dashboard'; ?></div>
            <span class="topbar-clock" id="topbarClock"></span>
            <button class="btn btn-sm btn-ghost" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </header>

        <div class="admin-content">
            <?php 
            // Display content passed from controller
            if (isset($content)) {
                echo $content;
            } else {
                echo '<div style="padding:20px; text-align:center;">Content not available</div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
function logout() {
    window.location.href = '/umuganda-mvc/login';
}

function startClock() {
    setInterval(function() {
        var clock = document.getElementById('topbarClock');
        if (clock) {
            var now = new Date();
            clock.textContent = now.toLocaleTimeString();
        }
    }, 1000);
}
startClock();
</script>
</body>
</html>