<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"];
    $name = $_POST["name"];
    $user_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("INSERT INTO master_brands (code, name, status, user_id) VALUES (?, ?, 'Active', ?)");
    $stmt->bind_param("ssi", $code, $name, $user_id);
    $stmt->execute();
    header("Location: list.php");
}
?>

<html>
    <head>
        <title>Add Brand</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Brand</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="brandCode" class="form-label">Brand Code</label>
                        <input type="text" name="code" id="brandCode" class="form-control" placeholder="Enter brand code" required>
                    </div>

                    <div class="mb-3">
                        <label for="brandName" class="form-label">Brand Name</label>
                        <input type="text" name="name" id="brandName" class="form-control" placeholder="Enter brand name" required>
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