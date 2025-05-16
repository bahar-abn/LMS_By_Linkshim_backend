<?php
require_once __DIR__ . '/../../config/constants.php';

// بارگذاری هدر با مسیر مطمئن
include __DIR__ . '/../partials/header.php';
?>

<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create a new account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" action="<?= BASE_URL ?>register" method="POST">

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required
                               class="block w-full px-3 py-2 border <?= !empty($data['name_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= htmlspecialchars($data['name'] ?? '') ?>">
                        <?php if (!empty($data['name_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($data['name_err']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required
                               class="block w-full px-3 py-2 border <?= !empty($data['email_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                        <?php if (!empty($data['email_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($data['email_err']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                               class="block w-full px-3 py-2 border <?= !empty($data['password_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= htmlspecialchars($data['password'] ?? '') ?>">
                        <?php if (!empty($data['password_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($data['password_err']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <div class="mt-1">
                        <input id="confirm_password" name="confirm_password" type="password" required
                               class="block w-full px-3 py-2 border <?= !empty($data['confirm_password_err']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md"
                               value="<?= htmlspecialchars($data['confirm_password'] ?? '') ?>">
                        <?php if (!empty($data['confirm_password_err'])): ?>
                            <p class="mt-2 text-sm text-red-600"><?= htmlspecialchars($data['confirm_password_err']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="w-full py-2 px-4 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="<?= BASE_URL ?>login" class="text-indigo-600 hover:text-indigo-500">Sign in here</a>
            </div>
        </div>
    </div>
</div>

<?php
// بارگذاری فوتر با مسیر مطمئن
include __DIR__ . '/../partials/footer.php';
?>
