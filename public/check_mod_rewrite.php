<?php
echo "<h2>Apache Modules Check</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "✅ mod_rewrite is ENABLED";
    } else {
        echo "❌ mod_rewrite is DISABLED";
    }
} else {
    echo "Cannot check modules directly. Try enabling manually in httpd.conf";
}
?>