<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM master_brands WHERE id = $id");
$brand = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"];
    $name = $_POST["name"];
    $stmt = $conn->prepare("UPDATE master_brands SET code=?, name=? WHERE id=?");
    $stmt->bind_param("ssi", $code, $name, $id);
    $stmt->execute();
    header("Location: list.php");
}
?>

<html>
    <head>
        <title>Edit Brand</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Brand</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="brandCode" class="form-label">Brand Code</label>
                        <input type="text" name="code" id="brandCode" class="form-control" value="<?= $brand['code'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="brandName" class="form-label">Brand Name</label>
                        <input type="text" name="name" id="brandName" class="form-control" value="<?= $brand['name'] ?>" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="list.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>