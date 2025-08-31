<?php
include "../includes/auth.php";
include "../includes/db.php";

$user_id = $_SESSION["user_id"];
$is_admin = $_SESSION["is_admin"];

// Pagination
$limit = 5;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$offset = ($page -1) * $limit;

// search & filter (Active/Inactive)
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$statusFilter = isset($_GET["status"]) ? $_GET["status"] : "";

// count tot recs
$countSql = $is_admin
        ? "SELECT COUNT(*) AS total FROM master_brands"
        : "SELECT COUNT(*) AS total FROM master_brands WHERE user_id = $user_id";

$countResult = $conn->query($countSql);
$countRow = $countResult->fetch_assoc();
$totalRecords = $countRow["total"];
$totalPages = ceil($totalRecords / $limit);

// Base query
$sql = $is_admin
        ? "SELECT * FROM master_brands WHERE 1"
        : "SELECT * FROM master_brands WHERE user_id = $user_id";

// Apply search
if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR code LIKE '%$search%')";
}

// Apply filter
if (!empty($statusFilter)) {
    $sql .= " AND status = '$statusFilter'";
}

// Add pagination
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<html>
    <head>
        <title>Brand List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <div class="sidebar">
            <h4 class="text-center mb-4">My Dashboard</h4>
            <a href="../index.php"><i class="bi bi-house-door"></i>Home</a>
            <a href="../brand/list.php" class="active"><i class="bi bi-tags"></i> Brands</a>
            <a href="../category/list.php"><i class="bi bi-folder"></i> Categories</a>
            <a href="../item/list.php"><i class="bi bi-box"></i> Items</a>
            <a href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand">Welcome, <?= htmlspecialchars($_SESSION['user_id']); ?></span>
                <div class="d-flex">
                    <a href="logout.php" class="btn btn-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="row">
                <div class="col-md">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            Brands
                            <form method="GET" class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name/code" value="<?= htmlspecialchars($search) ?>">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="Active" <?= $statusFilter == 'Active' ? 'selected' : '' ?>>Active</option>
                                        <option value="Inactive" <?= $statusFilter == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Filter</button>
                                    <a href="list.php" class="btn btn-secondary btn-sm w-100">Reset Filter</a>
                                </div>
                                <a href="create.php">+ Add Brand</a>
                            </form>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result->num_rows > 0) : ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['status'] ?></td>
                                            <td>
                                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a> |
                                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this brand?')">Delete</a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr><td colspan="4" class="text-center">No records found</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <nav>
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>&search=<?= $search ?>&status=<?= $statusFilter ?>">Prev</a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>&status=<?= $statusFilter ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $totalPages): ?>
                                        <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>&search=<?= $search ?>&status=<?= $statusFilter ?>">Next</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>