<?php
    session_start();
    $dir = $_SERVER['DOCUMENT_ROOT'];
    require $dir."/func.php";
    require $dir."/models.php";
    require $dir."/components.php";

    use Ramsey\Uuid\Uuid;

    login_required();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = $_POST["name"];
        $active_status = $_POST["active"];
        $limit_status = $_POST["limit-status"];
        $limit_device = $_POST["limit-device"];
        $end_date = $_POST["end_date"];

        $new_licence = Licence::create([
            "name" => $name,
            "active" => $active_status,
            "limit_device" => $limit_status ? $limit_device : Null,
            "end_date" => $end_date,
            "uuid" => Uuid::uuid4()->toString()
        ]);

        $_SESSION["flashes"][] = ["New licence created! ID:{$new_licence->id}", "info"];

        header("location: /dashboard.php");
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Licence</title>
    <?php import_css(); ?>
</head>
<body data-bs-theme="dark">
    <?php navbar(); ?>

    <section class="container-sm mt-5">
        <div class="card bg-dark text-light shadow-lg">
            <div class="card-body">
                <h1 class="display-5 fw-bold text-center mb-4">New Licence</h1>
                <hr class="border-light">
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Licence Name</label>
                        <input type="text" name="name" class="form-control" maxlength="255" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" id="active" name="active" checked>
                                <label class="form-check-label" for="active">Status</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input" id="limit-status" name="limit-status">
                                <label class="form-check-label" for="limit-status">Limit Devices</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="limit-device" class="form-label">Max Device</label>
                        <input type="number" name="limit-device" class="form-control" max="15" min="1" value="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Licence End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Create Licence</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const limitStatusCheckbox = document.getElementById("limit-status");
            const limitDeviceInput = document.querySelector("input[name='limit-device']");

            function toggleLimitDevice() {
                limitDeviceInput.disabled = !limitStatusCheckbox.checked;
            }

            // Sayfa yüklendiğinde ilk durumu kontrol et
            toggleLimitDevice();

            // Checkbox değiştiğinde input durumunu güncelle
            limitStatusCheckbox.addEventListener("change", toggleLimitDevice);
        });
    </script>

    <?php import_js(); ?>
</body>
</html>
