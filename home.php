<?php 
  session_start();
  ob_start();
  include "config/koneksi.php";

  $name = isset($_SESSION['NAME']) ? $_SESSION['NAME'] : '' ;
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
  <link rel="shortcut icon" type="image/png" href="flexy-bootstrap-lite-1.0.0/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="flexy-bootstrap-lite-1.0.0/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        <a class="d-flex justify-content-center" href="#">
          <img src="flexy-bootstrap-lite-1.0.0/assets/images/logos/logo-wrappixel.svg" alt="" width="150">
        </a>

        
      </div>    

      <div class="d-lg-flex align-items-center gap-2">
        <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center">Check Flexy Premium Version</h3>
        <div class="d-flex align-items-center justify-content-center gap-2">
          
          <div class="dropdown d-flex">
            <a class="btn btn-primary d-flex align-items-center gap-1 " href="javascript:void(0)" id="drop4"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="ti ti-shopping-cart fs-5"></i>
              Buy Now
              <i class="ti ti-chevron-down fs-5"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
    <!-- Sidebar Start -->
     <?php include "inc/sidebar.php" ?>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ti ti-bell"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="message-body">
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 1
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 2
                  </a>
                </div>
              </div>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
               
              <li class="nav-item dropdown">
                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="flexy-bootstrap-lite-1.0.0/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $name ?> Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <!-- buat auth nya login -->
                    <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!--  Row 1 -->
          <div class="row">
            <?php 
                  if (isset($_GET['page'])) {
              if (file_exists("content/" . $_GET['page'] . ".php")) {
              include ('content/' . $_GET['page'] . ".php");
                } else {
                    include 'content/notFound.php';
                  }
          } else {
            include 'content/order_pickup.php';
            
          }
            ?>
          </div>
          <div class="py-6 px-6 text-center">
            <p class="mb-0 fs-4">Design and Developed by <a href="#"
                class="pe-1 text-primary text-decoration-underline">Wrappixel.com</a> Distributed by <a href="https://themewagon.com" target="_blank" >ThemeWagon</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="flexy-bootstrap-lite-1.0.0/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/js/sidebarmenu.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/js/app.min.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="flexy-bootstrap-lite-1.0.0/assets/js/dashboard.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>