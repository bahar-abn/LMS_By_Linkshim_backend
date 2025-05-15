<?php include('view/header.php') ?>

<section>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Assignments</h1>
        <form action="." method="get" class="flex items-center space-x-2">
            <input type="hidden" name="action" value="list_assignments">
            <select name="course_id" class="p-2 border border-gray-300 rounded">
                <option value="0">View All</option>
                <?php foreach ($courses as $course) : ?>
                    <option value="<?= $course['courseID'] ?>" <?= $course_id == $course['courseID'] ? 'selected' : '' ?>>
                        <?= $course['courseName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Go</button>
        </form>
    </div>

    <?php if($assignments) { ?>
        <div class="space-y-4">
            <?php foreach ($assignments as $assignment) : ?>
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-700"><?= $assignment['courseName'] ?></p>
                        <p><?= $assignment['Description']; ?></p>
                    </div>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="delete_assignment">
                        <input type="hidden" name="assignment_id" value="<?= $assignment['ID']; ?>">
                        <input type="hidden" name="course_id" value="<?= $assignment['courseID']; ?>">
                        <button class="text-red-500 hover:text-red-700">❌</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <p class="text-gray-500 mt-4">
            <?= $course_id ? 'No assignments exist for this course yet.' : 'No assignments exist yet.' ?>
        </p>
    <?php } ?>
</section>

<section class="mt-10">
    <h2 class="text-xl font-semibold mb-4">Add Assignment</h2>
    <form action="." method="post" class="space-y-4">
        <input type="hidden" name="action" value="add_assignment">
        <div>
            <label class="block mb-1">Course</label>
            <select name="course_id" required class="w-full p-3 border border-gray-300 rounded">
                <option value="">Please select</option>
                <?php foreach ($courses as $course) : ?>
                    <option value="<?= $course['courseID']; ?>">
                        <?= $course['courseName']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block mb-1">Description</label>
            <input type="text" name="description" maxlength="120" placeholder="Description" required
                   class="w-full p-3 border border-gray-300 rounded">
        </div>
        <button class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">Add</button>
    </form>

    <div class="mt-6">
        <a href=".?action=list_courses" class="text-blue-600 hover:underline">&larr; View/Edit Courses</a>
    </div>
</section>

<?php include('view/footer.php') ?>
