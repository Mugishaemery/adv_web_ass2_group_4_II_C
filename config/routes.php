<?php
return [
    'GET' => [
        '/' => ['HomeController', 'index'],
        '/home' => ['HomeController', 'index'],
        '/submit' => ['HomeController', 'submit'],
        '/track' => ['HomeController', 'track'],
        '/login' => ['AuthController', 'login'],
        
        '/admin/dashboard' => ['AdminController', 'dashboard'],
        '/admin/requests' => ['AdminController', 'requests'],
        '/admin/reports' => ['AdminController', 'reports'],
        '/admin/users' => ['AdminController', 'users'],
        '/admin/view-request/(\d+)' => ['AdminController', 'viewRequest'],
        '/admin/print-reports' => ['AdminController', 'printReports'],
        
        '/api/stats' => ['ApiController', 'getStats'],
        '/api/categories' => ['ApiController', 'getCategories'],
        '/api/track-request' => ['RequestController', 'track'],
        '/api/users' => ['ApiController', 'getUsers'],  // Add this line
    ],
    'POST' => [
        '/api/submit-request' => ['RequestController', 'submit'],
        '/api/admin-login' => ['AuthController', 'authenticate'],
        '/api/update-request' => ['AdminController', 'updateRequest'],
        '/api/add-officer' => ['AdminController', 'addOfficer'],
        '/api/remove-officer' => ['AdminController', 'removeOfficer'],
        '/api/reactivate-officer' => ['AdminController', 'reactivateOfficer'],
        '/api/change-password' => ['AdminController', 'changePassword'],
    ]
];
?>