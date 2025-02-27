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
    <title>Dashboard</title>
    <?php import_css(); ?>

    <style>

        .table thead th {
            background-color: #343a40;
        }

        .table-hover tbody tr:hover {
            background-color: #495057;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

    </style>
</head>
<body data-bs-theme="dark">
    <?php navbar(); ?>
    <section class="container-sm my-2">
        <?php render_flashes(); ?>
        <h1>All Licences</h1>

        <div class="table-responsive mb-2">
            <table class="table table-bordered table-hover table-striped table-dark">
                <thead class="sticky-top">
                    <tr>
                        <th>#</th>
                        <th>Licence</th>
                        <th>Devices</th>
                        <th>Status</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach (Licence::all() as $licence) {
                            echo '<tr>';
                            echo '<td>' . $licence->id . '</td>';
                            echo '<td>' . $licence->name . '</td>';

                            $device_count = $licence->devices()->count();
                            if ($licence->limit_device) {
                                echo "<td>{$device_count}/{$licence->limit_device}</td>";
                            } else {
                                echo "<td>{$device_count}/∞</td>";
                            }

                            $status = $licence->active ? '✅' : '❌';
                            echo '<td>' . $status . '</td>';

                            echo '<td>' . str($licence->end_date)->replace('-', '/') . '</td>';

                            echo "<td>
                                    <a href='/dashboard/licence/info.php?id={$licence->id}' class='btn btn-info btn-sm'>Info</a>
                                    <a href='/dashboard/licence/delete.php?id={$licence->id}' class='btn btn-danger btn-sm'>Delete</a>
                                  </td>";
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <a href="/dashboard/licence/new.php" class="btn btn-primary float-end">New Licence</a>
    </section>
    <?php import_js(); ?>
</body>
</html>
