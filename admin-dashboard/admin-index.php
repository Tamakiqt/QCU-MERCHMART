

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

   <!-- Check if the products section should be displayed -->
   <?php if (isset($_GET['section']) && $_GET['section'] === 'products'): ?>
      <h2>Products</h2>
      <div class="row mb-3">
        <div class="col-md-6">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-6">
          <select class="form-select">
            <option selected>Category</option>
            <option value="1">Category 1</option>
            <option value="2">Category 2</option>
          </select>
        </div>
      </div>

      <div class="row">
        <!-- Product Cards -->
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 1</h5>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 2</h5>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 3</h5>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 4</h5>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 5</h5>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="product-card" onclick="selectProduct(this)">
            <input type="checkbox" class="form-check-input" />
            <h5>Product 6</h5>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between">
        <button class="btn btn-danger">Delete</button>
        <button class="btn btn-success">Add</button>
        <button class="btn btn-primary">Edit</button>
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
    <!-- Orders Section -->
    <h2 class="mb-4">Customers</h2>

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
                    <option selected>Customer Status</option>
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
                <tr>
                    <td><input type="checkbox"></td>
                    <td>23-0000</td>
                    <td>Juan</td>
                    <td>Tamad </td>
                    <td>JuanTamad</td>
                    <td>juan@gmail.com</td>
                    <td>09123456789</td>
                    <td>11-21-2024</td>

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




    <?php elseif (isset($_GET['section']) && $_GET['section'] === 'settings'): ?>
<h2 class="mb-4">Change Password</h2>

<div class="border rounded p-4">
  <form action="change-password.php" method="POST">
    <div class="mb-3">
      <label for="currentPassword" class="form-label">Current Password</label>
      <input type="password" id="currentPassword" name="current_password" class="form-control" placeholder="Current Password" required>
    </div>

    <div class="mb-3">
      <label for="newPassword" class="form-label">New Password</label>
      <input type="password" id="newPassword" name="new_password" class="form-control" placeholder="New Password" required>
    </div>

    <div class="mb-3">
      <label for="confirmPassword" class="form-label">Confirm Password</label>
      <input type="password" id="confirmPassword" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
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
                <a href="admin-login.php" class="btn btn-primary">Logout</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="admin.js"></script>

</body>
</html>