<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ورود</title>
</head>
<body>
<h2>فرم ورود</h2>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post" action="">
    <label>ایمیل: <input type="email" name="email" required></label><br><br>
    <label>رمز عبور: <input type="password" name="password" required></label><br><br>
    <button type="submit">ورود</button>
</form>
</body>
</html>
