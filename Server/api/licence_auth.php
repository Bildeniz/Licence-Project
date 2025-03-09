<?php
    $dir = $_SERVER['DOCUMENT_ROOT'];
    require $dir."/func.php";
    require $dir."/models.php";
    require $dir."/components.php";

    use Carbon\Carbon;

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        die("Method Not Allowed");
    }

    header('Content-Type: application/json');
    $res = ["error" => Null, "auth" => false];

    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $res["error"] = "Unvalid JSON";
        http_response_code(400);
        die(json_encode($res));
    }

    if (!(array_key_exists("licence", $data)) or !(array_key_exists("fingerprint", $data))) {
        http_response_code(400);
        $res["error"] = "Licence key or fingerprint is not valid";
        die(json_encode($res));
    }

    $licence = Licence::where("uuid", $data["licence"])->get()->first();

    if (!$licence) {
        http_response_code(404);
        $res["error"] = "Licence not found";
        die(json_encode($res));
    }

    if (Carbon::parse($licence->end_date)->isPast()) {
        http_response_code(401);
        $res["error"] = "Licence has expired";
        die(json_encode($res));
    }

    $res["end_date"] = $licence->end_date;

    $device = Device::where("fingerprint", $data["fingerprint"])
        ->where('licence_id', $licence->id)
        ->get()
        ->first();

    if (!$device) {
        if($licence->limit_device && $licence->devices()->count() < $licence->limit_device){
            $device = new Device();
            $device->fingerprint = $data["fingerprint"];
            $device->licence_id = $licence->id;
            $device->save();
            $res["auth"] = true;
        }else if(!$licence->limit_device){
            $device = new Device();
            $device->fingerprint = $data["fingerprint"];
            $device->licence_id = $licence->id;
            $device->save();
            $res["auth"] = true;
        }else{
            $res["error"] = "You dont dont have use this licence with this device";
            http_response_code(401);
            die(json_encode($res));
        }
    }else{
        if (!$device->active){
            http_response_code(401);
            $res["error"] = "Your device is inactive";
            die(json_encode($res));
        }
    }

    $res['auth'] = true;
    echo(json_encode($res));
?>