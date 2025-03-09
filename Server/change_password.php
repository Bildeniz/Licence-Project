<?php
session_start();

require 'func.php';
require 'components.php';
require 'models.php';

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

login_required();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change your password</title>
    <?php import_css();?>
</head>
<body data-bs-theme="dark">
    <?php navbar(); ?>
    <br>
    <section class="container-sm">
        <h1>Change Password</h1>
        <hr>
        <form method="post">
            <div class="mb-3">
                <label for="old_password" class="form-label">Old Password</label>
                <input type="password" name="old_password" class="form-control" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Repeat Password</label>
                <input type="password" name="new_password" class="form-control" maxlength="255" required>
            </div>
            <button type="submit" class="btn btn-primary float-end">Change</button>
        </form>
    </section>
    <?php import_js(); ?>
</body>
</html>