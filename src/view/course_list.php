<?php include('view/header.php') ?>
<section>
    <h1 class="text-3xl font-bold mb-6">Course List</h1>

    <?php if($courses) { ?>
        <div class="space-y-4">
            <?php foreach ($courses as $course) : ?>
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <span class="text-lg font-medium"><?= $course['courseName'] ?></span>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="delete_course">
                        <input type="hidden" name="course_id" value="<?= $course['courseID']; ?>">
                        <button class="text-red-500 hover:text-red-700">❌</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <p class="text-gray-500">No courses exist yet.</p>
    <?php } ?>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Add Course</h2>
        <form action="." method="post" class="space-y-4">
            <input type="hidden" name="action" value="add_course">
            <input type="text" name="course_name" maxlength="30" placeholder="Course Name" required
                   class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Add</button>
        </form>
    </div>

    <div class="mt-6">
        <a href="." class="text-blue-600 hover:underline">&larr; View & Add Assignments</a>
    </div>
</section>
<?php include('view/footer.php') ?>
