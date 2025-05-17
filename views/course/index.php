<?php
<h2>Available Courses</h2>
<ul>
<?php foreach ($courses as $course): ?>
    <li><?= $course['title'] ?>
        <a href="/courses/<?= $course['id'] ?>/enroll">Enroll</a>
    </li>
<?php endforeach; ?>
</ul>
