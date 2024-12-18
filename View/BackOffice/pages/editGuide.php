
<?php

include '../../../Controller/guidecontroller.php';



$error = "";

$guide= null;
// create an instance of the controller
$guideC = new GuideTouristiqueController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize inputs
  $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
  $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
  $language = filter_var($_POST['language'], FILTER_SANITIZE_STRING);
  $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
  $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
  $region = filter_var($_POST['region'], FILTER_SANITIZE_STRING);
  $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);

  if ($price > 0 && !empty($title) && !empty($description)) {
      $guide = new Guide(null, $title, $description, $language, $price, $category, $region, $country);
      $guideC->updateGuide($guide, $_POST['id']);
      header("Location: guideList.php");
  } else {
      $error = "Please ensure all fields are valid.";
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Argon Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Go beyond</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
   <!-- MENU -->
   <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
       
        <li class="nav-item">
          <a class="nav-link " href="../pages/guideList.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Guides</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/disponibilitelist.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Disponibilites Guides</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/listeevent.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Events</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/listecategorie.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Events Categories</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Guides</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Guides</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign In</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
          
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Guide</p>
              
              </div>
            </div>
            <?php
    if (isset($_GET["id"])) {
        $guide = $guideC->showGuide($_GET["id"]);
       
    ?>
   <?php if ($guide): ?>
<form method="POST" action="" id="editGuideForm">
    <div class="card-body">
        <p class="text-uppercase text-sm">Guide Information</p>
        <div class="row">
            <input class="form-control" type="hidden" name="id" value="<?php echo $guide['id']; ?>">
 <!-- Title -->
 <div class="col-md-12">
              <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" id="title"  value="<?php echo $guide['title']; ?>"/>
                <small class="text-danger" id="titleError"></small>
              </div>
            </div>
            <!-- Description -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" rows="4" name="description" id="description"><?php echo $guide['description']; ?></textarea>
                <small class="text-danger" id="descriptionError"></small>
              </div>
            </div>
         
          
           <!-- Language -->
<div class="col-md-12">
  <div class="form-group">
    <label for="language">Language</label>
    <select class="form-control" name="language" id="language">
      <option value="">Choose...</option>
      <option value="French" <?php echo ($guide['language'] === 'French') ? 'selected' : ''; ?>>French</option>
      <option value="English" <?php echo ($guide['language'] === 'English') ? 'selected' : ''; ?>>English</option>
      <option value="Arabic" <?php echo ($guide['language'] === 'Arabic') ? 'selected' : ''; ?>>Arabic</option>
      <option value="Spanish" <?php echo ($guide['language'] === 'Spanish') ? 'selected' : ''; ?>>Spanish</option>
      <option value="German" <?php echo ($guide['language'] === 'German') ? 'selected' : ''; ?>>German</option>
      <option value="Italian" <?php echo ($guide['language'] === 'Italian') ? 'selected' : ''; ?>>Italian</option>
      <option value="Mandarin" <?php echo ($guide['language'] === 'Mandarin') ? 'selected' : ''; ?>>Mandarin</option>
    </select>
    <small class="text-danger" id="languageError"></small>
  </div>
</div>

           

           
        </div>
        <hr class="horizontal dark">
        <p class="text-uppercase text-sm">Publication Details</p>
       
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-control-label">Price</label>
                    <input class="form-control" name="price" type="number" id='price' value="<?php echo $guide['price']; ?>">
                </div>
            </div>
           <!-- Category -->
<div class="col-md-12">
  <div class="form-group">
    <label for="category">Category</label>
    <select class="form-control" name="category" id="category">
      <option value="">Choose...</option>
      <option value="Historical Sites" <?php echo ($guide['category'] === 'Historical Sites') ? 'selected' : ''; ?>>Historical Sites</option>
      <option value="Museums" <?php echo ($guide['category'] === 'Museums') ? 'selected' : ''; ?>>Museums</option>
      <option value="Beaches" <?php echo ($guide['category'] === 'Beaches') ? 'selected' : ''; ?>>Beaches</option>
      <option value="Deserts" <?php echo ($guide['category'] === 'Deserts') ? 'selected' : ''; ?>>Deserts</option>
      <option value="Cultural Events" <?php echo ($guide['category'] === 'Cultural Events') ? 'selected' : ''; ?>>Cultural Events</option>
      <option value="Outdoor Activities" <?php echo ($guide['category'] === 'Outdoor Activities') ? 'selected' : ''; ?>>Outdoor Activities</option>
    </select>
    <small class="text-danger" id="categoryError"></small>
  </div>
</div>

      
        <div class="row">
            <!-- Country and Region -->
<div class="col-md-6">
  <div class="form-group">
    <label for="country">Country</label>
    <select class="form-control" name="country" id="country">
      <option value="">Choose...</option>
      <option value="Tunisia" <?php echo ($guide['country'] === 'Tunisia') ? 'selected' : ''; ?>>Tunisia</option>
    </select>
    <small class="text-danger" id="countryError"></small>
  </div>

  <div class="form-group mt-3">
    <label for="region">Region</label>
    <select class="form-control" name="region" id="region">
      <option value="">Choose...</option>
      <option value="Tunis" <?php echo ($guide['region'] === 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
      <option value="Sfax" <?php echo ($guide['region'] === 'Sfax') ? 'selected' : ''; ?>>Sfax</option>
      <option value="Sousse" <?php echo ($guide['region'] === 'Sousse') ? 'selected' : ''; ?>>Sousse</option>
      <option value="Monastir" <?php echo ($guide['region'] === 'Monastir') ? 'selected' : ''; ?>>Monastir</option>
      <option value="Gabès" <?php echo ($guide['region'] === 'Gabès') ? 'selected' : ''; ?>>Gabès</option>
    </select>
    <small class="text-danger" id="regionError"></small>
  </div>
</div>


            <div class="row mt-4">
            <div class="col-md-12 d-flex  justify-content-between">
              
              <button type="button" class="btn btn-danger" onclick="history.back()">Cancel</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
       
    </div>
</form>
<?php else: ?>
<p>No guide found for the given ID.</p>
<?php endif; ?>

      <?php
    }
    ?>
   
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Argon Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div>
  <script>
   document.getElementById('editGuideForm').addEventListener('submit', function (e) {

    e.preventDefault();

    // Clear previous error messages
    const errorFields = document.querySelectorAll('.text-danger');
    errorFields.forEach((error) => (error.textContent = ''));

    let isValid = true;

    // Title validation
    const title = document.getElementById('title');
    if (title.value.trim().length < 3) {
        document.getElementById('titleError').textContent = 'Title must be at least 3 characters.';
        isValid = false;
    }

    // Description validation
    const description = document.getElementById('description');
    if (description.value.trim().length < 3) {
        document.getElementById('descriptionError').textContent = 'Description must be at least 3 characters.';
        isValid = false;
    }

    // Language validation
    const language = document.getElementById('language');
    if (language.value === '') {
        document.getElementById('languageError').textContent = 'Please select a language.';
        isValid = false;
    }

    // Price validation

   const price = document.getElementById('price');
      if (price.value === '' || parseFloat(price.value) <= 0) {
        document.getElementById('priceError').textContent = 'Price must be a positive number.';
        isValid = false;
      }


    // Category validation
    const category = document.getElementById('category');
    if (category.value.trim() === '') {
        document.getElementById('categoryError').textContent = 'Category is required.';
        isValid = false;
    }

    // Country validation
    const country = document.getElementById('country');
    if (country.value === '') {
        document.getElementById('countryError').textContent = 'Please select a country.';
        isValid = false;
    }

    // Region validation
    const region = document.getElementById('region');
    if (region.value === '') {
        document.getElementById('regionError').textContent = 'Please select a region.';
        isValid = false;
    }

    // If not valid, prevent form submission
    if (isValid) {
        e.target.submit();  // Submit the form programmatically
    }
});
  </script>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>