<?php
require_once __DIR__ . '/../../config/constants.php'; // بارگذاری BASE_URL

include __DIR__ . '/../partials/header.php'; // استفاده از مسیر صحیح برای header.php
?>

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="<?= BASE_URL ?>login" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                               class="block w-full px-3 py-2 border <?= !empty($data['email_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= $data['email']; ?>">
                        <?php if (!empty($data['email_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= $data['email_err']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                               class="block w-full px-3 py-2 border <?= !empty($data['password_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= $data['password']; ?>">
                        <?php if (!empty($data['password_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= $data['password_err']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full py-2 px-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="<?= BASE_URL ?>register" class="text-indigo-600 hover:text-indigo-500">Register here</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
