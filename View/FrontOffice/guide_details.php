<?php
include(__DIR__ . '/../../Controller/guidecontroller.php');
include(__DIR__ . '/../../Controller/disponibilitecontroller.php');
include(__DIR__ . '/../../Controller/reservationcontroller.php');

$guideC = new GuideTouristiqueController();
$dispoC = new DisponibilitesGuidesController();
$reservC = new ReservationController();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_GET["id"]) && 
        isset($_POST["disponibility"]) && 
        !empty($_POST["disponibility"])
    ) {
 
       
            $reservation = new Reservation(
                null,
                1,   
                $_GET['id'], 
                $_POST['disponibility'],
               
            );

            $reservC->addReservation($reservation);

         
            header('Location: index.php');
            exit;
       
    } else {
      
        $error = "Please select a disponibility.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Tooplate">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title>ArtXibition Ticket Detail Page</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" type="text/css" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/tooplate-artxibition.css">
<!--

Tooplate 2125 ArtXibition

https://www.tooplate.com/view/2125-artxibition

-->
    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <!-- ***** Preloader End ***** -->
    
    <!-- ***** Pre HEader ***** -->
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <span>Hey! The Show Is Starting In 5 Days.</span>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="text-button">
                        <a href="rent-venue.html">Contact Us Now! <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">Go<em>Beyond</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="rent-venue.html">festivals and celebrations</a></li>
                            <li><a href="shows-events.html">Shows & Events</a></li> 
                            <li><a href="tickets.html" class="active">Tickets</a></li> 
                        </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** About Us Page ***** -->
    <div class="page-heading-shows-events">
        <div class="container">
            <div class="row">
            <div class="col-lg-12">
    <h2>Book Your Guide Now!</h2>
    <span>Explore upcoming guided tours and book your experience today. Don't miss out on the adventure!</span>
</div>

            </div>
        </div>
    </div>
    <?php
if (isset($_GET["id"])) {
    $guide = $guideC->showGuide($_GET["id"]);
    $dispo = $dispoC->listDisponibilitiesByGuide($_GET["id"]);
?>
    <div class="guide-details-page">
        <div class="container mt-4 mb-4">
            <div class="d-flex justify-content-around">
                <!-- Left Column (Guide Image) -->
              
                    <div class="left-image">
                        <img src="assets/images/guide.jpg" alt="Guide Image" class="img-fluid rounded">
                    </div>
               

                <!-- Right Column (Guide Details & Booking Form) -->
                
                    <div class="right-content col-md-6">
                        <h4><?php echo htmlspecialchars($guide['title']); ?></h4>
                        <span><?php echo htmlspecialchars($guide['description']); ?></span>
                        
                        <!-- Guide Details -->
                        <div class="mt-3 mb-3">
                            <p>
                                <i class="fa fa-language me-1"></i> 
                                This guide is available in <strong><?php echo htmlspecialchars($guide['language']); ?></strong>.
                            </p>
                            <p>
                                <i class="fa fa-money me-1"></i> 
                                The price for this guide is <strong><?php echo htmlspecialchars($guide['price']); ?> TND</strong>.
                            </p>
                        </div>

                        <!-- Booking Form -->
                        <div class="card" style="box-shadow: 2px 2px 5px rgba(0,0,0,0.1); border-radius: 8px; padding: 20px;">
                            <div class="text-center mb-3">
                                <h5 style="font-size: 18px; font-weight: bold;">Choose Availability</h5>
                            </div>

                            <form action="" method="POST" onsubmit="return validateForm();">
                                <div class="d-flex flex-column gap-3">
                                    <?php foreach ($dispo as $availability) { ?>
                                        <label class="card availability-option" 
                                               style="cursor: pointer; padding: 15px; border: 1px solid #ddd; border-radius: 8px; text-align: center; transition: all 0.3s ease;">
                                            <input type="radio" name="disponibility" value="<?php echo $availability['id']; ?>" style="display: none;">
                                            <div>
                                                <strong><?php echo htmlspecialchars($availability['available_date']); ?></strong>
                                                <p><?php echo htmlspecialchars($availability['start_time']); ?> - <?php echo htmlspecialchars($availability['end_time']); ?></p>
                                            </div>
                                        </label>
                                    <?php } ?>

                                    <input type="hidden" name="guide_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

                                    <!-- Submit Button -->
                                    <div class="main-dark-button text-center" style="padding: 12px 20px; background-color: #333; color: #fff; border-radius: 5px; cursor: pointer; font-weight: bold;" type="submit">
                                        Book Now
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
              
            </div>
        </div>
    </div>
<?php
}
?>


    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/mixitup.js"></script> 
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/quantity.js"></script>
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    <script>
    document.querySelectorAll('.availability-option').forEach(option => {
        option.addEventListener('click', () => {
           
            document.querySelectorAll('.availability-option').forEach(opt => {
                opt.style.backgroundColor = ''; // Reset background color
            });

           
            option.style.backgroundColor = '#d4edda'; // Light green for selection
        });
    });
</script>
<script>
function validateForm() {
    const radios = document.querySelectorAll('input[name="disponibility"]');
    let selected = false;

    radios.forEach(radio => {
        if (radio.checked) {
            selected = true;
        }
    });

    if (!selected) {
        alert('Please select a disponibility option.');
        return false;
    }

    return true;
}
</script>
  </body>

</html>
