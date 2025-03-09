<?php
    session_start();
    require "models.php";
    require "components.php";

    $errors = [];

    if(isset($_SESSION['username'])){
        header("Location: /dashboard.php");
    }
    var_dump(password_verify("123456789", '$2y$12$0vgW/Wf6jLv4XDFg9GEVNeEyIMY.MAUe35E0Rda.6R/3rEWzFnXWu'));
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = User::where('username', $_POST['username'])->first();

        if (isset($user) && password_verify($_POST['password'], $user->password)) {
            $user->lastLogin = date("Y-m-d");
            $user->save();

            $_SESSION['username'] = $user->username;
            $_SESSION['id'] = $user->id;
            $_SESSION['flashes'] = [];
            header("Location: /dashboard.php");

        }else{
            $errors[] = ["Invalid username or password", "danger"];
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <?php import_css(); ?>
</head>
<body data-bs-theme="dark" class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow" style="width: 350px;">
        <?php
        if(count($errors) > 0){
            foreach($errors as $error){
                echo "<div class='alert alert-{$error[1]}' role='alert'>{$error[0]}</div>";
            }
        }
        ?>
        <h3 class="text-center mb-4">Login</h3>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Pleas enter your username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Pleas enter your password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #1e1e1e, #3a3a3a);

        }
        .card {
            box-shadow: 0px 0px 10px rgba(128, 128, 128, 0.7) !important;
        }
    </style>
    <?php import_js(); ?>
</body>
</html>

