<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<header class="bg-white shadow mb-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo / Title -->
            <div class="text-2xl font-bold text-blue-600">
                Assignment Tracker
            </div>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center space-x-6">
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">home</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 transition">assignment</a>
                           <a href="#" class="text-gray-700 hover:text-blue-600 transition">profile</a>
                <!-- Login Button -->
                <a href="../controller/authentication.php" class="ml-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Login
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-2 space-y-2">
            <a href="#" class="block text-gray-700 hover:text-blue-600">home</a>
            <a href="#" class="block text-gray-700 hover:text-blue-600">assignment</a>
            <a href="#" class="block text-gray-700 hover:text-blue-600">profile</a>
            <a href="/login" class="block text-white bg-blue-600 hover:bg-blue-700 rounded px-4 py-2 text-center">
                ورود
            </a>
        </div>
    </div>
</header>

<script>
    // Toggle mobile menu
    document.getElementById('menu-button').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>

<body class="bg-gray-50 text-gray-800">
<main class="max-w-5xl mx-auto p-6">