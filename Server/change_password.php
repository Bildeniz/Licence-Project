<?php
    session_start();

    require 'func.php';
    require 'components.php';
    require 'models.php';

    use Carbon\Carbon;
    use Ramsey\Uuid\Uuid;

    login_required();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $user = User::find($_SESSION["id"]);

        if(password_verify($_POST["old_password"], $user->password)){
            if($_POST["new_password"] === $_POST["confirm_password"]){
                $user->password = $_POST["new_password"]; // Password will hash automatically
                $user->save();
                $_SESSION['flashes'][] = ["Your password has been changed!", "success"];
                var_dump($_SESSION['flashes']);
                header("Location: /dashboard.php");
                die();
            }else{
                $_SESSION['flashes'][] = ["Your new password does not match!", "danger"];
            }
        }else{
            $_SESSION['flashes'][] = ["Password is incorrect. Please try again.", "danger"];
        }
    }
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
        <?php
            render_flashes();
        ?>
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
                <label for="new_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" maxlength="255" required>
            </div>
            <button type="submit" class="btn btn-primary float-end">Change</button>
        </form>
    </section>
    <?php import_js(); ?>
</body>
</html>