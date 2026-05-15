<?php
// ============================================
// Home Controller
// ============================================

class HomeController {
    
    public function index() {
        $title = 'Umuganda Platform';
        // Capture the view content
        ob_start();
        include VIEW_PATH . 'home/index.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/main.php';
    }
    
    public function submit() {
        $title = 'Submit Request';
        ob_start();
        include VIEW_PATH . 'home/submit.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/main.php';
    }
    
    public function track() {
        $title = 'Track Request';
        ob_start();
        include VIEW_PATH . 'home/track.php';
        $content = ob_get_clean();
        include VIEW_PATH . 'layouts/main.php';
    }
}
?>