<?php
    session_start();
    $dir = $_SERVER['DOCUMENT_ROOT'];
    require $dir."/func.php";
    require $dir."/models.php";
    require $dir."/components.php";

    login_required();

    $id = $_GET["id"];

    $licence = Licence::with('devices')->find($id);
    $devices = $licence->devices();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Licence Info</title>
    <?php import_css();?>
</head>
<body data-bs-theme="dark">
    <?php navbar()?>
    <section class="container-sm my-2">
        <div class="row display-3 fw-bold">
            <div class="col">Name:</div>
            <?php
            echo "<div class='col-9'>{$licence->name}</div>"
            ?>
        </div>
        <div class="row display-6 fw-bold">
            <div class="col">Active Status:</div>
            <?php
            $active_status = $licence->active ? "Active" : "Inactive";
            echo "<div class='col-9'>{$active_status}</div>"
            ?>
        </div>
        <div class="row display-6 fw-bold">
            <div class="col">Licence Code:</div>
            <?php
            echo "<div class='col-9'>{$licence->uuid}</div>"
            ?>
        </div>
        <div class="row display-6 fw-bold">
            <div class="col">Device limit:</div>
            <?php
            $device_count = $licence->devices()->count();
            if ($licence->limit_device) {
                echo "<div class='col-9'>{$device_count}/{$licence->limit_device}</div>";
            } else {
                echo "<div class='col-9'>{$device_count}/∞</div>";
            }
            ?>
        </div>
        <div class="table-responsive mb-2">
            <table class="table table-bordered table-hover table-striped table-dark overflow-y-auto" style="max-height: 500px;">
                <thead class="sticky-top">
                    <tr>
                        <th>#</th>
                        <th>Device</th>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($licence->devices() as $device) {
                    echo '<tr>';
                    echo '<td>' . $device->id . '</td>';
                    echo '<td>' . $device->name . '</td>';

                    $status = $device->active ? '✅' : '❌';
                    echo '<td>' . $status . '</td>';

                    $button_str = $device->active ? 'Set Inactive' : 'Set Active';
                    echo "<td>
                                    <a href='/dashboard/device/active.php?licence={$licence->id}&device={$device->id}' class='btn btn-info btn-sm'>{$button_str}</a>
                          </td>";
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>


    </section>
    <?php import_js();?>
</body>
</html>
