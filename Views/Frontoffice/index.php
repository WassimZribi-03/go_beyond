<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config.php';
require_once '../../Controllers/TourController.php';
require_once '../../Controllers/BookingController.php';

try {
    $tourController = new TourController();
    $bookingController = new BookingController();

    // Get featured content
    $featuredTours = $tourController->getFeaturedTours(3);
    
    // Page metadata
    $pageTitle = 'Go Beyond';
    $currentPage = 'home';
} catch (Exception $e) {
    error_log("Error in index.php: " . $e->getMessage());
}

include_once 'layout/header.php';
?>

<main>
    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <h2>Welcome to Go Beyond</h2>
                        <div class="main-white-button">
                            <a href="/go_beyond-event/view/Frontoffice/shows-events.php">Explore Events</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- *** Amazing Venus ***-->
    <div class="amazing-venues">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="left-content">
                        <h4>Three Amazing Venues for Events</h4>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="right-content">
                        <h5><i class="fa fa-map-marker"></i> Visit Us</h5>
                        <span>5 College St NW, <br>Norcross, GA 30071<br>United States</span>
                        <div class="text-button"><a href="show-events-details.html">Need Directions? <i class="fa fa-arrow-right"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- *** Map ***-->
    <div class="map-image">
        <img src="/accomodation/assets/images/map-image.jpg" alt="Maps of 3 Venues">
    </div>

    <!-- *** Venues & Tickets ***-->
    <div class="venue-tickets">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Our Venues & Tickets</h2>
                    </div>
                </div>
                <?php 
                if (!empty($featuredTours)):
                    foreach($featuredTours as $index => $tour): 
                        $imageUrl = !empty($tour['image_url']) ? $tour['image_url'] : '/accomodation/assets/images/venue-0' . ($index + 1) . '.jpg';
                ?>
                <div class="col-lg-4">
                    <div class="venue-item">
                        <div class="thumb">
                            <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                        </div>
                        <div class="down-content">
                            <div class="left-content">
                                <div class="main-white-button">
                                    <a href="ticket-details.php?id=<?php echo $tour['id']; ?>">Purchase Tickets</a>
                                </div>
                            </div>
                            <div class="right-content">
                                <h4><?php echo htmlspecialchars($tour['title']); ?></h4>
                                <p><?php echo htmlspecialchars($tour['description']); ?></p>
                                <ul>
                                    <li><i class="fa fa-sitemap"></i><?php echo $tour['capacity']; ?></li>
                                    <li><i class="fa fa-user"></i><?php echo $tour['attendees']; ?></li>
                                </ul>
                                <div class="price">
                                    <span>1 ticket<br>from <em>dt<?php echo $tour['price']; ?></em></span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else:
                    // Fallback content if no tours
                    $defaultTours = [
                        ['title' => 'The Festival of the Sahara', 'description' => 'The Festival of the Sahara in Tozeur is a yearly celebration showcasing the rich cultural heritage of Tunisia\'s desert communities', 'capacity' => 200, 'attendees' => 400, 'price' => 45],
                        ['title' => 'International Festival Of Carthage', 'description' => 'This is a festival held in Carthage and happens to attract people from around the world.', 'capacity' => 450, 'attendees' => 650, 'price' => 55],
                        ['title' => 'International Festival of Bizerte', 'description' => 'This is another one of the long-lasting festivals that Tunisia boasts.', 'capacity' => 350, 'attendees' => 550, 'price' => 65]
                    ];
                    foreach($defaultTours as $index => $tour):
                ?>
                <div class="col-lg-4">
                    <div class="venue-item">
                        <div class="thumb">
                            <img src="/accomodation/assets/images/venue-0<?php echo $index + 1; ?>.jpg" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                        </div>
                        <div class="down-content">
                            <div class="left-content">
                                <div class="main-white-button">
                                    <a href="#">Purchase Tickets</a>
                                </div>
                            </div>
                            <div class="right-content">
                                <h4><?php echo htmlspecialchars($tour['title']); ?></h4>
                                <p><?php echo htmlspecialchars($tour['description']); ?></p>
                                <ul>
                                    <li><i class="fa fa-sitemap"></i><?php echo $tour['capacity']; ?></li>
                                    <li><i class="fa fa-user"></i><?php echo $tour['attendees']; ?></li>
                                </ul>
                                <div class="price">
                                    <span>1 ticket<br>from <em>dt<?php echo $tour['price']; ?></em></span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>
    </div>
</main>

<?php include_once 'layout/footer.php'; ?> 