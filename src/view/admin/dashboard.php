<?php include('header.php'); ?>

<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Admin Panel</h2>

    <!-- User List -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Users</h3>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead>
            <tr class="bg-gray-200 text-sm">
                <th class="p-2">Email</th>
                <th class="p-2">Role</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="border-b">
                    <td class="p-2"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($user['role']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pending Courses Approval -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-2">Courses Pending Approval</h3>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead>
            <tr class="bg-gray-200 text-sm">
                <th class="p-2">Title</th>
                <th class="p-2">Instructor</th>
                <th class="p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $course): ?>
                <tr class="border-b">
                    <td class="p-2"><?php echo htmlspecialchars($course['title']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($course['instructor']); ?></td>
                    <td class="p-2">
                        <a href="?action=approve&id=<?php echo $course['id']; ?>" class="text-green-600">Approve</a> |
                        <a href="?action=reject&id=<?php echo $course['id']; ?>" class="text-red-600">Reject</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- User Reviews -->
    <div>
        <h3 class="text-lg font-semibold mb-2">User Reviews</h3>
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead>
            <tr class="bg-gray-200 text-sm">
                <th class="p-2">Author</th>
                <th class="p-2">Content</th>
                <th class="p-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr class="border-b">
                    <td class="p-2"><?php echo htmlspecialchars($review['author']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($review['content']); ?></td>
                    <td class="p-2">
                        <a href="?action=delete_review&id=<?php echo $review['id']; ?>" class="text-red-600">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('footer.php'); ?>
