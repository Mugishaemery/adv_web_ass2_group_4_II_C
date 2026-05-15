<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Umuganda Platform'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,600;12..96,700;12..96,800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/umuganda-mvc/public/assets/css/style.css">
</head>
<body>

<nav class="navbar" id="publicNav">
    <div class="nav-inner">
        <a class="nav-brand" href="/umuganda-mvc/home">
            <span class="brand-leaf">🌿</span>
            <span class="brand-text">Umuganda<span>Platform</span></span>
        </a>
        <button class="nav-ham" onclick="toggleNav()"><i class="fas fa-bars"></i></button>
        <ul class="nav-links" id="navLinks">
            <li><a href="/umuganda-mvc/home">Home</a></li>
            <li><a href="/umuganda-mvc/submit">Submit Request</a></li>
            <li><a href="/umuganda-mvc/track">Track Request</a></li>
            <li><a href="/umuganda-mvc/login" class="btn-nav-admin">Admin Login</a></li>
        </ul>
    </div>
</nav>

<main>
    <?php 
    // $content is passed from the controller
    if (isset($content) && !empty($content)) {
        echo $content;
    } elseif (isset($viewFile) && file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo '<div style="padding:50px;text-align:center">Content not found</div>';
    }
    ?>
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div><strong>🌿 Umuganda Smart Platform</strong><br><small>Empowering communities through transparent service delivery.</small></div>
        <div class="footer-links">
            <a href="/umuganda-mvc/home">Home</a>
            <a href="/umuganda-mvc/submit">Submit</a>
            <a href="/umuganda-mvc/track">Track</a>
            <a href="/umuganda-mvc/login">Admin</a>
        </div>
        <p class="footer-copy">Umuganda &copy; 2026</p>
    </div>
</footer>

<script src="/umuganda-mvc/public/assets/js/app.js"></script>
<script>
function toggleNav() {
    const navLinks = document.getElementById('navLinks');
    if (navLinks) navLinks.classList.toggle('open');
}
</script>
</body>
</html>