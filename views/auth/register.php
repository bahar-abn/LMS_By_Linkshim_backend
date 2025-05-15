<?php include 'views/partials/header.php'; ?>

    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create a new account</h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6" action="/register" method="POST">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" autocomplete="name" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['name_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['name']; ?>">
                            <?php if(!empty($data['name_err'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo $data['name_err']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['email_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['email']; ?>">
                            <?php if(!empty($data['email_err'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo $data['email_err']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['password_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['password']; ?>">
                            <?php if(!empty($data['password_err'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo $data['password_err']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <div class="mt-1">
                            <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" required
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php echo (!empty($data['confirm_password_err'])) ? 'border-red-500' : ''; ?>"
                                   value="<?php echo $data['confirm_password']; ?>">
                            <?php if(!empty($data['confirm_password_err'])): ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo $data['confirm_password_err']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Register
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-center text-sm text-gray-600">
                            <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'views/partials/footer.php'; ?>