<?php
session_start();
require_once '../server/dbcon.php';

error_log("Session status on index page: " . print_r($_SESSION, true));


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}


// Simple check for authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit();
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<style>
    body {
      font-family: poppins, sans-serif;
    }

    .modal-content {
    border-radius: 8px;
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}

#confirmDeleteBtn:hover {
    background-color: #dc3545;
    border-color: #dc3545;
}

    
  </style>

  <!-- Overlay for mobile sidebar -->
  <div class="overlay" id="overlay"></div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h4 class="text-center py-4">MERCHMART</h4>
    <div class="text-center mb-4">
      <img src="../assets/images/pfp.jpg" alt="Admin" class="rounded-circle profile-image">
      <h6 class="mt-2">Admin</h6>
    </div>
    <nav>
      <a href="admin-index.php" class="active-link" id="dashboardLink">Dashboard</a>
      <a href="admin-index.php?section=products" id="productsLink">Products</a>
      <a href="admin-index.php?section=orders" id="ordersLink">Orders</a>
      <a href="admin-index.php?section=customers" id="customersLink">Customers</a>
      <a href="admin-index.php?section=statistics" id="statisticsLink">Statistics</a>
      <a href="admin-index.php?section=settings" id="settingsLink">Settings</a>
      <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
    </nav>
  </div> 

  <!-- Navbar for mobile toggle -->
  <nav class="navbar navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
      <button class="btn btn-dark" id="toggleSidebar">
        <span class="navbar-toggler-icon"></span> Menu
      </button>
      <a class="navbar-brand ms-auto" href="#">MERCHMART</a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <h2 class="mb-4">Hello, Welcome Back!</h2>

    <?php if (isset($_GET['section']) && $_GET['section'] === 'products'): ?>
    <h2>Products</h2>
     <!-- Add this message display section -->
     <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-12 d-flex align-items-center filter-container">
        <form method="GET" action="" class="w-100">
    <input type="hidden" name="section" value="products">
    <div class="row g-2">
        <!-- Search Bar -->
        <div class="col-12 col-md-6">
            <input type="text" 
                   name="search" 
                   class="form-control search-bar" 
                   placeholder="Search" 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        
        <!-- Category Dropdown -->
        <div class="col-12 col-md-4">
            <select class="form-select category-dropdown" name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <optgroup label="School Uniforms">
                    <option value="lace" <?php echo $category === 'lace' ? 'selected' : ''; ?>>QCU Lanyards</option>
                    <option value="college" <?php echo $category === 'college' ? 'selected' : ''; ?>>QCU School Uniform</option>
                    <option value="pe" <?php echo $category === 'pe' ? 'selected' : ''; ?>>QCU P.E Uniform</option>
                    <option value="jackets" <?php echo $category === 'jackets' ? 'selected' : ''; ?>>QCU Jackets</option>
                    <option value="department" <?php echo $category === 'department' ? 'selected' : ''; ?>>Department Shirts</option>
                    <option value="shirts" <?php echo $category === 'shirts' ? 'selected' : ''; ?>>QCU T-Shirts</option>
                    <option value="holder" <?php echo $category === 'holder' ? 'selected' : ''; ?>>QCU ID Holder</option>
                </optgroup>
                <optgroup label="School Necessities">
                    <option value="clip" <?php echo $category === 'clip' ? 'selected' : ''; ?>>Hair Clips</option>
                    <option value="clutcher" <?php echo $category === 'clutcher' ? 'selected' : ''; ?>>Hair Clutchers</option>
                    <option value="tumblers" <?php echo $category === 'tumblers' ? 'selected' : ''; ?>>Tumblers</option>
                    <option value="tissue" <?php echo $category === 'tissue' ? 'selected' : ''; ?>>Tissue Paper</option>
                    <option value="umbrella" <?php echo $category === 'umbrella' ? 'selected' : ''; ?>>Umbrella</option>
                    <option value="wipes" <?php echo $category === 'wipes' ? 'selected' : ''; ?>>Wet Wipes</option>
                </optgroup>
            </select>
        </div>
        
    </div>
</form>
        <!-- Add Button (outside the form) -->
        <button type="button" class="btn btn-primary ms-3" style="width: 100px;" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add
        </button>
        </div>
    </div>
   
    <div class="row">
        <?php
        $limit = 12;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Fetch total records for pagination with search and category
        $countQuery = "SELECT COUNT(*) as total FROM products WHERE 1=1";
        if (!empty($search)) {
            $countQuery .= " AND product_name LIKE ?";
        }
        if (!empty($category)) {
            $countQuery .= " AND category = ?";
        }

        $countStmt = $con->prepare($countQuery);

        // Bind parameters based on filters
        if (!empty($search) && !empty($category)) {
            $searchTerm = "%" . $search . "%";
            $countStmt->bind_param("ss", $searchTerm, $category);
        } elseif (!empty($search)) {
            $searchTerm = "%" . $search . "%";
            $countStmt->bind_param("s", $searchTerm);
        } elseif (!empty($category)) {
            $countStmt->bind_param("s", $category);
        }

        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRow = $countResult->fetch_assoc();
        $totalRecords = $totalRow['total'];

        if ($totalRecords == 0) {
            ?>
            <div class="col-12 text-center">
                <div class="alert alert-info" role="alert">
                    No products found
                </div>
            </div>
            <?php
        } else {
            // Main query for products
            $query = "SELECT * FROM products WHERE 1=1";
            if (!empty($search)) {
                $query .= " AND product_name LIKE ?";
            }
            if (!empty($category)) {
                $query .= " AND category = ?";
            }
            $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

            $stmt = $con->prepare($query);

            // Bind parameters based on filters
            if (!empty($search) && !empty($category)) {
                $stmt->bind_param("ssii", $searchTerm, $category, $limit, $offset);
            } elseif (!empty($search)) {
                $stmt->bind_param("sii", $searchTerm, $limit, $offset);
            } elseif (!empty($category)) {
                $stmt->bind_param("sii", $category, $limit, $offset);
            } else {
                $stmt->bind_param("ii", $limit, $offset);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                ?>
             <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="product-card text-center p-3" data-id="<?php echo $row['id']; ?>">
        <input type="checkbox" class="form-check-input mb-2" />
        <div class="product-image mb-2">
            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" 
                alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                class="img-fluid">
        </div>
        <h5><?php echo htmlspecialchars($row['product_name']); ?></h5>
        <p class="price">₱<?php echo number_format($row['price'], 2); ?></p>
        <div class="action-buttons">
            <button type="button" 
                    class="btn btn-danger delete-btn" 
                    onclick="deleteProduct(<?php echo $row['id']; ?>)">
                Delete
            </button>
            <button class="btn btn-success">Edit</button>
        </div>
    </div>
</div>
                  <?php
            }
        }
        ?>
    </div>

    <?php if ($totalRecords > 0): ?>
    <nav aria-label="Page navigation" class="mt-3">
        <ul class="pagination justify-content-center">
            <?php
            $totalPages = ceil($totalRecords / $limit);
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?section=products&page=' . ($page - 1) . '&search=' . htmlspecialchars($search) . '&category=' . htmlspecialchars($category) . '">Previous</a></li>';
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li class="page-item' . ($i === $page ? ' active' : '') . '"><a class="page-link" href="?section=products&page=' . $i . '&search=' . htmlspecialchars($search) . '&category=' . htmlspecialchars($category) . '">' . $i . '</a></li>';
            }
            if ($page < $totalPages) {
                echo '<li class="page-item"><a class="page-link" href="?section=products&page=' . ($page + 1) . '&search=' . htmlspecialchars($search) . '&category=' . htmlspecialchars($category) . '">Next</a></li>';
            }
            ?>
        </ul>
    </nav>
    <?php endif; ?>




    <!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="addProductForm" action="add_product.php" method="POST" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="product_name" required>
                    </div>

                    <!-- Product Picture -->
                    <div class="mb-3">
                        <label for="productPicture" class="form-label">Product Picture</label>
                        <input type="file" class="form-control" id="productPicture" name="product_picture" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select Category</option>
                            <optgroup label="School Uniforms">
                                <option value="lace">QCU Lanyards</option>
                                <option value="college">QCU School Uniform</option>
                                <option value="pe">QCU P.E Uniform</option>
                                <option value="jackets">QCU Jackets</option>
                                <option value="department">Department Shirts</option>
                                <option value="shirts">QCU T-Shirts</option>
                                <option value="holder">QCU ID Holder</option>
                            </optgroup>
                            <optgroup label="School Necessities">
                                <option value="clip">Hair Clips</option>
                                <option value="clutcher">Hair Clutchers</option>
                                <option value="tumblers">Tumblers</option>
                                <option value="tissue">Tissue Paper</option>
                                <option value="umbrella">Umbrella</option>
                                <option value="wipes">Wet Wipes</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Stock Quantity -->
                    <div class="mb-3">
                    <label for="stockQuantity" class="form-label">Stock Quantity</label>
                    <input type="number" class="form-control" id="stockQuantity" name="stock_quantity" required>
                </div>


                    <div class="modal-footer px-0 pb-0">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>




    <?php elseif (isset($_GET['section']) && $_GET['section'] === 'orders'): ?>
    <!-- Orders Section -->
    <h2 class="mb-4">Orders</h2>

    <!-- Wrapper for Filter Bar and Orders Table -->
<div class="orders-section border rounded p-3 mb-4">
    <!-- Filter Bar -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <button class="btn btn-outline-secondary">Filter</button>
                <select class="form-select">
                    <option selected>Order Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <button class="btn btn-danger me-2">Delete</button>
            <button class="btn btn-success">Edit</button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Order Number</th>
                    <th>Student Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Total</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>00123</td>
                    <td>23-0000</td>
                    <td>Juan</td>
                    <td>Tamad</td>
                    <td>JuanTamad</td>
                    <td>2</td>
                    <td>11-21-2024</td>
                    <td>100.00</td>
                    <td>Unpaid</td>
                    <td>Pending</td>
                </tr>
                <!-- Add more rows dynamically -->
            </tbody>
        </table>
    </div>
</div>

        <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-3">
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
    </nav>



    <?php elseif (isset($_GET['section']) && $_GET['section'] === 'customers'): ?>
    <h2 class="mb-4">Customers</h2>

    <div class="orders-section border rounded p-3 mb-4">
        <form method="GET" action="">
            <input type="hidden" name="section" value="customers">
            <div class="row mb-3">
                <div class="col-md-6 col-12 mb-2">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
                
                
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Student Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($search)) {
                        // Fetch total records for pagination
                        $countQuery = "SELECT COUNT(*) as total FROM user";
                        $countStmt = $con->prepare($countQuery);
                        $countStmt->execute();
                        $totalResult = $countStmt->get_result();
                        $totalRow = $totalResult->fetch_assoc();
                        $totalRecords = $totalRow['total'];
                    
                        // Fetch records with limit and offset
                        $query = "SELECT id, student_number, first_name, last_name, name, email, phone, created_at FROM user LIMIT ? OFFSET ?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("ii", $limit, $offset);
                    } else {
                        // Fetch total records for pagination with search
                        $countQuery = "SELECT COUNT(*) as total FROM user WHERE 
                                       id LIKE ? OR 
                                       student_number LIKE ? OR 
                                       first_name LIKE ? OR 
                                       last_name LIKE ? OR 
                                       name LIKE ? OR 
                                       email LIKE ? OR 
                                       phone LIKE ? OR 
                                       created_at LIKE ?";
                        $searchTerm = "%" . $search . "%"; // Prepare the search term for LIKE
                        $countStmt = $con->prepare($countQuery);
                        $countStmt->bind_param("ssssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                        $countStmt->execute();
                        $totalResult = $countStmt->get_result();
                        $totalRow = $totalResult->fetch_assoc();
                        $totalRecords = $totalRow['total'];
                    
                        // Fetch records with limit and offset
                        $query = "SELECT id, student_number, first_name, last_name, name, email, phone, created_at FROM user WHERE 
                                  id LIKE ? OR 
                                  student_number LIKE ? OR 
                                  first_name LIKE ? OR 
                                  last_name LIKE ? OR 
                                  name LIKE ? OR 
                                  email LIKE ? OR 
                                  phone LIKE ? OR 
                                  created_at LIKE ? LIMIT ? OFFSET ?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("ssssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset);
                    }
                    
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['student_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No customers found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-3">
            <ul class="pagination justify-content-center">
                <?php
                $totalPages = ceil($totalRecords / $limit);
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?section=customers&page=' . ($page - 1) . '&search=' . htmlspecialchars($search) . '">Previous</a></li>';
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo '<li class="page-item' . ($i === $page ? ' active' : '') . '"><a class="page-link" href="?section=customers&page=' . $i . '&search=' . htmlspecialchars($search) . '">' . $i . '</a></li>';
                }
                if ($page < $totalPages) {
                    echo '<li class="page-item"><a class="page-link" href="?section=customers&page=' . ($page + 1) . '&search=' . htmlspecialchars($search) . '">Next</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>




    <?php elseif (isset($_GET['section']) && $_GET['section'] === 'settings'): ?>
<h2 class="mb-4">Change Password</h2>

<?php
// Display any messages
if (isset($_SESSION['password_message'])) {
    $messageClass = strpos($_SESSION['password_message'], 'success') !== false ? 'alert-success' : 'alert-danger';
    echo '<div class="alert ' . $messageClass . ' alert-dismissible fade show" role="alert">';
    echo $_SESSION['password_message'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['password_message']);
}
?>

<div class="border rounded p-4">
    <form action="change-password.php" method="POST">
        <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" id="currentPassword" name="current_password" class="form-control" 
                   placeholder="Enter current password" required>
        </div>

        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" id="newPassword" name="new_password" class="form-control" 
                   placeholder="Enter new password" required>
        </div>

        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirm_password" class="form-control" 
                   placeholder="Confirm new password" required>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-2" style="width: 100px; border: none;">Save</button>
            <button type="reset" class="btn btn-danger" style="width: 100px; background-color: #dc3545; border: none;">Cancel</button>
        </div>
    </form>
</div>












<?php elseif (isset($_GET['section']) && $_GET['section'] === 'statistics'): ?>
    <!-- Statistics Section -->
    <h2 class="mb-4">Statistics</h2>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="p-3 border rounded text-center">
                <h6>Total Sales:</h6>
                <h4>1000.00</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 border rounded text-center">
                <h6>Total Orders:</h6>
                <h4>100</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 border rounded text-center">
                <h6>Total Customers:</h6>
                <h4>50</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 border rounded text-center">
                <h6>Total Products:</h6>
                <h4>200</h4>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="p-3 border rounded text-center">
                <h5>Sales Over Time:</h5>
                <p>Graph here</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 border rounded text-center">
                <h5>Orders Over Time:</h5>
                <p>Graph here</p>
            </div>
        </div>
    </div>



    <?php else: ?>
      <!-- Dashboard Cards -->
      <div class="row g-4">
        <div class="col-md-4">
          <div class="p-3 bg-white text-center dashboard-card">
            <h6>Total Sales</h6>
            <h4>1000.00</h4>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 bg-white text-center dashboard-card">
            <h6>Total Orders</h6>
            <h4>100</h4>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3 bg-white text-center dashboard-card">
            <h6>Total Products</h6>
            <h4>100</h4>
          </div>
        </div>
      </div>

      <!-- Graphs Section -->
      <div class="row g-4 mt-4">
        <div class="col-md-12">
          <h5>Sales Statistics:</h5>
          <div class="graph-container">
            Graph here
          </div>
        </div>
        <div class="col-md-12 mt-4">
          <h5>Latest Orders:</h5>
          <div class="graph-container">
            Graph here
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  


  

 
<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <form action="admin.logout.php" method="GET">
                    <input type="hidden" name="redirect" value="admin-login.php">
                    <button type="submit" class="btn btn-primary">Logout</button>
          </form>
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script src="admin.js"></script>
  <script>
let productToDelete = null;
const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

function deleteProduct(productId) {
    if (!productId) {
        console.error('No product ID provided');
        return;
    }
    
    // Store the product ID and show the modal
    productToDelete = productId;
    deleteModal.show();
}

// Add event listener for the confirm delete button
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (!productToDelete) return;
    
    fetch('delete_product.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productToDelete
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        if (data.status === 'success') {
            // Find and remove the product card
            const productCard = document.querySelector(`[data-id="${productToDelete}"]`).closest('.col-12');
            if (productCard) {
                productCard.remove();
                // Show success message
                alert('Product deleted successfully!');
            }
        } else {
            alert('Error deleting product: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting product');
    })
    .finally(() => {
        // Hide the modal and reset the productToDelete
        deleteModal.hide();
        productToDelete = null;
    });
});

// Add this to verify the function is loaded
console.log('Delete function loaded');
</script>

</body>
</html>