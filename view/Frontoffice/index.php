<?php
include __DIR__ . '/../../controller/eventcontroller.php';

$eventController = new EventController();
$events = $eventController->listEvents();

$pageTitle = "Go Beyond";
$showStartingIn = "15 Days";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Go Beyond - Your premier event management company">
    <meta name="author" content="Go Beyond">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title><?php echo $pageTitle; ?></title>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="assets/css/owl-carousel.css">
    <link rel="stylesheet" href="assets/css/tooplate-artxibition.css">
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
    
    <!-- ***** Pre Header ***** -->
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <span>Hey! The Show is Starting in <?php echo $showStartingIn; ?>.</span>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="text-button">
                        <a href="rent-venue.php">Contact Us Now! <i class="fa fa-arrow-right"></i></a>
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
                        <a href="index.php" class="logo">Go<em>Beyond</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="rent-venue.php">Festivals and Celebrations</a></li>
                            <li><a href="shows-events.php">Shows & Events</a></li> 
                            <li><a href="tickets.php">Tickets</a></li> 
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

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner">
        <div class="counter-content">
            <ul>
                <li>Days<span id="days"></span></li>
                <li>Hours<span id="hours"></span></li>
                <li>Minutes<span id="minutes"></span></li>
                <li>Seconds<span id="seconds"></span></li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <div class="next-show">
                            <i class="fa fa-arrow-up"></i>
                            <span>Next Show</span>
                        </div>
                        <?php 
                        $nextEvent = $events->fetch(PDO::FETCH_ASSOC);
                        if ($nextEvent): 
                        ?>
                            <h6>Opening on <?php echo date('l, F jS', strtotime($nextEvent['date_start'])); ?></h6>
                            <h2><?php echo htmlspecialchars($nextEvent['title']); ?></h2>
                            <div class="main-white-button">
                                <a href="ticket-details.php?id=<?php echo $nextEvent['id']; ?>">Purchase Tickets</a>
                            </div>
                        <?php else: ?>
                            <h6>No upcoming events</h6>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- *** Upcoming Events ***-->
    <div class="coming-events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Upcoming Events</h2>
                </div>
                <?php 
                $events->execute(); // Reset the cursor
                $eventCount = 0;
                while ($event = $events->fetch(PDO::FETCH_ASSOC)):
                    if ($eventCount >= 3) break; // Limit to 3 events
                ?>
                    <div class="col-lg-4">
                        <div class="event-item">
                            <div class="thumb">
                                <a href="event-details.php?id=<?php echo $event['id']; ?>">
                                    <img src="assets/images/event-01.jpg" alt="<?php echo htmlspecialchars($event['title']); ?>">
                                </a>
                            </div>
                            <div class="down-content">
                                <a href="event-details.php?id=<?php echo $event['id']; ?>">
                                    <h4><?php echo htmlspecialchars($event['title']); ?></h4>
                                </a>
                                <ul>
                                    <li><i class="fa fa-clock-o"></i> <?php echo date('l: H:i', strtotime($event['date_start'])); ?></li>
                                    <li><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($event['place']); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php 
                    $eventCount++;
                endwhile; 
                
                if ($eventCount == 0):
                ?>
                    <div class="col-lg-12">
                        <p>No upcoming events at this time. Please check back later.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- *** Footer *** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="address">
                        <h4>Go Beyond Festival Address</h4>
                        <span>5 College St NW, <br>Norcross, GA 30071<br>United States</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="#">Info</a></li>
                            <li><a href="#">Venues</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Videos</a></li>
                            <li><a href="#">Outreach</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hours">
                        <h4>Open Hours</h4>
                        <ul>
                            <li>Mon to Fri: 10:00 AM to 8:00 PM</li>
                            <li>Sat - Sun: 11:00 AM to 4:00 PM</li>
                            <li>Holidays: Closed</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <p>São Conrado, Rio de Janeiro</p>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <p class="copyright">Copyright 2023 Go Beyond Company 
                    
                                <br>Design: <a rel="nofollow" href="https://www.tooplate.com" target="_parent">Tooplate</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
