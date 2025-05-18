<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-sm mx-auto mt-20 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Register</h2>

    <?php if (!empty($error)) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="post" class="space-y-4">
        <div>
            <label for="name" class="block text-gray-700">Full Name:</label>
            <input type="text" id="name" name="name" required
                   class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="password" class="block text-gray-700">Password:</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="confirm_password" class="block text-gray-700">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required
                   class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
            Register
        </button>
    </form>

    <p class="text-sm text-center text-gray-600 mt-4">
        Already have an account?
        <a href="login.php" class="text-blue-600 hover:underline">Login here</a>
    </p>
</div>

</body>
</html>
