<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h6 {
            color: #007bff;
        }
        .form-container .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .form-container .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h6 class="mb-4 text-center">Setting</h6>
                    <form action="<?= base_url('home/editsetting') ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="namaWeb">Nama Web</label>
        <input type="text" value="<?= $darren2->nama_website ?>" class="form-control" name="namaWeb" id="namaWeb" placeholder="Nama Web">
    </div>

    <div class="form-group">
        <label for="iconTab">Tab Icon</label>
        <?php if ($darren2->icon_logo): ?>
            <img src="<?= base_url('img/' . $darren2->icon_logo) ?>" alt="Current Tab Icon" width="50" height="50">
        <?php endif; ?>
        <input type="file" class="form-control" name="iconTab" id="iconTab"  accept="image/png, image/jpeg, image/jpg">
    </div>

    <div class="form-group">
        <label for="logoDash">Icon Dashboard</label>
        <?php if ($darren2->logo_dashboard): ?>
            <img src="<?= base_url('img/' . $darren2->logo_dashboard) ?>" alt="Current Dashboard Icon" width="50" height="50">
        <?php endif; ?>
        <input type="file" class="form-control" name="logoDash" id="logoDash" accept="image/png, image/jpeg, image/jpg">
    </div>

    <div class="form-group">
        <label for="logoLogin">Icon Login</label>
        <?php if ($darren2->logo_login): ?>
            <img src="<?= base_url('img/' . $darren2->logo_login) ?>" alt="Current Login Icon" width="50" height="50">
        <?php endif; ?>
        <input type="file" class="form-control" name="logoLogin" id="logoLogin" accept="image/png, image/jpeg, image/jpg">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary btn-block">Save</button>
</form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>