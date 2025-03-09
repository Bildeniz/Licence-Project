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
    <section class="container my-4">
        <div class="card mb-4 shadow">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title mb-0">Licence Information</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Name:</div>
                    <div class="col-md-9"><?php echo $licence->name; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Active Status:</div>
                    <div class="col-md-9">
                        <?php
                        $active_status = $licence->active ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>";
                        echo $active_status;
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Licence Code:</div>
                    <div class="col-md-9"><?php echo $licence->uuid; ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3 fw-bold">Device Limit:</div>
                    <div class="col-md-9">
                        <?php
                        $device_count = $devices->count();
                        if ($licence->limit_device) {
                            echo "<span class='badge bg-primary'>{$device_count}/{$licence->limit_device}</span>";
                        } else {
                            echo "<span class='badge bg-primary'>{$device_count}/∞</span>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h3 class="card-title mb-0">Devices</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
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
                        foreach ($licence->devices as $device) {
                            echo '<tr>';
                            echo '<td>' . $device->id . '</td>';
                            echo '<td>' . $device->fingerprint . '</td>';
                            echo '<td>' . $device->name . '</td>';

                            $status = $device->active ? '✅' : '❌';
                            echo '<td>' . $status . '</td>';

                            $button_str = $device->active ? 'Set Inactive' : 'Set Active';
                            $button_class = $device->active ? 'btn-warning' : 'btn-success';
                            echo "<td>
                                    <a href='/dashboard/licence/switch_device.php?licence={$licence->id}&device={$device->id}' class='btn btn-sm {$button_class}'>{$button_str}</a>
                                  </td>";
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <?php import_js();?>
</body>
</html>
