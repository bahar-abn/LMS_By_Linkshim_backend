<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS System</title>
    <link href="/src/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold text-gray-800">LMS System</span>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <?php if($session->isLoggedIn()): ?>
                    <span class="px-3 py-2 text-sm font-medium text-gray-700">Welcome, <?php echo $session->get('user_name'); ?></span>
                    <a href="/logout" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Logout</a>
                <?php else: ?>
                    <a href="/login" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900">Login</a>
                    <a href="/register" class="ml-4 px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">