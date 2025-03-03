<?php
    session_start();
    $dir = $_SERVER['DOCUMENT_ROOT'];
    require $dir."/func.php";
    require $dir."/models.php";
    require $dir."/components.php";

    login_required();

    $licence_id = $_GET["licence"];
    $device_id = $_GET["device"];

    $device = Device::where("licence_id", $licence_id)
    ->where("id", $device_id)
    ->get()
    ->first();

    if (!$device) {
        http_response_code(404);
        die("Device not found");
    }
    else{
        $device->active = !$device->active;
        $device->save();
        header("location: /dashboard/licence/info.php?id=".$licence_id);
    }


?>