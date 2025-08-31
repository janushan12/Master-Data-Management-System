<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM master_categories WHERE id = $id");
$category = $res->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"];
    $name = $_POST["name"];
    $stmt = $conn->prepare("UPDATE master_categories SET code=?, name=? WHERE id=?");
    $stmt->bind_param("ssi", $code, $name, $id);
    $stmt->execute();
    header("Location: list.php");
}
?>

<!-- <h1>Edit Category</h1>
<form method="post">
    Code: <input type="text" name="code" value="<?= $category['code'] ?>" required><br>
    Name: <input type="text" name="name" value="<?= $category['name'] ?>" required><br>
    <button type="submit">Update</button>
</form> -->
<html>
    <head>
        <title>Edit Category</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Category</h5>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="categoryCode" class="form-label">Category Code</label>
                        <input type="text" name="code" id="categoryCode" class="form-control" value="<?= $category['code'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" name="name" id="categoryName" class="form-control" value="<?= $category['name'] ?>" required>
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