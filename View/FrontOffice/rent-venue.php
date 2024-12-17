<?php
include __DIR__ . '/../../controller/eventcontroller.php';

$eventController = new EventController();
$events = $eventController->listEvents();

$pageTitle = "Festivals and Celebrations - Go Beyond";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Explore our festivals and celebrations - Go Beyond">
    <meta name="author" content="Go Beyond">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

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
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="rent-venue.php" class="active">Festivals and Celebrations</a></li>
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

    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Festivals and Celebrations</h2>
                    <span>Discover our exciting lineup of festivals and cultural celebrations</span>
                </div>
            </div>
        </div>
    </div>

    <div class="rent-venue-tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <div class="row mb-4">
                        <div class="col-lg-6 mx-auto">
                            <div class="input-group">
                                <input type="text" id="eventSearch" class="form-control" placeholder="Search for events...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="tabs">
                        <div class="col-lg-12">
                            <div class="heading-tabs">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <ul>
                                          <li><a href='#tabs-1'>Upcoming Festivals</a></li>
                                          <li><a href='#tabs-2'>Cultural Celebrations</a></li>
                                          <li><a href='#tabs-3'>Venue Information</a></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <section class='tabs-content'>
                                <article id='tabs-1'>
                                    <div class="row">
                                        <?php if ($events->rowCount() > 0): ?>
                                            <?php while ($event = $events->fetch(PDO::FETCH_ASSOC)): ?>
                                                <div class="col-lg-4 event-item" data-title="<?php echo htmlspecialchars(strtolower($event['title'])); ?>">
                                                <div class="event-item">
                                                    <div class="thumb">
                                                        <img src="assets/images/event-01.jpg" alt="<?php echo htmlspecialchars($event['title']); ?>">
                                                    </div>
                                                    <div class="down-content">
                                                        <h4><?php echo htmlspecialchars($event['title']); ?></h4>
                                                        <ul>
                                                            <li><i class="fa fa-clock-o"></i> <?php echo date('F j, Y', strtotime($event['date_start'])); ?></li>
                                                            <li><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($event['place']); ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <div class="col-lg-12">
                                                <p>No upcoming events at this time. Please check back later.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                                <article id='tabs-2'>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="heading">
                                                <h2>Cultural Celebrations</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="event-item">
                                                <div class="thumb">
                                                    <img src="assets/images/venue-01.jpg" alt="Cultural Event 1">
                                                </div>
                                                <div class="down-content">
                                                    <h4>Festival of Lights</h4>
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i> November 15, 2023</li>
                                                        <li><i class="fa fa-map-marker"></i> City Center Plaza</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="event-item">
                                                <div class="thumb">
                                                    <img src="assets/images/venue-02.jpg" alt="Cultural Event 2">
                                                </div>
                                                <div class="down-content">
                                                    <h4>Harvest Moon Festival</h4>
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i> September 29, 2023</li>
                                                        <li><i class="fa fa-map-marker"></i> Riverside Park</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="event-item">
                                                <div class="thumb">
                                                    <img src="assets/images/venue-03.jpg" alt="Cultural Event 3">
                                                </div>
                                                <div class="down-content">
                                                    <h4>Winter Solstice Celebration</h4>
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i> December 21, 2023</li>
                                                        <li><i class="fa fa-map-marker"></i> Mountain View Resort</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                                <article id='tabs-3'>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="heading">
                                                <h2>Venue Information</h2>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <img src="assets/images/venue-01.jpg" alt="Venue">
                                        </div>
                                        <div class="col-lg-6">
                                            <h4>Our Main Venue</h4>
                                            <p>Our state-of-the-art venue is perfect for hosting a wide range of events, from intimate gatherings to large-scale festivals. With a capacity of up to 10,000 people, cutting-edge sound and lighting systems, and flexible spaces, we can accommodate any type of celebration or performance.</p>
                                            <ul>
                                                <li>- 10,000 person capacity</li>
                                                <li>- Multiple stages and performance areas</li>
                                                <li>- On-site catering and refreshment options</li>
                                                <li>- Ample parking and easy access to public transportation</li>
                                                <li>- State-of-the-art audio and visual equipment</li>
                                            </ul>
                                            <div class="main-button">
                                                <a href="contact.php">Contact Us for Booking</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </section>
                        </div>
                    </div>
                </div>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('eventSearch');
        const eventItems = document.querySelectorAll('.event-item');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();

            eventItems.forEach(item => {
                const title = item.getAttribute('data-title');
                if (title.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>