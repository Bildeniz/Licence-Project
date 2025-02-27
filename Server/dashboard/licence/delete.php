<?php
session_start();

$dir = $_SERVER['DOCUMENT_ROOT'];
require $dir."/models.php";
require $dir."/func.php";

login_required();

$id = $_GET['id'];

$licence = Licence::find($id);

if (isset($licence)) {
    $licence->devices()->delete();
    $licence->delete();

    $_SESSION['flashes'][] = ["Licence has been deleted successfully!", "info"];
    header('location: /dashboard.php');
}else{
    $_SESSION['flashes'][] = ["Licence not founded", "danger"];
    header('location: /dashboard.php');
}
?>