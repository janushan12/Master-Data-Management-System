<?php
include '../includes/auth.php';
include '../includes/db.php';

$id = $_SESSION['user_id'];
$brands = $conn->query("SELECT * FROM master_brands WHERE user_id=$id");
$categories = $conn->query("SELECT *FROM master_categories WHERE user_id=$id");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"];
    $name = $_POST["name"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];
    $user_id = $_SESSION["user_id"];

    $filename = "";
    if (!empty($_FILES["attachment"]["name"])) {
        $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
        move_uploaded_file($_FILES["attachment"]["tmp_name"], "../uploads/" . $filename);
    }

    $stmt = $conn->prepare("INSERT INTO master_items (code, name, brand_id, category_id, attachment, status, user_id) VALUES (?, ?, ?, ?, ?, 'Active', ?)");
    $stmt->bind_param("ssissi", $code, $name, $brand_id, $category_id, $filename, $user_id);
    $stmt->execute();
    header("Location: list.php");
}
?>
<html>
    <head>
        <title>Add Item</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>
    <body class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Item</h5>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="itemCode" class="form-label">Item Code</label>
                        <input type="text" name="code" id="itemCode" class="form-control" placeholder="Enter item code" required>
                    </div>

                    <div class="mb-3">
                        <label for="itemName" class="form-label">Item Name</label>
                        <input type="text" name="name" id="itemName" class="form-control" placeholder="Enter item name" required>
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <select name="brand_id" id="brand" class="form-select" required>
                            <option value="">Select Brand</option>
                            <?php while($b=$brands->fetch_assoc()) : ?>
                                    <option value="<?= $b['id'] ?>"><?= $b['name'] ?></option>
                                <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category_id" id="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php while($c=$categories->fetch_assoc()) : ?>
                                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" name="attachment" id="attachment" class="form-control">
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